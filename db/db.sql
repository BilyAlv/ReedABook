-- Eliminar la base de datos existente si existe
DROP DATABASE IF EXISTS readabook;

-- Crear nueva base de datos con codificación UTF8MB4
CREATE DATABASE readabook CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE readabook;

-- TABLA USUARIOS
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'admin', 'editor') DEFAULT 'usuario',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    ultimo_login DATETIME,
    INDEX idx_email (email)
) ENGINE=InnoDB;

-- TABLA CATEGORÍAS (debe crearse primero para las relaciones)
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- TABLA AUTORES (debe crearse primero para las relaciones)
CREATE TABLE autores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL UNIQUE,
    biografia TEXT,
    foto VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- TABLA LIBROS (estructura principal)
CREATE TABLE libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    descripcion TEXT,
    portada VARCHAR(255) DEFAULT 'default-book.jpg',
    calificacion DECIMAL(3,1) DEFAULT 0.0,
    destacado TINYINT(1) DEFAULT 0,
    fecha_publicacion DATE,
    stock INT DEFAULT 0,
    isbn VARCHAR(20) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    usuario_id INT,
    FULLTEXT idx_busqueda (titulo, autor, descripcion),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
    FOREIGN KEY (autor) REFERENCES autores(nombre) ON UPDATE CASCADE,
    FOREIGN KEY (categoria) REFERENCES categorias(nombre) ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Añadir restricciones CHECK después de crear la tabla (evitando problemas con funciones)
ALTER TABLE libros
ADD CONSTRAINT chk_precio_positivo CHECK (precio >= 0),
ADD CONSTRAINT chk_calificacion_valida CHECK (calificacion BETWEEN 0 AND 5),
ADD CONSTRAINT chk_stock_positivo CHECK (stock >= 0),
ADD CONSTRAINT chk_isbn_longitud CHECK (LENGTH(isbn) BETWEEN 10 AND 20),
ADD CONSTRAINT chk_formato_portada CHECK (portada LIKE '%.jpg' OR portada LIKE '%.png' OR portada LIKE '%.webp');

-- TABLA EVENTOS
CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libro_id INT NOT NULL,
    titulo_evento VARCHAR(255) NOT NULL,
    fecha DATETIME NOT NULL,
    descripcion TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT,
    FOREIGN KEY (libro_id) REFERENCES libros(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Añadir restricción CHECK para eventos después de crear la tabla
ALTER TABLE eventos
ADD CONSTRAINT chk_fecha_evento_valida CHECK (fecha >= created_at);

-- TABLA PRÉSTAMOS
CREATE TABLE prestamos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libro_id INT NOT NULL,
    usuario_id INT NOT NULL,
    fecha_prestamo DATE NOT NULL DEFAULT (CURRENT_DATE),
    fecha_devolucion DATE NOT NULL,
    estado ENUM('activo', 'completado', 'atrasado') DEFAULT 'activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (libro_id) REFERENCES libros(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Añadir restricción CHECK para préstamos después de crear la tabla
ALTER TABLE prestamos
ADD CONSTRAINT chk_fechas_prestamo CHECK (fecha_devolucion > fecha_prestamo);

-- TABLA RESEÑAS
CREATE TABLE resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libro_id INT NOT NULL,
    usuario_id INT NOT NULL,
    calificacion TINYINT NOT NULL,
    comentario TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (libro_id) REFERENCES libros(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    UNIQUE KEY unq_libro_usuario (libro_id, usuario_id)
) ENGINE=InnoDB;

-- Añadir restricción CHECK para reseñas después de crear la tabla
ALTER TABLE resenas
ADD CONSTRAINT chk_calificacion_resena CHECK (calificacion BETWEEN 1 AND 5);

-- Crear triggers para validación de fechas
DELIMITER //
CREATE TRIGGER before_insert_libros
BEFORE INSERT ON libros
FOR EACH ROW
BEGIN
    IF NEW.fecha_publicacion > CURDATE() THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'La fecha de publicación no puede ser futura';
    END IF;
END//

CREATE TRIGGER before_update_libros
BEFORE UPDATE ON libros
FOR EACH ROW
BEGIN
    IF NEW.fecha_publicacion > CURDATE() THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'La fecha de publicación no puede ser futura';
    END IF;
END//

CREATE TRIGGER before_insert_eventos
BEFORE INSERT ON eventos
FOR EACH ROW
BEGIN
    IF NEW.fecha < NOW() THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'La fecha del evento no puede ser en el pasado';
    END IF;
END//

CREATE TRIGGER before_update_eventos
BEFORE UPDATE ON eventos
FOR EACH ROW
BEGIN
    IF NEW.fecha < NOW() THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'La fecha del evento no puede ser en el pasado';
    END IF;
END//
DELIMITER ;

-- Configurar permisos
CREATE USER IF NOT EXISTS 'readabook_user'@'localhost' IDENTIFIED BY 'password_seguro';
GRANT ALL PRIVILEGES ON readabook.* TO 'readabook_user'@'localhost';
FLUSH PRIVILEGES;

-- Insertar datos iniciales
INSERT INTO categorias (nombre, descripcion) VALUES
('Novela', 'Obras de ficción narrativa'),
('Ciencia Ficción', 'Libros de ciencia ficción y fantasía'),
('Biografía', 'Historias de vida de personas reales'),
('Terror', 'Libros de terror y suspenso'),
('Aventura', 'Historias de aventuras y acción');

INSERT INTO autores (nombre, biografia) VALUES
('Gabriel García Márquez', 'Escritor colombiano, premio Nobel de Literatura'),
('J.K. Rowling', 'Escritora británica, creadora de Harry Potter'),
('Stephen King', 'Escritor estadounidense de novelas de terror');

INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Admin', 'admin@readabook.com', '$2y$10$EjemploDeHashSeguro', 'admin'),
('Editor', 'editor@readabook.com', '$2y$10$EjemploDeHashSeguro', 'editor'),
('Usuario', 'usuario@readabook.com', '$2y$10$EjemploDeHashSeguro', 'usuario');