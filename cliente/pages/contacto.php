    <!-- Header -->
    <?php include('../includes/header.php'); ?>
    <link rel="stylesheet" href="../css/contactos.css">

        <!-- Hero Section de Contacto -->
        <section id="contacto_hero">
            <div class="container">
                <h1>Contáctanos</h1>
                <p>Estamos aquí para ayudarte. Completa el formulario a continuación y nos pondremos en contacto contigo lo antes posible.</p>
            </div>
        </section>

        <!-- Formulario de Contacto -->
        <section id="contacto_form_section">
            <div class="container">
                <div class="contacto_columns">
                    <div class="contacto_form_container">
                        <h2>Envíanos un mensaje</h2>
                        <form action="javascript:void(0);" method="POST" id="contacto_form">
                            <div class="contacto_form_group">
                                <label for="contacto_nombre">Nombre</label>
                                <input type="text" id="contacto_nombre" name="nombre" required placeholder="Ingresa tu nombre completo">
                            </div>
                            <div class="contacto_form_group">
                                <label for="contacto_email">Correo Electrónico</label>
                                <input type="email" id="contacto_email" name="email" required placeholder="Ingresa tu correo electrónico">
                            </div>
                            <div class="contacto_form_group">
                                <label for="contacto_telefono">Teléfono (opcional)</label>
                                <input type="tel" id="contacto_telefono" name="telefono" placeholder="Ingresa tu número telefónico">
                            </div>
                            <div class="contacto_form_group">
                                <label for="contacto_asunto">Asunto</label>
                                <input type="text" id="contacto_asunto" name="asunto" required placeholder="¿Sobre qué nos escribes?">
                            </div>
                            <div class="contacto_form_group">
                                <label for="contacto_mensaje">Mensaje</label>
                                <textarea id="contacto_mensaje" name="mensaje" required placeholder="Escribe tu mensaje aquí"></textarea>
                            </div>
                            <button type="submit" class="contacto_btn_primary" id="contacto_submit_button">Enviar mensaje</button>
                        </form>
                        
                        <!-- Mensaje de confirmación -->
                        <div id="contacto_confirmation" class="contacto_confirmation_message" style="display: none;"></div>
                    </div>
                    
                    <div class="contacto_info_container">
                        <div class="contacto_info_card">
                            <h3>Información de contacto</h3>
                            <ul class="contacto_info_list">
                                <li>
                                    <span class="contacto_info_icon">📧</span>
                                    <div>
                                        <strong>Email:</strong>
                                        <p>Bilymanuelalvarezsanchez@gmail.com</p>
                                    </div>
                                </li>
                                <li>
                                    <span class="contacto_info_icon">📱</span>
                                    <div>
                                        <strong>Teléfono:</strong>
                                        <p>(829) 267-9095</p>
                                    </div>
                                </li>
                                <li>
                                    <span class="contacto_info_icon">🏢</span>
                                    <div>
                                        <strong>Horario de atención:</strong>
                                        <p>Lunes a Viernes: 9:00 AM - 6:00 PM</p>
                                        <p>Sábados: 10:00 AM - 2:00 PM</p>
                                    </div>
                                </li>
                            </ul>
                            
                            <div class="contacto_social_links">
                                <h4>Síguenos en redes sociales</h4>
                                <div class="contacto_social_icons">
                                    <a href="#" class="contacto_social_icon">Facebook</a>
                                    <a href="#" class="contacto_social_icon">Twitter</a>
                                    <a href="#" class="contacto_social_icon">Instagram</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Sección de comentarios -->
        <section id="contacto_comments_section">
            <div class="container">
                <h2>Comentarios recientes</h2>
                <ul id="contacto_comment_list"></ul>
                
                <div class="contacto_load_more">
                    <button id="contacto_load_more_btn" class="contacto_btn_secondary">Cargar más comentarios</button>
                </div>
            </div>
        </section>
        
        <!-- FAQ Section -->
        <section id="contacto_faq_section">
            <div class="container">
                <h2>Preguntas frecuentes</h2>
                <div class="contacto_faq_grid">
                    <div class="contacto_faq_item">
                        <h3>¿Cómo puedo solicitar un préstamo de libro?</h3>
                        <p>Puedes solicitar préstamos directamente desde la sección "Préstamos" de nuestra página web o visitando nuestra biblioteca física.</p>
                    </div>
                    <div class="contacto_faq_item">
                        <h3>¿Cuál es el tiempo de respuesta?</h3>
                        <p>Nos comprometemos a responder todas las consultas dentro de un plazo máximo de 24 horas hábiles.</p>
                    </div>
                    <div class="contacto_faq_item">
                        <h3>¿Ofrecen servicios de envío?</h3>
                        <p>Sí, ofrecemos envío de libros físicos dentro del país con tarifas preferenciales para nuestros miembros.</p>
                    </div>
                    <div class="contacto_faq_item">
                        <h3>¿Cómo puedo unirme al club de lectura?</h3>
                        <p>Puedes registrarte en la sección "Club de Lectura" o enviarnos un mensaje a través de este formulario.</p>
                    </div>
                </div>
            </div>
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

    <script src="../js/script.js"></script>
    <script src="../js/contacto.js"></script>
</body>
</html>