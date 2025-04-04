<?php
session_start();

// Verifica si el usuario está autenticado y si es un admin
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php"); // Redirige al login si no es admin
    exit();
}

// Conexión a la base de datos
include '../includes/db.php';

// Obtener el número total de usuarios
$stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
$totalUsuarios = $stmt->fetchColumn();

// Obtener el número total de libros
$stmt = $pdo->query("SELECT COUNT(*) FROM libros");
$totalLibros = $stmt->fetchColumn();

// Obtener el número de pedidos recientes
$stmt = $pdo->query("SELECT COUNT(*) FROM pedidos WHERE fecha > NOW() - INTERVAL 30 DAY");
$totalPedidos = $stmt->fetchColumn();

// Obtener los ingresos mensuales (suponiendo que tienes una tabla de ventas)
$stmt = $pdo->query("SELECT SUM(ingresos) FROM ventas WHERE fecha > NOW() - INTERVAL 30 DAY");
$ingresosMensuales = $stmt->fetchColumn();

// Verifica si $ingresosMensuales es null y asigna 0 en caso afirmativo
$ingresosMensuales = $ingresosMensuales ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Read a Book</title>
    <link rel="stylesheet" href="css/styles.css">
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
                <li class="active">
                    <a href="index.php">
                        <i class="fa-solid fa-gauge-high"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="pages/gestionar_usuarios.php">
                        <i class="fa-solid fa-users"></i>
                        <span>Gestionar Usuarios</span>
                    </a>
                </li>
                <li>
                    <a href="pages/gestionar_libros.php">
                        <i class="fa-solid fa-book"></i>
                        <span>Gestionar Libros</span>
                    </a>
                </li>
                <li>
                    <a href="pages/reportes.php">
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

        <!-- Main Content Area -->
        <main id="admin_content">
            <header id="admin_header">
                <div class="toggle-menu">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <div class="admin-search">
                    <input type="text" placeholder="Buscar...">
                    <button><i class="fa-solid fa-search"></i></button>
                </div>
                <div class="admin-actions">
                    <div class="notification">
                        <i class="fa-solid fa-bell"></i>
                        <span class="badge">3</span>
                    </div>
                    <div class="admin-dropdown">
                        <i class="fa-solid fa-user"></i>
                        <span><?php echo $_SESSION['nombre']; ?></span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>
                </div>
            </header>

            <div class="admin-container">
                <div class="admin-welcome">
                    <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?></h2>
                    <p>Panel de control principal de la plataforma "Read a Book"</p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon users">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo $totalUsuarios; ?></h3>
                            <p>Usuarios Activos</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon books">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo $totalLibros; ?></h3>
                            <p>Libros Disponibles</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon orders">
                            <i class="fa-solid fa-shopping-cart"></i>
                        </div>
                        <div class="stat-details">
                            <h3><?php echo $totalPedidos; ?></h3>
                            <p>Pedidos Recientes</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon revenue">
                            <i class="fa-solid fa-dollar-sign"></i>
                        </div>
                        <div class="stat-details">
                            <h3>$<?php echo number_format($ingresosMensuales, 2); ?></h3>
                            <p>Ingresos Mensuales</p>
                        </div>
                    </div>
                </div>

                <!-- Management Sections -->
                <div class="admin-sections">
                    <div class="admin-section-card">
                        <div class="section-header">
                            <i class="fa-solid fa-users"></i>
                            <h3>Gestión de Usuarios</h3>
                        </div>
                        <p>Administra todos los usuarios registrados en la plataforma. Añade, edita o elimina cuentas de usuario.</p>
                        <div class="quick-stats">
                            <div class="quick-stat">
                                <span><?php echo $totalUsuarios; ?></span>
                                <p>Totales</p>
                            </div>
                            <div class="quick-stat">
                                <span>98</span>
                                <p>Activos</p>
                            </div>
                            <div class="quick-stat">
                                <span>27</span>
                                <p>Inactivos</p>
                            </div>
                        </div>
                        <a href="pages/gestionar_usuarios.php" class="admin-btn">Gestionar Usuarios</a>
                    </div>

                    <div class="admin-section-card">
                        <div class="section-header">
                            <i class="fa-solid fa-book"></i>
                            <h3>Gestión de Libros</h3>
                        </div>
                        <p>Administra el catálogo de libros disponibles. Añade nuevos títulos, actualiza información o gestiona el inventario.</p>
                        <div class="quick-stats">
                            <div class="quick-stat">
                                <span><?php echo $totalLibros; ?></span>
                                <p>Totales</p>
                            </div>
                            <div class="quick-stat">
                                <span>42</span>
                                <p>Categorías</p>
                            </div>
                            <div class="quick-stat">
                                <span>15</span>
                                <p>Agotados</p>
                            </div>
                        </div>
                        <a href="pages/gestionar_libros.php" class="admin-btn">Gestionar Libros</a>
                    </div>

                    <div class="admin-section-card">
                        <div class="section-header">
                            <i class="fa-solid fa-chart-line"></i>
                            <h3>Ver Reportes</h3>
                        </div>
                        <p>Accede a estadísticas detalladas y reportes sobre ventas, usuarios y actividad en la plataforma.</p>
                        <div class="quick-stats">
                            <div class="quick-stat">
                                <span>54</span>
                                <p>Ventas</p>
                            </div>
                            <div class="quick-stat">
                                <span>23</span>
                                <p>Devoluciones</p>
                            </div>
                            <div class="quick-stat">
                                <span>$1.2k</span>
                                <p>Ingresos</p>
                            </div>
                        </div>
                        <a href="pages/reportes.php" class="admin-btn">Ver Reportes</a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="recent-activity">
                    <h3>Actividad Reciente</h3>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fa-solid fa-user-plus"></i>
                            </div>
                            <div class="activity-details">
                                <h4>Nuevo Usuario Registrado</h4>
                                <p>María Gómez se ha registrado en la plataforma</p>
                                <span class="activity-time">Hace 2 horas</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fa-solid fa-shopping-cart"></i>
                            </div>
                            <div class="activity-details">
                                <h4>Nueva Venta</h4>
                                <p>Carlos Rodríguez ha comprado "Cien años de soledad"</p>
                                <span class="activity-time">Hace 5 horas</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fa-solid fa-book"></i>
                            </div>
                            <div class="activity-details">
                                <h4>Nuevo Libro Añadido</h4>
                                <p>"El código Da Vinci" ha sido añadido al catálogo</p>
                                <span class="activity-time">Hace 1 día</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Toggle sidebar menu
        document.querySelector('.toggle-menu').addEventListener('click', function() {
            document.querySelector('.admin-wrapper').classList.toggle('sidebar-collapsed');
        });
    </script>
</body>
</html>
