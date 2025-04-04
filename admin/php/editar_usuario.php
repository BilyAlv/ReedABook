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

$user_id = $_GET['id'] ?? null;
if ($user_id === null) {
    header("Location: gestionar_usuarios.php");
    exit();
}

// Obtener datos del usuario
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    // Editar usuario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = strtolower($_POST['rol']);  // Convertir el rol a minúsculas

    // Validación simple del rol (ajustar si tienes más roles)
    if (!in_array($rol, ['admin', 'usuario', 'editor'])) {
        $error = "Rol inválido.";
    } else {
        // Preparar y ejecutar la consulta de actualización
        $sql = "UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $email, $rol, $user_id);

        if ($stmt->execute()) {
            header("Location: ../pages/gestionar_usuarios.php"); // Redirigir después de la actualización
            exit();
        } else {
            $error = "Error al actualizar usuario: " . $conn->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Read a Book</title>
    <link rel="stylesheet" href="../css/editar_usuario.css">
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
                <li class="active">
                    <a href="../pages/gestionar_usuarios.php">
                        <i class="fa-solid fa-users"></i>
                        <span>Gestionar Usuarios</span>
                    </a>
                </li>
                <li>
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

        <!-- Formulario para editar el usuario -->
        <div class="form-container">
            <h2>Editar Usuario</h2>
            <form method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
                <br><br>
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                <br><br>
                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <option value="admin" <?php if ($user['rol'] == 'admin') echo 'selected'; ?>>admin</option>
                    <option value="usuario" <?php if ($user['rol'] == 'usuario') echo 'selected'; ?>>usuario</option>
                    <option value="editor" <?php if ($user['rol'] == 'editor') echo 'selected'; ?>>editor</option>
                </select>
                <br><br>
                <button type="submit" name="edit_user" class="button">Actualizar Usuario</button>
            </form>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
