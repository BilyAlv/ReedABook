<?php
session_start();
// Conectar a la base de datos
$servername = "localhost";
$username = "root"; // Cambia según tu configuración
$password = ""; 
$dbname = "readabook"; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Configurar codificación UTF-8
$conn->set_charset("utf8");

// Función para limpiar entradas
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Variables para mensajes
$success_message = '';
$error_message = '';

// Configuración de paginación
$libros_por_pagina = 8;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $libros_por_pagina;

// Filtros de búsqueda
$busqueda = isset($_GET['busqueda']) ? clean_input($_GET['busqueda']) : '';
$genero = isset($_GET['genero']) ? clean_input($_GET['genero']) : '';
$orden = isset($_GET['orden']) ? clean_input($_GET['orden']) : 'titulo_asc';

// Procesamiento de operaciones CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Para simplificar, asumimos que el usuario está autenticado como admin
    $admin_autenticado = true;
    
    if ($admin_autenticado) {
        // CREAR un nuevo libro
        if (isset($_POST['action']) && $_POST['action'] === 'crear') {
            $titulo = clean_input($_POST['titulo']);
            $autor = clean_input($_POST['autor']);
            $genero = clean_input($_POST['genero']);
            $precio = (float)clean_input($_POST['precio']);
            $descripcion = clean_input($_POST['descripcion']);
            $calificacion = isset($_POST['calificacion']) ? (float)clean_input($_POST['calificacion']) : 0;
            $destacado = isset($_POST['destacado']) ? 1 : 0;
            
            // Procesar la portada del libro
            $portada = 'default-book.jpg'; // Imagen por defecto
            if (isset($_FILES['portada']) && $_FILES['portada']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['portada']['name'];
                $filetype = pathinfo($filename, PATHINFO_EXTENSION);
                
                if (in_array(strtolower($filetype), $allowed)) {
                    $new_filename = uniqid() . '.' . $filetype;
                    $upload_dir = 'images/portadas/';
                    
                    // Crear directorio si no existe
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    if (move_uploaded_file($_FILES['portada']['tmp_name'], $upload_dir . $new_filename)) {
                        $portada = $new_filename;
                    } else {
                        $error_message = "Error al subir la imagen.";
                    }
                } else {
                    $error_message = "Formato de imagen no permitido. Use JPG, JPEG, PNG o GIF.";
                }
            }
            
            // Insertar en la base de datos
            if (empty($error_message)) {
                $sql = "INSERT INTO libros (titulo, autor, categoria, precio, descripcion, portada, calificacion, destacado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssdssdi", $titulo, $autor, $genero, $precio, $descripcion, $portada, $calificacion, $destacado);
                
                if ($stmt->execute()) {
                    $success_message = "Libro creado con éxito.";
                } else {
                    $error_message = "Error al crear el libro: " . $stmt->error;
                }
                $stmt->close();
            }
        }
        
        // ACTUALIZAR un libro existente
        elseif (isset($_POST['action']) && $_POST['action'] === 'actualizar') {
            $id = (int)$_POST['id'];
            $titulo = clean_input($_POST['titulo']);
            $autor = clean_input($_POST['autor']);
            $genero = clean_input($_POST['genero']);
            $precio = (float)clean_input($_POST['precio']);
            $descripcion = clean_input($_POST['descripcion']);
            $calificacion = isset($_POST['calificacion']) ? (float)clean_input($_POST['calificacion']) : 0;
            $destacado = isset($_POST['destacado']) ? 1 : 0;
            
            // Preparar la consulta SQL base
            $sql = "UPDATE libros SET titulo = ?, autor = ?, categoria = ?, precio = ?, 
                descripcion = ?, calificacion = ?, destacado = ?";
            $params = [$titulo, $autor, $genero, $precio, $descripcion, $calificacion, $destacado];
            $types = "sssdsdi";
            
            // Procesar la portada si se subió una nueva
            if (isset($_FILES['portada']) && $_FILES['portada']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                $filename = $_FILES['portada']['name'];
                $filetype = pathinfo($filename, PATHINFO_EXTENSION);
                
                if (in_array(strtolower($filetype), $allowed)) {
                    $new_filename = uniqid() . '.' . $filetype;
                    $upload_dir = 'images/portadas/';
                    
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    if (move_uploaded_file($_FILES['portada']['tmp_name'], $upload_dir . $new_filename)) {
                        // Agregar portada a la consulta
                        $sql .= ", portada = ?";
                        $params[] = $new_filename;
                        $types .= "s";
                        
                        // Obtener y eliminar la portada anterior
                        $query = "SELECT portada FROM libros WHERE id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($row = $result->fetch_assoc()) {
                            $old_portada = $row['portada'];
                            if ($old_portada != 'default-book.jpg' && file_exists($upload_dir . $old_portada)) {
                                unlink($upload_dir . $old_portada);
                            }
                        }
                        $stmt->close();
                    } else {
                        $error_message = "Error al subir la imagen.";
                    }
                } else {
                    $error_message = "Formato de imagen no permitido. Use JPG, JPEG, PNG o GIF.";
                }
            }
            
            // Completar y ejecutar la consulta
            if (empty($error_message)) {
                $sql .= " WHERE id = ?";
                $params[] = $id;
                $types .= "i";
                
                $stmt = $conn->prepare($sql);
                $stmt->bind_param($types, ...$params);
                
                if ($stmt->execute()) {
                    $success_message = "Libro actualizado con éxito.";
                } else {
                    $error_message = "Error al actualizar el libro: " . $stmt->error;
                }
                $stmt->close();
            }
        }
        
        // ELIMINAR un libro
        elseif (isset($_POST['action']) && $_POST['action'] === 'eliminar') {
            $id = (int)$_POST['id'];
            
            // Obtener información del libro antes de eliminar
            $query = "SELECT portada FROM libros WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                $portada = $row['portada'];
                
                // Eliminar el libro de la base de datos
                $delete_sql = "DELETE FROM libros WHERE id = ?";
                $delete_stmt = $conn->prepare($delete_sql);
                $delete_stmt->bind_param("i", $id);
                
                if ($delete_stmt->execute()) {
                    // Eliminar la imagen si no es la predeterminada
                    if ($portada != 'default-book.jpg') {
                        $file_path = 'images/portadas/' . $portada;
                        if (file_exists($file_path)) {
                            unlink($file_path);
                        }
                    }
                    $success_message = "Libro eliminado con éxito.";
                } else {
                    $error_message = "Error al eliminar el libro: " . $delete_stmt->error;
                }
                $delete_stmt->close();
            } else {
                $error_message = "Libro no encontrado.";
            }
            $stmt->close();
        }
    } else {
        $error_message = "No tienes permisos para realizar esta acción.";
    }
}

// Construir la consulta SQL para listar libros con filtros
$where_clauses = [];
$params = [];
$types = "";

if (!empty($busqueda)) {
    $where_clauses[] = "(titulo LIKE ? OR autor LIKE ? OR descripcion LIKE ?)";
    $search_term = "%$busqueda%";
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
    $types .= "sss";
}

if (!empty($genero)) {
    $where_clauses[] = "categoria = ?";
    $params[] = $genero;
    $types .= "s";
}

$where_sql = empty($where_clauses) ? "" : "WHERE " . implode(" AND ", $where_clauses);

// Ordenación
$order_by = "ORDER BY ";
switch ($orden) {
    case 'titulo_desc':
        $order_by .= "titulo DESC";
        break;
    case 'precio_asc':
        $order_by .= "precio ASC";
        break;
    case 'precio_desc':
        $order_by .= "precio DESC";
        break;
    case 'calificacion_desc':
        $order_by .= "calificacion DESC";
        break;
    default:
        $order_by .= "titulo ASC";
}

// Consulta para contar el total de libros (para paginación)
$count_sql = "SELECT COUNT(*) as total FROM libros $where_sql";
$count_stmt = $conn->prepare($count_sql);
if (!empty($params)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_libros = $count_result->fetch_assoc()['total'];
$total_paginas = ceil($total_libros / $libros_por_pagina);
$count_stmt->close();

// Consulta para obtener los libros con paginación
$sql = "SELECT * FROM libros $where_sql $order_by LIMIT ? OFFSET ?";
$params[] = $libros_por_pagina;
$params[] = $offset;
$types .= "ii";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Obtener lista de géneros para filtros
$genres_sql = "SELECT DISTINCT categoria FROM libros ORDER BY categoria";
$genres_result = $conn->query($genres_sql);

// Función auxiliar para marcar la página activa en el menú
function isActive($currentPage, $pageName) {
    return basename($_SERVER['PHP_SELF']) === $pageName ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadABook - Catálogo de Libros</title>
    <link rel="stylesheet" href="../css/catalogo.css">

    
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <h1>ReadABook</h1>
                <p>Tu librería digital favorita</p>
            </div>
            <nav>
                <ul>
                    <li><a href="#" class="active">Catálogo</a></li>
                    <li><a href="#">Préstamos</a></li>
                    <li><a href="#">Novedades</a></li>
                    <li><a href="#">Club de Lectura</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <!-- Hero Section -->
        <section id="hero">
            <h1>Catálogo de Libros</h1>
            <p>Gestiona la colección de libros de tu librería digital</p>
        </section>
        
        <!-- Mensajes de éxito o error -->
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <!-- Panel de administración -->
        <section class="admin-controls">
            <h2>Gestionar Catálogo</h2>
            <button id="btnNuevoLibro" class="btn btn-success">Nuevo Libro</button>
        </section>
        
        <!-- Filtros de búsqueda -->
        <section class="filters">
            <h3>Filtros</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" id="filtroForm">
                <div class="form-row">
                    <div class="form-group">
                        <label for="busqueda">Buscar:</label>
                        <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Título, autor o descripción" value="<?php echo $busqueda; ?>">
                    </div>
                    <div class="form-group">
                        <label for="genero">Género:</label>
                        <select class="form-control" id="genero" name="genero">
                            <option value="">Todos los géneros</option>
                            <?php while ($genre = $genres_result->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($genre['categoria']); ?>" <?php echo ($genre['categoria'] === $genero) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($genre['categoria']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="orden">Ordenar por:</label>
                        <select class="form-control" id="orden" name="orden">
                            <option value="titulo_asc" <?php echo ($orden === 'titulo_asc') ? 'selected' : ''; ?>>Título (A-Z)</option>
                            <option value="titulo_desc" <?php echo ($orden === 'titulo_desc') ? 'selected' : ''; ?>>Título (Z-A)</option>
                            <option value="precio_asc" <?php echo ($orden === 'precio_asc') ? 'selected' : ''; ?>>Precio (menor a mayor)</option>
                            <option value="precio_desc" <?php echo ($orden === 'precio_desc') ? 'selected' : ''; ?>>Precio (mayor a menor)</option>
                            <option value="calificacion_desc" <?php echo ($orden === 'calificacion_desc') ? 'selected' : ''; ?>>Mejor calificados</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Aplicar filtros</button>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-secondary">Limpiar filtros</a>
            </form>
        </section>

        <!-- Grid de Libros -->
<section class="books-grid">
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Comprobar si la portada existe, si no usar una imagen por defecto
            $cover_image = !empty($row['portada']) ? $row['portada'] : 'images/default-cover.jpg';
            
            echo '<div class="book-card">';
            echo '<img src="' . $cover_image . '" alt="' . htmlspecialchars($row['titulo']) . '">';
            echo '<h3>' . htmlspecialchars($row['titulo']) . '</h3>';
            echo '<p>Autor: ' . htmlspecialchars($row['autor']) . '</p>';
            // Puedes añadir más campos aquí según tu base de datos
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron libros.</p>';
    }
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Comprobar si la portada existe, si no usar una imagen predeterminada
                    $portada_path = 'images/portadas/' . $row['portada'];
                    $portada_url = file_exists($portada_path) ? $portada_path : 'images/portadas/default-book.jpg';
                    
                    // Formatear el precio
                    $precio_formateado = number_format($row['precio'], 2, ',', '.');
                    
                    // Generar estrellas para la calificación
                    $calificacion = $row['calificacion'];
                    $estrellas = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $calificacion) {
                            $estrellas .= '★';
                        } else if ($i - 0.5 <= $calificacion) {
                            $estrellas .= '★';
                        } else {
                            $estrellas .= '☆';
                        }
                    }
                    ?>
                    <div class="book-card">
                        <div class="book-cover">
                            <img src="<?php echo $portada_url; ?>" alt="<?php echo htmlspecialchars($row['titulo']); ?>">
                            <div class="book-badges">
                                <?php if ($row['destacado'] == 1): ?>
                                    <span class="badge badge-new">Destacado</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="book-info">
                            <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                            <p class="author">Por <?php echo htmlspecialchars($row['autor']); ?></p>
                            <div class="book-rating">
                                <span class="stars"><?php echo $estrellas; ?></span>
                                <span class="reviews">(<?php echo $calificacion; ?>/5)</span>
                            </div>
                            <span class="genre"><?php echo htmlspecialchars($row['categoria']); ?></span>
                            <p class="price"><?php echo $precio_formateado; ?> €</p>
                            <div class="actions">
                                <button class="btn btn-primary btn-ver" data-id="<?php echo $row['id']; ?>" data-titulo="<?php echo htmlspecialchars($row['titulo']); ?>" data-descripcion="<?php echo htmlspecialchars($row['descripcion']); ?>">Ver detalles</button>
                            </div>
                            <div class="book-controls">
                                <button class="btn btn-warning btn-editar" 
                                    data-id="<?php echo $row['id']; ?>"
                                    data-titulo="<?php echo htmlspecialchars($row['titulo']); ?>"
                                    data-autor="<?php echo htmlspecialchars($row['autor']); ?>"
                                    data-genero="<?php echo htmlspecialchars($row['categoria']); ?>"
                                    data-precio="<?php echo $row['precio']; ?>"
                                    data-descripcion="<?php echo htmlspecialchars($row['descripcion']); ?>"
                                    data-calificacion="<?php echo $row['calificacion']; ?>"
                                    data-destacado="<?php echo $row['destacado']; ?>"
                                    data-portada="<?php echo htmlspecialchars($row['portada']); ?>">
                                    Editar
                                </button>
                                <button class="btn btn-danger btn-eliminar" data-id="<?php echo $row['id']; ?>" data-titulo="<?php echo htmlspecialchars($row['titulo']); ?>">Eliminar</button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="alert alert-info">No se encontraron libros con los criterios seleccionados.</div>';
            }
            ?>
        </section>
        
        <!-- Paginación -->
        <?php if ($total_paginas > 1): ?>
            <div class="pagination">
                <?php
                // Construir los parámetros de URL para mantener los filtros
                $params = [];
                if (!empty($busqueda)) $params[] = "busqueda=" . urlencode($busqueda);
                if (!empty($genero)) $params[] = "genero=" . urlencode($genero);
                if (!empty($orden)) $params[] = "orden=" . urlencode($orden);
                $query_string = empty($params) ? "" : "&" . implode("&", $params);
                
                // Botón "Anterior"
                if ($pagina_actual > 1): ?>
                    <a href="?pagina=<?php echo ($pagina_actual - 1) . $query_string; ?>" class="pagination-btn">Anterior</a>
                <?php endif; ?>
                
                <?php
                // Mostrar números de página
                $start_page = max(1, $pagina_actual - 2);
                $end_page = min($total_paginas, $pagina_actual + 2);
                
                if ($start_page > 1): ?>
                    <a href="?pagina=1<?php echo $query_string; ?>" class="pagination-btn">1</a>
                    <?php if ($start_page > 2): ?>
                        <span class="pagination-dots">...</span>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <?php if ($i == $pagina_actual): ?>
                        <span class="pagination-btn pagination-active"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="?pagina=<?php echo $i . $query_string; ?>" class="pagination-btn"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if ($end_page < $total_paginas): ?>
                    <?php if ($end_page < $total_paginas - 1): ?>
                        <span class="pagination-dots">...</span>
                    <?php endif; ?>
                    <a href="?pagina=<?php echo $total_paginas . $query_string; ?>" class="pagination-btn"><?php echo $total_paginas; ?></a>
                <?php endif; ?>
                
                <!-- Botón "Siguiente" -->
                <?php if ($pagina_actual < $total_paginas): ?>
                    <a href="?pagina=<?php echo ($pagina_actual + 1) . $query_string; ?>" class="pagination-btn">Siguiente</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Modal para Crear/Editar Libro -->
    <div id="libroModal" class="modal-backdrop hidden">
        <div class="modal">
            <div class="modal-header">
                <h3 id="modalTitle">Nuevo Libro</h3>
                <button type="button" class="modal-close" id="btnCerrarModal">&times;</button>
            </div>
            <form id="libroForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" id="libroAction" value="crear">
                <input type="hidden" name="id" id="libroId">
                
                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                
                <div class="form-group">
                    <label for="autor">Autor:</label>
                    <input type="text" class="form-control" id="autor" name="autor" required>
                </div>
                
                <div class="form-group">
                    <label for="generoModal">Género:</label>
                    <select class="form-control" id="generoModal" name="genero" required>
                        <option value="">Seleccione un género</option>
                        <?php
                        // Reiniciar el puntero de resultado de géneros
                        $genres_result->data_seek(0);
                        while ($genre = $genres_result->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($genre['categoria']); ?>">
                                <?php echo htmlspecialchars($genre['categoria']); ?>
                            </option>
                        <?php endwhile; ?>
                        <option value="otro">Otro (nuevo género)</option>
                    </select>
                </div>
                
                <div id="otroGeneroGroup" class="form-group hidden">
                    <label for="otroGenero">Especificar género:</label>
                    <input type="text" class="form-control" id="otroGenero">
                </div>
                
                <div class="form-group">
                    <label for="precio">Precio (€):</label>
                    <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="portada">Portada:</label>
                    <input type="file" class="form-control" id="portada" name="portada" accept="image/*">
                    <div id="portadaPreview" class="hidden">
                        <p>Portada actual: <span id="portadaActual"></span></p>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="calificacion">Calificación:</label>
                    <input type="number" class="form-control" id="calificacion" name="calificacion" step="0.1" min="0" max="5" value="0">
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="destacado" name="destacado"> Marcar como destacado
                    </label>
                </div>
                
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-secondary" id="btnCancelar">Cancelar</button>
            </form>
        </div>
    </div>
    
    <!-- Modal para confirmar eliminación -->
    <div id="eliminarModal" class="modal-backdrop hidden">
        <div class="modal">
            <div class="modal-header">
                <h3>Confirmar eliminación</h3>
                <button type="button" class="modal-close" id="btnCerrarEliminarModal">&times;</button>
            </div>
            <form id="eliminarForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="hidden" name="action" value="eliminar">
                <input type="hidden" name="id" id="eliminarId">
                
                <p style="padding: 20px;">¿Está seguro de que desea eliminar el libro "<span id="eliminarTitulo"></span>"?</p>
                
                <div style="padding: 0 20px 20px;">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" id="btnCancelarEliminar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal para ver detalles del libro -->
    <div id="detalleModal" class="modal-backdrop hidden">
        <div class="modal">
            <div class="modal-header">
                <h3 id="detalleTitulo"></h3>
                <button type="button" class="modal-close" id="btnCerrarDetalleModal">&times;</button>
            </div>
            <div style="padding: 20px;">
                <p id="detalleDescripcion" style="margin-bottom: 20px;"></p>
                <button class="btn btn-secondary" id="btnCerrarDetalle">Cerrar</button>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer>
        <div class="container footer-container">
            <div class="footer-section">
                <h3>ReadABook</h3>
                <p>Tu librería digital favorita con una amplia selección de libros para todos los gustos.</p>
            </div>
            <div class="footer-section">
                <h3>Enlaces</h3>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Catálogo</a></li>
                    <li><a href="#">Préstamos</a></li>
                    <li><a href="#">Club de Lectura</a></li>
                    <li><a href="#">Sobre Nosotros</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contacto</h3>
                <ul>
                    <li>Email: info@readabook.com</li>
                    <li>Teléfono: +34 123 456 789</li>
                    <li>Dirección: Calle Librería 123, Madrid</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom container">
            <p>&copy; <?php echo date('Y'); ?> ReadABook. Todos los derechos reservados.</p>
        </div>
    </footer>
    
    <script>
        // Funcionalidad para los modales
        document.addEventListener('DOMContentLoaded', function() {
            // Modal de nuevo libro
            const btnNuevoLibro = document.getElementById('btnNuevoLibro');
            const libroModal = document.getElementById('libroModal');
            const btnCerrarModal = document.getElementById('btnCerrarModal');
            const btnCancelar = document.getElementById('btnCancelar');
            const libroForm = document.getElementById('libroForm');
            const libroAction = document.getElementById('libroAction');
            const libroId = document.getElementById('libroId');
            const modalTitle = document.getElementById('modalTitle');
            
            // Modal de eliminar
            const eliminarModal = document.getElementById('eliminarModal');
            const btnCerrarEliminarModal = document.getElementById('btnCerrarEliminarModal');
            const btnCancelarEliminar = document.getElementById('btnCancelarEliminar');
            const eliminarForm = document.getElementById('eliminarForm');
            const eliminarId = document.getElementById('eliminarId');
            const eliminarTitulo = document.getElementById('eliminarTitulo');
            
            // Modal de detalles
            const detalleModal = document.getElementById('detalleModal');
            const btnCerrarDetalleModal = document.getElementById('btnCerrarDetalleModal');
            const btnCerrarDetalle = document.getElementById('btnCerrarDetalle');
            const detalleTitulo = document.getElementById('detalleTitulo');
            const detalleDescripcion = document.getElementById('detalleDescripcion');
            
            // Gestión de género personalizado
            const generoModal = document.getElementById('generoModal');
            const otroGeneroGroup = document.getElementById('otroGeneroGroup');
            const otroGenero = document.getElementById('otroGenero');
            
            // Abrir modal para nuevo libro
            btnNuevoLibro.addEventListener('click', function() {
                modalTitle.textContent = 'Nuevo Libro';
                libroAction.value = 'crear';
                libroForm.reset();
                document.getElementById('portadaPreview').classList.add('hidden');
                libroModal.classList.remove('hidden');
            });
            
            // Cerrar modales
            btnCerrarModal.addEventListener('click', () => libroModal.classList.add('hidden'));
            btnCancelar.addEventListener('click', () => libroModal.classList.add('hidden'));
            btnCerrarEliminarModal.addEventListener('click', () => eliminarModal.classList.add('hidden'));
            btnCancelarEliminar.addEventListener('click', () => eliminarModal.classList.add('hidden'));
            btnCerrarDetalleModal.addEventListener('click', () => detalleModal.classList.add('hidden'));
            btnCerrarDetalle.addEventListener('click', () => detalleModal.classList.add('hidden'));
            
            // Gestionar eventos de editar libro
            const btnsEditar = document.querySelectorAll('.btn-editar');
            btnsEditar.forEach(btn => {
                btn.addEventListener('click', function() {
                    modalTitle.textContent = 'Editar Libro';
                    libroAction.value = 'actualizar';
                    libroId.value = this.dataset.id;
                    document.getElementById('titulo').value = this.dataset.titulo;
                    document.getElementById('autor').value = this.dataset.autor;
                    document.getElementById('generoModal').value = this.dataset.genero;
                    document.getElementById('precio').value = this.dataset.precio;
                    document.getElementById('descripcion').value = this.dataset.descripcion;
                    document.getElementById('calificacion').value = this.dataset.calificacion;
                    document.getElementById('destacado').checked = this.dataset.destacado === '1';
                    
                    // Mostrar info de portada actual
                    const portadaPreview = document.getElementById('portadaPreview');
                    const portadaActual = document.getElementById('portadaActual');
                    if (this.dataset.portada) {
                        portadaPreview.classList.remove('hidden');
                        portadaActual.textContent = this.dataset.portada;
                    } else {
                        portadaPreview.classList.add('hidden');
                    }
                    
                    libroModal.classList.remove('hidden');
                });
            });
            
            // Gestionar eventos de eliminar libro
            const btnsEliminar = document.querySelectorAll('.btn-eliminar');
            btnsEliminar.forEach(btn => {
                btn.addEventListener('click', function() {
                    eliminarId.value = this.dataset.id;
                    eliminarTitulo.textContent = this.dataset.titulo;
                    eliminarModal.classList.remove('hidden');
                });
            });
            
            // Gestionar eventos de ver detalles
            const btnsVer = document.querySelectorAll('.btn-ver');
            btnsVer.forEach(btn => {
                btn.addEventListener('click', function() {
                    detalleTitulo.textContent = this.dataset.titulo;
                    detalleDescripcion.textContent = this.dataset.descripcion;
                    detalleModal.classList.remove('hidden');
                });
            });
            
            // Gestionar opción "Otro género"
            generoModal.addEventListener('change', function() {
                if (this.value === 'otro') {
                    otroGeneroGroup.classList.remove('hidden');
                    otroGenero.setAttribute('required', 'required');
                } else {
                    otroGeneroGroup.classList.add('hidden');
                    otroGenero.removeAttribute('required');
                }
            });
            
            // Procesar elección de "Otro género" antes de enviar el formulario
            libroForm.addEventListener('submit', function(e) {
                if (generoModal.value === 'otro' && otroGenero.value.trim() !== '') {
                    e.preventDefault();
                    const option = document.createElement('option');
                    option.value = otroGenero.value.trim();
                    option.textContent = otroGenero.value.trim();
                    option.selected = true;
                    generoModal.insertBefore(option, generoModal.querySelector('option[value="otro"]'));
                    generoModal.value = otroGenero.value.trim();
                    otroGeneroGroup.classList.add('hidden');
                    this.submit();
                }
            });
            
            // Cerrar los modales al hacer clic fuera
            window.addEventListener('click', function(e) {
                if (e.target === libroModal) {
                    libroModal.classList.add('hidden');
                }
                if (e.target === eliminarModal) {
                    eliminarModal.classList.add('hidden');
                }
                if (e.target === detalleModal) {
                    detalleModal.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
<?php
// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
?>