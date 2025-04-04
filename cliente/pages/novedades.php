<?php
// Configuración de la base de datos
$servername = "localhost";  // Cambia según tu configuración
$username = "root";         // Cambia según tu configuración
$password = "";             // Cambia según tu configuración
$dbname = "readabook";      // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta para obtener los últimos lanzamientos (últimos 30 días)
$sql_last_releases = "SELECT * FROM libros WHERE fecha_publicacion BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW() ORDER BY fecha_publicacion DESC LIMIT 4";
$result_last_releases = $conn->query($sql_last_releases);

// Consulta para obtener próximos lanzamientos (próximos 30 días)
$sql_upcoming_releases = "SELECT * FROM libros WHERE fecha_publicacion > NOW() AND fecha_publicacion <= DATE_ADD(NOW(), INTERVAL 30 DAY) ORDER BY fecha_publicacion ASC LIMIT 4";
$result_upcoming_releases = $conn->query($sql_upcoming_releases);

// Consulta para obtener eventos de lanzamiento
$sql_launch_events = "SELECT * FROM eventos WHERE fecha >= NOW() ORDER BY fecha ASC LIMIT 3";
$result_launch_events = $conn->query($sql_launch_events);
?>
    <!-- Header -->
    <?php include('../includes/header.php'); ?>
    <link rel="stylesheet" href="../css/styles.css">

        <!-- Hero Section for Novedades -->
        <section class="hero" id="index_hero">
            <div class="hero-content" id="index_hero_content">
                <h2>Novedades Literarias</h2>
                <p>Descubre los lanzamientos más recientes y mantente al día con las últimas tendencias en literatura.</p>
                <button class="btn-primary" id="index_cta_button">Ver todos los lanzamientos</button>
            </div>
            <div class="hero-image" id="index_hero_image">
                <!-- Imagen decorativa -->
            </div>
        </section>

        <!-- Nuevos Lanzamientos -->
        <section class="featured" id="index_featured">
            <h2>Últimos Lanzamientos</h2>
            <div class="book-slider" id="index_book_slider">
                <?php
                if ($result_last_releases->num_rows > 0) {
                    while($row = $result_last_releases->fetch_assoc()) {
                        echo '<div class="book-card">';
                        echo '<div class="book-cover">';
                        echo '<img src="' . $row["imagen_url"] . '" alt="' . $row["titulo"] . '">';
                        echo '</div>';
                        echo '<h3>' . $row["titulo"] . '</h3>';
                        echo '<p class="author">' . $row["autor"] . '</p>';
                        echo '<p class="price">$' . number_format($row["precio"], 2) . '</p>';
                        echo '<p class="release-date">Lanzamiento: ' . date("d M Y", strtotime($row["fecha_publicacion"])) . '</p>';
                        echo '<button class="btn-secondary">Reservar</button>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No hay lanzamientos recientes en este momento.</p>';
                }
                ?>
            </div>
            <div class="slider-controls" id="index_slider_controls">
                <button id="index_prev_btn" class="slider-btn">❮</button>
                <button id="index_next_btn" class="slider-btn">❯</button>
            </div>
        </section>

        <!-- Próximos Lanzamientos -->
        <section class="featured" id="upcoming_releases">
            <h2>Próximos Lanzamientos</h2>
            <div class="book-slider" id="upcoming_book_slider">
                <?php
                if ($result_upcoming_releases->num_rows > 0) {
                    while($row = $result_upcoming_releases->fetch_assoc()) {
                        echo '<div class="book-card">';
                        echo '<div class="book-cover">';
                        echo '<img src="' . $row["imagen_url"] . '" alt="' . $row["titulo"] . '">';
                        echo '</div>';
                        echo '<h3>' . $row["titulo"] . '</h3>';
                        echo '<p class="author">' . $row["autor"] . '</p>';
                        echo '<p class="price">$' . number_format($row["precio"], 2) . '</p>';
                        echo '<p class="release-date">Próximamente: ' . date("d M Y", strtotime($row["fecha_publicacion"])) . '</p>';
                        echo '<button class="btn-secondary">Pre-ordenar</button>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No hay próximos lanzamientos programados.</p>';
                }
                ?>
            </div>
            <div class="slider-controls">
                <button id="upcoming_prev_btn" class="slider-btn">❮</button>
                <button id="upcoming_next_btn" class="slider-btn">❯</button>
            </div>
        </section>

        <!-- Eventos de Lanzamiento -->
        <section class="categories" id="launch_events">
            <h2>Eventos de Lanzamiento</h2>
            <div class="event-list">
                <?php
                if ($result_launch_events->num_rows > 0) {
                    while($row = $result_launch_events->fetch_assoc()) {
                        echo '<div class="event-card">';
                        echo '<div class="event-date">';
                        echo '<span class="day">' . date("d", strtotime($row["fecha"])) . '</span>';
                        echo '<span class="month">' . date("M", strtotime($row["fecha"])) . '</span>';
                        echo '</div>';
                        echo '<div class="event-info">';
                        echo '<h3>' . $row["titulo"] . '</h3>';
                        echo '<p class="author">' . $row["descripcion"] . '</p>';
                        echo '<p class="location">' . $row["ubicacion"] . ' - ' . date("H:i", strtotime($row["fecha"])) . 'h</p>';
                        echo '<button class="btn-secondary">Reservar lugar</button>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No hay eventos programados en este momento.</p>';
                }
                ?>
            </div>
        </section>

<!-- Reseñas de Novedades -->
<section class="reading-club" id="new_reviews">
    <div class="club-content" id="review_content">
        <h2>Reseñas de Novedades</h2>
        <p>Nuestros críticos literarios analizan las obras más destacadas del mes.</p>
        
        <?php
        // Consulta para obtener las últimas reseñas
        $sql_reviews = "SELECT r.*, l.titulo as libro_titulo, l.autor as libro_autor 
                        FROM reseñas r 
                        JOIN libros l ON r.libro_id = l.id 
                        ORDER BY r.fecha_publicacion DESC 
                        LIMIT 3";
        $result_reviews = $conn->query($sql_reviews);
        
        if ($result_reviews->num_rows > 0) {
            echo '<div class="reviews-container">';
            while($row = $result_reviews->fetch_assoc()) {
                echo '<div class="review-card">';
                echo '<h3>' . $row["titulo_reseña"] . '</h3>';
                echo '<p class="review-meta">Por ' . $row["autor_reseña"] . ' - ' . date("d M Y", strtotime($row["fecha_publicacion"])) . '</p>';
                echo '<p class="review-book">Sobre: <em>' . $row["libro_titulo"] . '</em> de ' . $row["libro_autor"] . '</p>';
                echo '<div class="rating">';
                for ($i = 0; $i < $row["puntuacion"]; $i++) {
                    echo '★';
                }
                for ($i = $row["puntuacion"]; $i < 5; $i++) {
                    echo '☆';
                }
                echo '</div>';
                echo '<p class="review-content">' . substr($row["contenido"], 0, 200) . '...</p>';
                echo '<button class="btn-secondary">Leer reseña completa</button>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p>No hay reseñas recientes.</p>';
        }
        ?>
        
        <button class="btn-primary" id="review_button">Ver todas las reseñas</button>
    </div>
    <div class="club-image" id="review_image">
        <!-- Imagen aquí -->
    </div>
</section>

        <!-- Newsletter -->
        <section class="newsletter" id="index_newsletter">
            <h2>No te pierdas ninguna novedad</h2>
            <p>Suscríbete para recibir alertas de nuevos lanzamientos y eventos literarios</p>
            <form id="index_newsletter_form" action="suscribir.php" method="POST">
                <input type="email" name="email" placeholder="Tu correo electrónico" id="index_email_input" required>
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
                    <li><a href="footer/nosotros.html">Sobre nosotros</a></li>
                    <li><a href="footer/terminos-y-sevicios.html">Términos y condiciones</a></li>
                    <li><a href="footer/politicas.html">Política de privacidad</a></li>
                    <li><a href="footer/ayuda.html">Ayuda</a></li>
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

    <script src="../js/script.js"></script>
</body>
</html>
<?php
// Cerrar conexión
$conn->close();
?>