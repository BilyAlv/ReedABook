<?php
// header.php - Encabezado reusable para el sitio

/**
 * Determina si el enlace actual debe marcarse como activo
 * @param string $currentPage La página que se está verificando
 * @param string $pageName El nombre de la página para comparar
 * @return string 'active' si coincide, cadena vacía si no
 */
function isActive($currentPage, $pageName) {
    return strpos($currentPage, $pageName) !== false ? 'active' : '';
}

// Obtener el nombre de la página actual
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadABook - Tu librería digital favorita</title>
    <link rel="stylesheet" href="../cliente/css/styles.css">
</head>
<body>
    <!-- Header -->
    <header id="catalogo_header">
        <div class="container" id="catalogo_header_container">
            <div class="logo" id="catalogo_logo">
                <h1>ReadABook</h1>
                <p>Tu librería digital favorita</p>
            </div>
            <nav id="catalogo_navigation">
                <ul>
                    <li><a href="../index.php" class="<?= isActive($currentPage, 'index.php') ?>">Inicio</a></li>
                    <li><a href="../pages/catalogo.php" class="<?= isActive($currentPage, 'catalogo.php') ?>">Catálogo</a></li>
                    <li><a href="prestamos.php" class="<?= isActive($currentPage, 'prestamos.php') ?>">Préstamos</a></li>
                    <li><a href="novedades.php" class="<?= isActive($currentPage, 'novedades.php') ?>">Novedades</a></li>
                    <li><a href="club-de-lectura.php" class="<?= isActive($currentPage, 'club-de-lectura.php') ?>">Club de Lectura</a></li>
                    <li><a href="contacto.php" class="<?= isActive($currentPage, 'contacto.php') ?>">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>