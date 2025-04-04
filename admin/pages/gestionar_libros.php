<?php
session_start();

// Verifica si el usuario está autenticado y si es un admin
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php"); // Redirige al login si no es admin
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "readabook";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Manejo de las acciones de agregar, editar y eliminar libros
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_book'])) {
        // Agregar nuevo libro
        $titulo = $conn->real_escape_string($_POST['titulo']);
        $autor = $conn->real_escape_string($_POST['autor']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $categoria = $conn->real_escape_string($_POST['categoria']);
        $precio = $_POST['precio'];

        // Verificar si el autor existe, si no, agregarlo
        $autor_query = "SELECT nombre FROM autores WHERE nombre = '$autor'";
        $autor_result = $conn->query($autor_query);

        if ($autor_result->num_rows === 0) {
            // Insertar nuevo autor
            $insert_autor = "INSERT INTO autores (nombre) VALUES ('$autor')";
            if (!$conn->query($insert_autor)) {
                $error = "Error al agregar autor: " . $conn->error;
            }
        }

        // Verificar si la categoría existe, si no, agregarla
        $categoria_query = "SELECT nombre FROM categorias WHERE nombre = '$categoria'";
        $categoria_result = $conn->query($categoria_query);

        if ($categoria_result->num_rows === 0) {
            // Insertar nueva categoría
            $insert_categoria = "INSERT INTO categorias (nombre) VALUES ('$categoria')";
            if (!$conn->query($insert_categoria)) {
                $error = "Error al agregar categoría: " . $conn->error;
            }
        }

        // Si no hay errores, insertar el libro
        if (!isset($error)) {
            $sql = "INSERT INTO libros (titulo, autor, categoria, precio, descripcion) 
                    VALUES ('$titulo', '$autor', '$categoria', '$precio', '$descripcion')";
            if ($conn->query($sql) === TRUE) {
                $message = "Libro agregado correctamente. Se han agregado autor y/o categoría nuevos si no existían previamente.";
            } else {
                $error = "Error al agregar libro: " . $conn->error;
            }
        }
    }

    if (isset($_POST['delete_book'])) {
        // Eliminar libro
        $book_id = $_POST['book_id'];
        $sql = "DELETE FROM libros WHERE id = '$book_id'";
        if ($conn->query($sql) === TRUE) {
            $message = "Libro eliminado correctamente.";
        } else {
            $error = "Error al eliminar libro: " . $conn->error;
        }
    }

    if (isset($_POST['edit_book'])) {
        // Editar libro
        $book_id = $_POST['book_id'];
        $titulo = $conn->real_escape_string($_POST['titulo']);
        $autor = $conn->real_escape_string($_POST['autor']);
        $descripcion = $conn->real_escape_string($_POST['descripcion']);
        $categoria = $conn->real_escape_string($_POST['categoria']);
        $precio = $_POST['precio'];

        // Verificar si el autor existe, si no, agregarlo
        $autor_query = "SELECT nombre FROM autores WHERE nombre = '$autor'";
        $autor_result = $conn->query($autor_query);

        if ($autor_result->num_rows === 0) {
            // Insertar nuevo autor
            $insert_autor = "INSERT INTO autores (nombre) VALUES ('$autor')";
            if (!$conn->query($insert_autor)) {
                $error = "Error al agregar autor: " . $conn->error;
            }
        }

        // Verificar si la categoría existe, si no, agregarla
        $categoria_query = "SELECT nombre FROM categorias WHERE nombre = '$categoria'";
        $categoria_result = $conn->query($categoria_query);

        if ($categoria_result->num_rows === 0) {
            // Insertar nueva categoría
            $insert_categoria = "INSERT INTO categorias (nombre) VALUES ('$categoria')";
            if (!$conn->query($insert_categoria)) {
                $error = "Error al agregar categoría: " . $conn->error;
            }
        }

        // Actualizar libro
        if (!isset($error)) {
            $sql = "UPDATE libros SET titulo = '$titulo', autor = '$autor', descripcion = '$descripcion', 
                   categoria = '$categoria', precio = '$precio' WHERE id = '$book_id'";
            if ($conn->query($sql) === TRUE) {
                $message = "Libro actualizado correctamente. Se han agregado autor y/o categoría nuevos si no existían previamente.";
            } else {
                $error = "Error al actualizar libro: " . $conn->error;
            }
        }
    }
}

// Consulta para obtener todos los libros
$sql = "SELECT * FROM libros";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Libros - Read a Book</title>
    <link rel="stylesheet" href="../css/gestion-libros.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar Navigation -->
        <nav id="admin_sidebar">
            <div class="admin-logo">
                <h1>Read a Book</h1>
                <p>Panel de Administración</p>
            </div>
            
            <div class="admin-profile">
                <div class="profile-image">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div class="profile-info">
                    <h3><?php echo $_SESSION['nombre']; ?></h3>
                    <span>Administrador</span>
                </div>
            </div>
            
            <ul class="admin-menu">
                <li>
                    <a href="../index.php">
                        <i class="fa-solid fa-gauge-high"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="gestionar_usuarios.php">
                        <i class="fa-solid fa-users"></i>
                        <span>Gestionar Usuarios</span>
                    </a>
                </li>
                <li class="active">
                    <a href="gestionar_libros.php">
                        <i class="fa-solid fa-book"></i>
                        <span>Gestionar Libros</span>
                    </a>
                </li>
                <li>
                    <a href="reportes.php">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Ver Reportes</span>
                    </a>
                </li>
                <li class="logout-link">
                    <a href="../logout.php">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Cerrar sesión</span>
                    </a>
                </li>
            </ul>
        </nav>

    <div class="container">
        <!-- Mensajes de éxito o error -->
        <?php
        if (isset($message)) {
            echo "<p class='message'>$message</p>";
        }
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <!-- Formulario para agregar un nuevo libro -->
        <div class="form-container">
            <h2>Agregar Nuevo Libro</h2>
            <form method="POST">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
                <br><br>
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" required>
                <small>Si el autor no existe, se agregará automáticamente</small>
                <br><br>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
                <br><br>
                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria" required>
                <small>Si la categoría no existe, se agregará automáticamente</small>
                <br><br>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>
                <br><br>
                <button type="submit" name="add_book" class="button">Agregar Libro</button>
            </form>
        </div>

        <!-- Tabla de libros -->
        <h2>Lista de Libros</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['titulo']}</td>
                            <td>{$row['autor']}</td>
                            <td>{$row['categoria']}</td>
                            <td>{$row['precio']}</td>
                            <td>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='book_id' value='{$row['id']}'>
                                    <button type='submit' name='delete_book' class='button'>Eliminar</button>
                                </form>
                                <a href='../php/editar_libro.php?id={$row['id']}' class='button'>Editar</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay libros disponibles</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>