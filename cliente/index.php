<?php
// Conexión a la base de datos
$servername = "localhost";  
$username = "root";        
$password = "";             
$dbname = "readabook";      

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener libros destacados (primeros 4 libros con campo 'destacado' = 1)
$sql_books = "SELECT * FROM libros WHERE destacado = 1 LIMIT 4";
$result_books = $conn->query($sql_books);

// Obtener categorías (cambiando a la tabla 'categorias')
$sql_categories = "SELECT * FROM categorias";
$result_categories = $conn->query($sql_categories);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadABook - Tu Librería Digital</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container" id="index_container">
        <!-- Header -->
        <header id="index_header">
            <div class="container" id="index_header_container">
                <div class="logo" id="index_logo">
                    <h1>ReadABook</h1>
                    <p>Tu librería digital favorita</p>
                </div>
                <nav id="index_navigation">
                    <ul>
                        <li><a href="#" class="active">Inicio</a></li>
                        <li><a href="pages/catalogo.php">Catálogo</a></li>
                        <li><a href="/pages/prestamos.html">Préstamos</a></li>
                        <li><a href="/pages/novedades.html">Novedades</a></li>
                        <li><a href="/pages/club-de-lectura.html">Club de Lectura</a></li>
                        <li><a href="/pages/contacto.html">Contacto</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero" id="index_hero">
            <div class="hero-content" id="index_hero_content">
                <h2>Descubre mundos a través de la lectura</h2>
                <p>Miles de libros esperan por ti. Encuentra tu próxima aventura literaria.</p>
                <button class="btn-primary" id="index_cta_button">Explorar catálogo</button>
            </div>
            <div class="hero-image" id="index_hero_image">
                <img src="images/seccion/libros.jpg">
            </div>
        </section>

        <!-- Featured Books -->
        <section class="featured" id="index_featured">
            <h2>Libros destacados</h2>
            <div class="book-slider" id="index_book_slider">
                <?php
                if ($result_books->num_rows > 0) {
                    while($row = $result_books->fetch_assoc()) {
                        echo '
                            <div class="book-card">
                                <div class="book-cover">
                                    <img src="' . $row['portada'] . '" alt="Portada del libro">
                                </div>
                                <h3>' . $row['titulo'] . '</h3>
                                <p class="author">' . $row['autor'] . '</p>
                                <p class="price">$' . $row['precio'] . '</p>
                                <button class="btn-secondary">Añadir al carrito</button>
                            </div>
                        ';
                    }
                } else {
                    echo "No hay libros disponibles.";
                }
                ?>
            </div>
            <div class="slider-controls" id="index_slider_controls">
                <button id="index_prev_btn" class="slider-btn">❮</button>
                <button id="index_next_btn" class="slider-btn">❯</button>
            </div>
        </section>

        <!-- Categories -->
        <section class="categories" id="index_categories">
            <h2>Explora por categorías</h2>
            <div class="category-grid" id="index_category_grid">
                <?php
                if ($result_categories->num_rows > 0) {
                    while($category = $result_categories->fetch_assoc()) {
                        echo '
                            <div class="category">
                                <div class="category-icon">
                                    <i class="bi bi-book"></i> <!-- Icono genérico, puede ser mejorado -->
                                </div>
                                <h3>' . $category['nombre'] . '</h3>
                            </div>
                        ';
                    }
                } else {
                    echo "No hay categorías disponibles.";
                }
                ?>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="newsletter" id="index_newsletter">
            <h2>Mantente actualizado</h2>
            <p>Suscríbete a nuestro boletín para recibir novedades y ofertas exclusivas</p>
            <form id="index_newsletter_form" method="POST" action="/includes/subscribe.php">
                <input type="email" placeholder="Tu correo electrónico" id="index_email_input" name="email" required>
                <button type="submit" class="btn-primary" id="index_submit_button">Suscribirse</button>
            </form>
        </section>
    </div>

    <!-- Footer -->
    <footer id="index_footer">
        <div class="footer-content" id="index_footer_content">
            <div class="footer-section" id="index_footer_about">
                <h3>Sobre ReadABook</h3>
                <p>Somos una librería digital comprometida con fomentar el amor por la lectura y facilitar el acceso a los mejores libros.</p>
            </div>
            <div class="footer-section" id="index_footer_links">
                <h3>Enlaces rápidos</h3>
                <ul>
                    <li><a href="/pages/footer/nosotros.html">Sobre nosotros</a></li>
                    <li><a href="/pages/footer/terminos-y-sevicios.html">Términos y condiciones</a></li>
                    <li><a href="/pages/footer/politicas.html">Política de privacidad</a></li>
                    <li><a href="/pages/footer/ayuda.html">Ayuda</a></li>
                </ul>
            </div>
            <div class="footer-section" id="index_footer_contact">
                <h3>Contacto</h3>
                <p>Email: Bilymanuelalvarezsanchez@gmail.com</p>
                <p>Teléfono: (829) 267-9095</p>
                <div class="social-icons" id="index_social_icons">
                    <!-- Iconos de redes sociales aquí -->
                </div>
            </div>
        </div>
        <div class="copyright" id="index_copyright">
            <p>&copy; 2025 ReadABook. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>

<?php
// Cerrar conexión
$conn->close();
?>
