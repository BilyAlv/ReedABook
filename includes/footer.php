<?php
/**
 * Footer reutilizable para el sitio ReadABook
 * 
 * @package ReadABook
 */
?>
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
            <p>Email: <?php echo htmlspecialchars('Bilymanuelalvarezsanchez@gmail.com'); ?></p>
            <p>Teléfono: (829) 267-9095</p>
            <div class="social-icons" id="index_social_icons">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
    <div class="copyright" id="index_copyright">
        <p>&copy; <?php echo date('Y'); ?> ReadABook. Todos los derechos reservados.</p>
    </div>
</footer>