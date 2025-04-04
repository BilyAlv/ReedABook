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

// Consultas para obtener los reportes
// 1. Número total de libros
$total_books_query = "SELECT COUNT(*) AS total_books FROM libros";
$total_books_result = $conn->query($total_books_query);
$total_books = $total_books_result->fetch_assoc()['total_books'];

// 2. Número de libros por autor
$books_by_author_query = "SELECT autor, COUNT(*) AS total_books FROM libros GROUP BY autor";
$books_by_author_result = $conn->query($books_by_author_query);

// 3. Número de libros por categoría
$books_by_category_query = "SELECT categoria, COUNT(*) AS total_books FROM libros GROUP BY categoria";
$books_by_category_result = $conn->query($books_by_category_query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Reportes - Read a Book</title>
    <link rel="stylesheet" href="../css/reportes.css">
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
                <li>
                    <a href="gestionar_libros.php">
                        <i class="fa-solid fa-book"></i>
                        <span>Gestionar Libros</span>
                    </a>
                </li>
                <li class="active">
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
        <!-- Reporte de total de libros -->
        <div class="report-section">
            <h2>Total de Libros</h2>
            <p>Total de libros en la base de datos: <?php echo $total_books; ?></p>
        </div>

        <!-- Reporte de libros por autor -->
        <div class="report-section">
            <h2>Libros por Autor</h2>
            <table>
                <tr>
                    <th>Autor</th>
                    <th>Total de Libros</th>
                </tr>
                <?php
                if ($books_by_author_result && $books_by_author_result->num_rows > 0) {
                    while ($row = $books_by_author_result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['autor']}</td>
                                <td>{$row['total_books']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No hay datos disponibles</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Reporte de libros por categoría -->
        <div class="report-section">
            <h2>Libros por Categoría</h2>
            <table>
                <tr>
                    <th>Categoría</th>
                    <th>Total de Libros</th>
                </tr>
                <?php
                if ($books_by_category_result && $books_by_category_result->num_rows > 0) {
                    while ($row = $books_by_category_result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['categoria']}</td>
                                <td>{$row['total_books']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No hay datos disponibles</td></tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
