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

// Manejo de las acciones de agregar, editar y eliminar usuarios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_user'])) {
        // Agregar nuevo usuario
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Asegúrate de cifrar la contraseña con password_hash() si es necesario
        $rol = $_POST['rol'];

        $sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('$nombre', '$email', '$password', '$rol')";
        if ($conn->query($sql) === TRUE) {
            $message = "Usuario agregado correctamente.";
        } else {
            $error = "Error al agregar usuario: " . $conn->error;
        }
    }

    if (isset($_POST['delete_user'])) {
        // Eliminar usuario
        $user_id = $_POST['user_id'];
        $sql = "DELETE FROM usuarios WHERE id = '$user_id'";
        if ($conn->query($sql) === TRUE) {
            $message = "Usuario eliminado correctamente.";
        } else {
            $error = "Error al eliminar usuario: " . $conn->error;
        }
    }

    if (isset($_POST['edit_user'])) {
        // Editar usuario
        $user_id = $_POST['user_id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Puedes actualizar la contraseña también si es necesario
        $rol = $_POST['rol'];

        $sql = "UPDATE usuarios SET nombre = '$nombre', email = '$email', password = '$password', rol = '$rol' WHERE id = '$user_id'";
        if ($conn->query($sql) === TRUE) {
            $message = "Usuario actualizado correctamente.";
        } else {
            $error = "Error al actualizar usuario: " . $conn->error;
        }
    }
}

// Consulta para obtener todos los usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios - Read a Book</title>
    <link rel="stylesheet" href="../css/gestion-de-usuarios.css">
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
        <!-- Mensajes de éxito o error -->
        <?php
        if (isset($message)) {
            echo "<p class='message'>$message</p>";
        }
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <!-- Formulario para agregar un nuevo usuario -->
        <div class="form-container">
            <h2>Agregar Nuevo Usuario</h2>
            <form method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
                <br><br>
                <label for="email">Correo electrónico:</label>
                <input type="email" id="email" name="email" required>
                <br><br>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
                <br><br>
                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <option value="admin">Administrador</option>
                    <option value="editor">Editor</option>
                    <option value="usuario">Usuario</option>
                </select>
                <br><br>
                <button type="submit" name="add_user" class="button">Agregar Usuario</button>
            </form>
        </div>

        <!-- Tabla de usuarios -->
        <h2>Lista de Usuarios</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['rol']}</td>
                        <td>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='user_id' value='{$row['id']}'>
                                <button type='submit' name='delete_user' class='button'>Eliminar</button>
                            </form>
                            <a href='../php/editar_usuario.php?id={$row['id']}' class='button'>Editar</a>
                        </td>
                    </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
