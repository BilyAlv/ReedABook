    <!-- Header -->
    <?php include('../includes/header.php'); ?>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <div class="container" id="prestamos_main_container">
        <!-- Hero Section -->
        <section id="prestamos_hero">
            <div id="prestamos_hero_content">
                <h1>Servicio de Préstamos</h1>
                <p>Disfruta de nuestro sistema de préstamos de libros físicos y digitales</p>
            </div>
        </section>

        <!-- Información del Servicio -->
        <section id="prestamos_info">
            <div class="prestamos_info_card">
                <div class="prestamos_icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h3>¿Cómo funciona?</h3>
                <p>Nuestro sistema te permite tomar prestados hasta 5 libros por un período de 3 semanas, con opción a renovar si no hay reservas pendientes.</p>
            </div>

            <div class="prestamos_info_card">
                <div class="prestamos_icon">
                    <i class="fas fa-laptop"></i>
                </div>
                <h3>Préstamos Digitales</h3>
                <p>Accede a miles de e-books y audiolibros desde cualquier dispositivo. Los préstamos digitales vencen automáticamente sin preocupaciones por multas.</p>
            </div>

            <div class="prestamos_info_card">
                <div class="prestamos_icon">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h3>Membresía</h3>
                <p>Hazte miembro para disfrutar de préstamos extendidos, acceso prioritario a nuevos lanzamientos y descuentos en compras.</p>
            </div>
        </section>

        <!-- Pestañas de Préstamos -->
        <section id="prestamos_tabs">
            <div id="prestamos_tabs_header">
                <button class="prestamos_tab_btn active" data-tab="actuales">Actuales</button>
                <button class="prestamos_tab_btn" data-tab="historial">Historial</button>
                <button class="prestamos_tab_btn" data-tab="reservados">Reservados</button>
                <button class="prestamos_tab_btn" data-tab="recomendados">Recomendados</button>
            </div>

            <!-- Contenido de las pestañas -->
            <div id="prestamos_tabs_content">
                <!-- Préstamos Actuales -->
                <div class="prestamos_tab_panel active" id="prestamos_actuales">
                    <div class="prestamos_panel_header">
                        <h2>Préstamos Actuales</h2>
                        <div class="prestamos_search">
                            <input type="text" placeholder="Buscar en préstamos...">
                            <button><i class="fas fa-search"></i></button>
                        </div>
                    </div>

                    <div class="prestamos_list">
                        <!-- Libro 1 -->
                        <div class="prestamos_item">
                            <div class="prestamos_book_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                            </div>
                            <div class="prestamos_book_info">
                                <h3>La Sombra del Viento</h3>
                                <p class="prestamos_author">Carlos Ruiz Zafón</p>
                                <div class="prestamos_details">
                                    <span><i class="fas fa-calendar-check"></i> Prestado: 15/03/2025</span>
                                    <span><i class="fas fa-calendar-times"></i> Vence: 05/04/2025</span>
                                    <span class="prestamos_format"><i class="fas fa-book"></i> Físico</span>
                                </div>
                                <div class="prestamos_progress">
                                    <div class="prestamos_progress_bar" style="width: 65%"></div>
                                    <span class="prestamos_days_left">12 días restantes</span>
                                </div>
                            </div>
                            <div class="prestamos_actions">
                                <button class="prestamos_btn prestamos_btn_primary"><i class="fas fa-redo"></i> Renovar</button>
                                <button class="prestamos_btn prestamos_btn_secondary"><i class="fas fa-undo"></i> Devolver</button>
                            </div>
                        </div>

                        <!-- Libro 2 -->
                        <div class="prestamos_item">
                            <div class="prestamos_book_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                            </div>
                            <div class="prestamos_book_info">
                                <h3>Los Pilares de la Tierra</h3>
                                <p class="prestamos_author">Ken Follett</p>
                                <div class="prestamos_details">
                                    <span><i class="fas fa-calendar-check"></i> Prestado: 10/03/2025</span>
                                    <span><i class="fas fa-calendar-times"></i> Vence: 31/03/2025</span>
                                    <span class="prestamos_format"><i class="fas fa-tablet-alt"></i> Digital</span>
                                </div>
                                <div class="prestamos_progress">
                                    <div class="prestamos_progress_bar" style="width: 40%"></div>
                                    <span class="prestamos_days_left">7 días restantes</span>
                                </div>
                            </div>
                            <div class="prestamos_actions">
                                <button class="prestamos_btn prestamos_btn_primary"><i class="fas fa-redo"></i> Renovar</button>
                                <button class="prestamos_btn prestamos_btn_secondary"><i class="fas fa-undo"></i> Devolver</button>
                            </div>
                        </div>

                        <!-- Libro 3 -->
                        <div class="prestamos_item prestamos_almost_due">
                            <div class="prestamos_book_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                            </div>
                            <div class="prestamos_book_info">
                                <h3>Sapiens: De animales a dioses</h3>
                                <p class="prestamos_author">Yuval Noah Harari</p>
                                <div class="prestamos_details">
                                    <span><i class="fas fa-calendar-check"></i> Prestado: 23/02/2025</span>
                                    <span><i class="fas fa-calendar-times"></i> Vence: 27/03/2025</span>
                                    <span class="prestamos_format"><i class="fas fa-headphones"></i> Audio</span>
                                </div>
                                <div class="prestamos_progress">
                                    <div class="prestamos_progress_bar prestamos_progress_warning" style="width: 10%"></div>
                                    <span class="prestamos_days_left">3 días restantes</span>
                                </div>
                            </div>
                            <div class="prestamos_actions">
                                <button class="prestamos_btn prestamos_btn_primary"><i class="fas fa-redo"></i> Renovar</button>
                                <button class="prestamos_btn prestamos_btn_secondary"><i class="fas fa-undo"></i> Devolver</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Historial de préstamos -->
                <div class="prestamos_tab_panel" id="prestamos_historial">
                    <div class="prestamos_panel_header">
                        <h2>Historial de Préstamos</h2>
                        <div class="prestamos_search">
                            <input type="text" placeholder="Buscar en historial...">
                            <button><i class="fas fa-search"></i></button>
                        </div>
                    </div>

                    <div class="prestamos_list">
                        <!-- Libro 1 del historial -->
                        <div class="prestamos_item prestamos_returned">
                            <div class="prestamos_book_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                            </div>
                            <div class="prestamos_book_info">
                                <h3>Crónica de una muerte anunciada</h3>
                                <p class="prestamos_author">Gabriel García Márquez</p>
                                <div class="prestamos_details">
                                    <span><i class="fas fa-calendar-check"></i> Prestado: 10/01/2025</span>
                                    <span><i class="fas fa-calendar-times"></i> Devuelto: 28/01/2025</span>
                                    <span class="prestamos_format"><i class="fas fa-book"></i> Físico</span>
                                </div>
                                <div class="prestamos_status prestamos_status_returned">
                                    <i class="fas fa-check-circle"></i> Devuelto a tiempo
                                </div>
                            </div>
                            <div class="prestamos_actions">
                                <button class="prestamos_btn prestamos_btn_accent"><i class="fas fa-star"></i> Valorar</button>
                                <button class="prestamos_btn prestamos_btn_outlined"><i class="fas fa-redo"></i> Prestar de nuevo</button>
                            </div>
                        </div>

                        <!-- Libro 2 del historial -->
                        <div class="prestamos_item prestamos_late">
                            <div class="prestamos_book_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                            </div>
                            <div class="prestamos_book_info">
                                <h3>El nombre del viento</h3>
                                <p class="prestamos_author">Patrick Rothfuss</p>
                                <div class="prestamos_details">
                                    <span><i class="fas fa-calendar-check"></i> Prestado: 05/12/2024</span>
                                    <span><i class="fas fa-calendar-times"></i> Devuelto: 10/01/2025</span>
                                    <span class="prestamos_format"><i class="fas fa-tablet-alt"></i> Digital</span>
                                </div>
                                <div class="prestamos_status prestamos_status_late">
                                    <i class="fas fa-exclamation-circle"></i> Devuelto con retraso (5 días)
                                </div>
                            </div>
                            <div class="prestamos_actions">
                                <button class="prestamos_btn prestamos_btn_accent"><i class="fas fa-star"></i> Valorar</button>
                                <button class="prestamos_btn prestamos_btn_outlined"><i class="fas fa-redo"></i> Prestar de nuevo</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Libros Reservados -->
                <div class="prestamos_tab_panel" id="prestamos_reservados">
                    <div class="prestamos_panel_header">
                        <h2>Libros Reservados</h2>
                        <div class="prestamos_search">
                            <input type="text" placeholder="Buscar en reservas...">
                            <button><i class="fas fa-search"></i></button>
                        </div>
                    </div>

                    <div class="prestamos_list">
                        <!-- Libro 1 reservado -->
                        <div class="prestamos_item prestamos_reserved">
                            <div class="prestamos_book_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                            </div>
                            <div class="prestamos_book_info">
                                <h3>El infinito en un junco</h3>
                                <p class="prestamos_author">Irene Vallejo</p>
                                <div class="prestamos_details">
                                    <span><i class="fas fa-calendar-plus"></i> Reservado: 18/03/2025</span>
                                    <span class="prestamos_format"><i class="fas fa-book"></i> Físico</span>
                                </div>
                                <div class="prestamos_status prestamos_status_waiting">
                                    <i class="fas fa-clock"></i> Disponible aproximadamente en 7 días
                                </div>
                            </div>
                            <div class="prestamos_actions">
                                <button class="prestamos_btn prestamos_btn_danger"><i class="fas fa-times"></i> Cancelar reserva</button>
                                <button class="prestamos_btn prestamos_btn_outlined"><i class="fas fa-bell"></i> Notificarme</button>
                            </div>
                        </div>

                        <!-- Libro 2 reservado -->
                        <div class="prestamos_item prestamos_reserved prestamos_ready">
                            <div class="prestamos_book_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                            </div>
                            <div class="prestamos_book_info">
                                <h3>Terra Alta</h3>
                                <p class="prestamos_author">Javier Cercas</p>
                                <div class="prestamos_details">
                                    <span><i class="fas fa-calendar-plus"></i> Reservado: 01/03/2025</span>
                                    <span class="prestamos_format"><i class="fas fa-tablet-alt"></i> Digital</span>
                                </div>
                                <div class="prestamos_status prestamos_status_ready">
                                    <i class="fas fa-check-circle"></i> ¡Disponible para recoger!
                                </div>
                            </div>
                            <div class="prestamos_actions">
                                <button class="prestamos_btn prestamos_btn_success"><i class="fas fa-download"></i> Obtener ahora</button>
                                <button class="prestamos_btn prestamos_btn_danger"><i class="fas fa-times"></i> Cancelar reserva</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recomendados -->
                <div class="prestamos_tab_panel" id="prestamos_recomendados">
                    <div class="prestamos_panel_header">
                        <h2>Libros Recomendados para Ti</h2>
                        <p>Basado en tus préstamos anteriores y preferencias de lectura</p>
                    </div>

                    <div id="prestamos_recomendados_grid">
                        <!-- Libro recomendado 1 -->
                        <div class="prestamos_recomendado_card">
                            <div class="prestamos_recomendado_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                                <div class="prestamos_recomendado_badge">95% Match</div>
                            </div>
                            <div class="prestamos_recomendado_info">
                                <h3>Reina Roja</h3>
                                <p class="prestamos_author">Juan Gómez-Jurado</p>
                                <div class="prestamos_rating">
                                    <div class="prestamos_stars">★★★★★</div>
                                    <span class="prestamos_reviews">(217 reseñas)</span>
                                </div>
                                <div class="prestamos_availability prestamos_available">
                                    <i class="fas fa-check-circle"></i> Disponible
                                </div>
                                <button class="prestamos_btn prestamos_btn_wide"><i class="fas fa-book-open"></i> Reservar</button>
                            </div>
                        </div>

                        <!-- Libro recomendado 2 -->
                        <div class="prestamos_recomendado_card">
                            <div class="prestamos_recomendado_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                                <div class="prestamos_recomendado_badge">88% Match</div>
                            </div>
                            <div class="prestamos_recomendado_info">
                                <h3>La ciudad y los perros</h3>
                                <p class="prestamos_author">Mario Vargas Llosa</p>
                                <div class="prestamos_rating">
                                    <div class="prestamos_stars">★★★★☆</div>
                                    <span class="prestamos_reviews">(145 reseñas)</span>
                                </div>
                                <div class="prestamos_availability prestamos_available">
                                    <i class="fas fa-check-circle"></i> Disponible
                                </div>
                                <button class="prestamos_btn prestamos_btn_wide"><i class="fas fa-book-open"></i> Reservar</button>
                            </div>
                        </div>

                        <!-- Libro recomendado 3 -->
                        <div class="prestamos_recomendado_card">
                            <div class="prestamos_recomendado_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                                <div class="prestamos_recomendado_badge">82% Match</div>
                            </div>
                            <div class="prestamos_recomendado_info">
                                <h3>El silencio de la ciudad blanca</h3>
                                <p class="prestamos_author">Eva García Sáenz de Urturi</p>
                                <div class="prestamos_rating">
                                    <div class="prestamos_stars">★★★★☆</div>
                                    <span class="prestamos_reviews">(189 reseñas)</span>
                                </div>
                                <div class="prestamos_availability prestamos_unavailable">
                                    <i class="fas fa-clock"></i> No disponible
                                </div>
                                <button class="prestamos_btn prestamos_btn_wide prestamos_btn_disabled"><i class="fas fa-bell"></i> Notificarme</button>
                            </div>
                        </div>

                        <!-- Libro recomendado 4 -->
                        <div class="prestamos_recomendado_card">
                            <div class="prestamos_recomendado_cover">
                                <img src="img/placeholder.jpg" alt="Portada del libro">
                                <div class="prestamos_recomendado_badge">75% Match</div>
                            </div>
                            <div class="prestamos_recomendado_info">
                                <h3>Patria</h3>
                                <p class="prestamos_author">Fernando Aramburu</p>
                                <div class="prestamos_rating">
                                    <div class="prestamos_stars">★★★★★</div>
                                    <span class="prestamos_reviews">(264 reseñas)</span>
                                </div>
                                <div class="prestamos_availability prestamos_available">
                                    <i class="fas fa-check-circle"></i> Disponible
                                </div>
                                <button class="prestamos_btn prestamos_btn_wide"><i class="fas fa-book-open"></i> Reservar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section id="prestamos_faq">
            <h2>Preguntas Frecuentes</h2>

            <div class="prestamos_accordion">
                <div class="prestamos_accordion_item">
                    <div class="prestamos_accordion_header">
                        <h3>¿Cuántos libros puedo tener prestados a la vez?</h3>
                        <span class="prestamos_accordion_icon"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="prestamos_accordion_content">
                        <p>Nuestros miembros estándar pueden tener hasta 5 libros prestados simultáneamente. Los miembros premium pueden disfrutar de hasta 10 préstamos a la vez. Esta cuota incluye tanto libros físicos como digitales.</p>
                    </div>
                </div>

                <div class="prestamos_accordion_item">
                    <div class="prestamos_accordion_header">
                        <h3>¿Cómo puedo renovar un préstamo?</h3>
                        <span class="prestamos_accordion_icon"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="prestamos_accordion_content">
                        <p>Puedes renovar un préstamo hasta 3 veces siempre que no haya sido reservado por otro usuario. Para renovar, simplemente haz clic en el botón "Renovar" junto al libro en tu lista de préstamos actuales o visita cualquiera de nuestras sucursales con el libro físico.</p>
                    </div>
                </div>

                <div class="prestamos_accordion_item">
                    <div class="prestamos_accordion_header">
                        <h3>¿Qué sucede si devuelvo un libro con retraso?</h3>
                        <span class="prestamos_accordion_icon"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="prestamos_accordion_content">
                        <p>Los retrasos en las devoluciones generan una multa de 0,50€ por día y libro para ejemplares físicos. Los préstamos digitales se devuelven automáticamente al finalizar el período sin generar multas. Acumular multas sin pagar puede resultar en la suspensión temporal del servicio de préstamos.</p>
                    </div>
                </div>

                <div class="prestamos_accordion_item">
                    <div class="prestamos_accordion_header">
                        <h3>¿Cómo funciona el sistema de reservas?</h3>
                        <span class="prestamos_accordion_icon"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="prestamos_accordion_content">
                        <p>Cuando un libro no está disponible, puedes reservarlo para que sea tuyo cuando sea devuelto. Recibirás una notificación cuando el libro esté disponible y tendrás 3 días para recogerlo o descargarlo antes de que pase al siguiente usuario en la lista de espera.</p>
                    </div>
                </div>

                <div class="prestamos_accordion_item">
                    <div class="prestamos_accordion_header">
                        <h3>¿Puedo acceder a los préstamos digitales desde cualquier dispositivo?</h3>
                        <span class="prestamos_accordion_icon"><i class="fas fa-plus"></i></span>
                    </div>
                    <div class="prestamos_accordion_content">
                        <p>Sí, nuestros préstamos digitales son compatibles con la mayoría de dispositivos: ordenadores, tablets, e-readers y smartphones. Solo necesitas instalar nuestra aplicación ReadABook para gestionar y disfrutar de tus préstamos digitales desde cualquier lugar.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Estadísticas de lectura -->
        <section id="prestamos_stats">
            <h2>Tus Estadísticas de Lectura</h2>
            <div id="prestamos_stats_grid">
                <div class="prestamos_stat_card">
                    <div class="prestamos_stat_icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="prestamos_stat_info">
                        <span class="prestamos_stat_value">27</span>
                        <span class="prestamos_stat_label">Libros leídos este año</span>
                    </div>
                </div>
                
                <div class="prestamos_stat_card">
                    <div class="prestamos_stat_icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="prestamos_stat_info">
                        <span class="prestamos_stat_value">186</span>
                        <span class="prestamos_stat_label">Horas de lectura</span>
                    </div>
                </div>
                
                <div class="prestamos_stat_card">
                    <div class="prestamos_stat_icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="prestamos_stat_info">
                        <span class="prestamos_stat_value">8</span>
                        <span class="prestamos_stat_label">Géneros explorados</span>
                    </div>
                </div>
                
                <div class="prestamos_stat_card">
                    <div class="prestamos_stat_icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="prestamos_stat_info">
                        <span class="prestamos_stat_value">4.2</span>
                        <span class="prestamos_stat_label">Valoración media</span>
                    </div>
                </div>
            </div>
            <div id="prestamos_stats_cta">
                <a href="estadisticas.html" class="prestamos_btn prestamos_btn_large">Ver estadísticas completas</a>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer id="prestamos_footer">
        <div class="container">
            <div id="prestamos_footer_content">
                <div class="footer-section" id="prestamos_footer_about">
                    <h3>Sobre ReadABook</h3>
                    <p>Somos una librería digital comprometida con fomentar el amor por la lectura y facilitar el acceso a los mejores libros.</p>
                </div>
                <div class="footer-section" id="prestamos_footer_links">
                    <h3>Enlaces rápidos</h3>
                    <ul>
                        <li><a href="nosotros.html">Sobre nosotros</a></li>
                        <li><a href="terminos-y-sevicios.html">Términos y condiciones</a></li>
                        <li><a href="politicas.html">Política de privacidad</a></li>
                        <li><a href="ayuda.html">Ayuda</a></li>
                    </ul>
                </div>
                <div class="footer-section" id="prestamos_footer_contact">
                    <h3>Contacto</h3>
                    <p>Email: Bilymanuelalvarezsanchez@gmail.com</p>
                    <p>Teléfono: (829) 267-9095</p>
                    <div class="social-icons" id="prestamos_social_icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            <div id="prestamos_copyright">
                <p>&copy; 2025 ReadABook. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script src="js/prestamos.js"></script>
</body>
</html>