document.addEventListener('DOMContentLoaded', function() {
    // Variables para el slider de libros
    const bookSlider = document.getElementById('index_book_slider');
    const prevBtn = document.getElementById('prev_btn');
    const nextBtn = document.getElementById('next_btn');
    
    if (bookSlider && prevBtn && nextBtn) {
        const cards = bookSlider.querySelectorAll('.book-card');
        const cardWidth = cards.length > 0 ? cards[0].offsetWidth : 0;
        let position = 0;
        
        // Configurar botones de navegación del slider
        prevBtn.addEventListener('click', function() {
            if (position > 0) {
                position--;
                updateSliderPosition();
            }
        });
        
        nextBtn.addEventListener('click', function() {
            if (position < cards.length - 4) {
                position++;
                updateSliderPosition();
            }
        });
        
        function updateSliderPosition() {
            bookSlider.style.transform = `translateX(-${position * cardWidth}px)`;
        }
    }
    
    // Manejar añadir al carrito
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const bookId = this.getAttribute('data-id');
            alert('Libro añadido al carrito. ID del libro: ' + bookId);
            // Aquí puedes implementar la lógica para añadir al carrito
        });
    });
});

// Funcionalidad para modales y CRUD
document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos DOM
    const btnNuevoLibro = document.getElementById('btnNuevoLibro');
    const libroModal = document.getElementById('libroModal');
    const confirmarEliminarModal = document.getElementById('confirmarEliminarModal');
    const closeButtons = document.querySelectorAll('.modal-close, .modal-close-btn');
    const libroForm = document.getElementById('libroForm');
    const eliminarForm = document.getElementById('eliminarForm');
    
    // Botones de editar y eliminar
    const btnsEditar = document.querySelectorAll('.btn-editar');
    const btnsEliminar = document.querySelectorAll('.btn-eliminar');
    
    // Abrir modal de nuevo libro
    btnNuevoLibro.addEventListener('click', function() {
    // Resetear formulario
    libroForm.reset();
    document.getElementById('form_action').value = 'crear';
    document.getElementById('modalTitle').textContent = 'Nuevo Libro';
    document.getElementById('libro_id').value = '';
    document.getElementById('portada_preview').classList.add('hidden');
    
    // Mostrar modal
    libroModal.classList.remove('hidden');
    });
    
    // Cerrar modales
    closeButtons.forEach(button => {
    button.addEventListener('click', function() {
        libroModal.classList.add('hidden');
        confirmarEliminarModal.classList.add('hidden');
    });
    });
    
    // Editar libro
    btnsEditar.forEach(btn => {
    btn.addEventListener('click', function() {
        const libroId = this.getAttribute('data-id');
        const libroData = JSON.parse(document.getElementById('libro-data-' + libroId).textContent);
        
        // Rellenar formulario
        document.getElementById('form_action').value = 'actualizar';
        document.getElementById('modalTitle').textContent = 'Editar Libro';
        document.getElementById('libro_id').value = libroData.id;
        document.getElementById('titulo').value = libroData.titulo;
        document.getElementById('autor').value = libroData.autor;
        document.getElementById('genero_input').value = libroData.genero;
        document.getElementById('precio').value = libroData.precio;
        document.getElementById('descripcion').value = libroData.descripcion;
        document.getElementById('calificacion').value = libroData.calificacion;
        document.getElementById('destacado').checked = libroData.destacado == 1;
        
        // Mostrar vista previa de la portada
        if (libroData.portada) {
            document.getElementById('portada_preview').classList.remove('hidden');
            document.getElementById('portada_img').src = '../images/portadas/' + libroData.portada;
        } else {
            document.getElementById('portada_preview').classList.add('hidden');
        }
        
        // Mostrar modal
        libroModal.classList.remove('hidden');
    });
    });
    
    // Confirmar eliminación
    btnsEliminar.forEach(btn => {
    btn.addEventListener('click', function() {
        const libroId = this.getAttribute('data-id');
        document.getElementById('eliminar_id').value = libroId;
        confirmarEliminarModal.classList.remove('hidden');
    });
    });
    
    // Cerrar modales al hacer clic fuera
    window.addEventListener('click', function(event) {
    if (event.target === libroModal) {
        libroModal.classList.add('hidden');
    }
    if (event.target === confirmarEliminarModal) {
        confirmarEliminarModal.classList.add('hidden');
    }
    });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Abrir modal para agregar o editar libro
        document.querySelectorAll('.btn-editar, .btn-agregar').forEach(function(button) {
            button.addEventListener('click', function() {
                const libroId = button.getAttribute('data-id');
                // Mostrar el modal con los datos del libro si es edición
                if (libroId) {
                    const libroData = document.getElementById('libro-data-' + libroId).innerText;
                    const libro = JSON.parse(libroData);
                    document.getElementById('libro_id').value = libro.id;
                    document.getElementById('titulo').value = libro.titulo;
                    document.getElementById('autor').value = libro.autor;
                    document.getElementById('genero_input').value = libro.genero;
                    document.getElementById('precio').value = libro.precio;
                    document.getElementById('descripcion').value = libro.descripcion;
                    document.getElementById('calificacion').value = libro.calificacion;
                    document.getElementById('destacado').checked = libro.destacado;
                    document.getElementById('modalTitle').innerText = 'Editar Libro';
                    document.getElementById('form_action').value = 'editar';
                } else {
                    // Configurar el modal para crear nuevo libro
                    document.getElementById('modalTitle').innerText = 'Nuevo Libro';
                    document.getElementById('form_action').value = 'crear';
                }
                document.getElementById('libroModal').classList.remove('hidden');
            });
        });
    
        // Cerrar el modal
        document.querySelectorAll('.modal-close').forEach(function(closeButton) {
            closeButton.addEventListener('click', function() {
                document.getElementById('libroModal').classList.add('hidden');
            });
        });
    });
    
    // Funcionalidad para modales y CRUD
    document.addEventListener('DOMContentLoaded', function() {
        // Referencias a elementos DOM
        const btnNuevoLibro = document.getElementById('btnNuevoLibro');
        const libroModal = document.getElementById('libroModal');
        const confirmarEliminarModal = document.getElementById('confirmarEliminarModal');
        const closeButtons = document.querySelectorAll('.modal-close, .modal-close-btn');
        const libroForm = document.getElementById('libroForm');
        const eliminarForm = document.getElementById('eliminarForm');
        
        // Botones de editar y eliminar
        const btnsEditar = document.querySelectorAll('.btn-editar');
        const btnsEliminar = document.querySelectorAll('.btn-eliminar');
        
        // Abrir modal de nuevo libro
        btnNuevoLibro.addEventListener('click', function() {
            // Resetear formulario
            libroForm.reset();
            document.getElementById('form_action').value = 'crear';
            document.getElementById('modalTitle').textContent = 'Nuevo Libro';
            document.getElementById('libro_id').value = '';
            document.getElementById('portada_preview').classList.add('hidden');
            
            // Mostrar modal
            libroModal.classList.remove('hidden');
        });
        
        // Cerrar modales
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                libroModal.classList.add('hidden');
                confirmarEliminarModal.classList.add('hidden');
            });
        });
        
        // Editar libro
        btnsEditar.forEach(btn => {
            btn.addEventListener('click', function() {
                const libroId = this.getAttribute('data-id');
                const libroData = JSON.parse(document.getElementById('libro-data-' + libroId).textContent);
                
                // Rellenar formulario
                document.getElementById('form_action').value = 'actualizar';
                document.getElementById('modalTitle').textContent = 'Editar Libro';
                document.getElementById('libro_id').value = libroData.id;
                document.getElementById('titulo').value = libroData.titulo;
                document.getElementById('autor').value = libroData.autor;
                document.getElementById('genero_input').value = libroData.genero;
                document.getElementById('precio').value = libroData.precio;
                document.getElementById('descripcion').value = libroData.descripcion;
                document.getElementById('calificacion').value = libroData.calificacion;
                document.getElementById('destacado').checked = libroData.destacado == 1;
                
                // Mostrar vista previa de la portada
                if (libroData.portada) {
                    document.getElementById('portada_preview').classList.remove('hidden');
                    document.getElementById('portada_img').src = '../images/portadas/' + libroData.portada;
                } else {
                    document.getElementById('portada_preview').classList.add('hidden');
                }
                
                // Mostrar modal
                libroModal.classList.remove('hidden');
            });
        });
        
        // Confirmar eliminación
        btnsEliminar.forEach(btn => {
            btn.addEventListener('click', function() {
                const libroId = this.getAttribute('data-id');
                document.getElementById('eliminar_id').value = libroId;
                confirmarEliminarModal.classList.remove('hidden');
            });
        });
        
        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', function(event) {
            if (event.target === libroModal) {
                libroModal.classList.add('hidden');
            }
            if (event.target === confirmarEliminarModal) {
                confirmarEliminarModal.classList.add('hidden');
            }
        });
    });
