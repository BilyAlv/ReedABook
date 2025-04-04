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

$book_id = $_GET['id'] ?? null;
if ($book_id === null) {
    header("Location: gestionar_libros.php");
    exit();
}

// Obtener datos del libro
$sql = "SELECT * FROM libros WHERE id = '$book_id'";
$result = $conn->query($sql);
$book = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_book'])) {
    // Editar libro
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];

    // Actualizar en la base de datos
    $sql = "UPDATE libros SET titulo = '$titulo', autor = '$autor', descripcion = '$descripcion', categoria = '$categoria', precio = '$precio' WHERE id = '$book_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: ../pages/gestionar_libros.php"); // Redirigir después de la actualización
        exit();
    } else {
        $error = "Error al actualizar libro: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro - Read a Book</title>
    <link rel="stylesheet" href="../css/editar-libros.css">
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
                    <a href="../pages/gestionar_usuarios.php">
                        <i class="fa-solid fa-users"></i>
                        <span>Gestionar Usuarios</span>
                    </a>
                </li>
                <li class="active">
                    <a href="../pages/gestionar_libros.php">
                        <i class="fa-solid fa-book"></i>
                        <span>Gestionar Libros</span>
                    </a>
                </li>
                <li>
                    <a href="../pages/reportes.php">
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
        <!-- Mensajes de error -->
        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <!-- Formulario para editar el libro -->
        <div class="form-container">
            <h2>Editar Libro</h2>
            <form method="POST">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $book['titulo']; ?>" required>
                <br><br>
                <label for="autor">Autor:</label>
                <input type="text" id="autor" name="autor" value="<?php echo $book['autor']; ?>" required>
                <br><br>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required><?php echo $book['descripcion']; ?></textarea>
                <br><br>
                <label for="categoria">Categoría:</label>
                <input type="text" id="categoria" name="categoria" value="<?php echo $book['categoria']; ?>" required>
                <br><br>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" value="<?php echo $book['precio']; ?>" required>
                <br><br>
                <button type="submit" name="edit_book" class="button">Actualizar Libro</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
