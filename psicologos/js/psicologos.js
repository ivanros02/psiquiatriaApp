function mostrarInformacion(card) {
    const psychologistId = card.getAttribute('data-id'); // Cambié aquí para asegurarme de que accedemos correctamente al data-id
    if (psychologistId) { // Verifica que psychologistId no sea nulo
        window.location.href = `../presentacion/presentacionProfesional.php?id=${psychologistId}`;
    } else {
        console.error('ID del psicólogo no encontrado.');
    }
}


//ESPECIALIDADES
document.addEventListener("DOMContentLoaded", function () {
    // Función para cargar las especialidades
    function cargarEspecialidades() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './gets/obtener_especialidades.php', true);
        xhr.onload = function () {
            if (this.status == 200) {
                var especialidades = JSON.parse(this.responseText);
                var select = document.getElementById('especialidadFilter');
                // Limpia el select antes de agregar opciones
                select.innerHTML = '<option value="">Todos</option>'; // Opción por defecto

                especialidades.forEach(function (especialidad) {
                    var option = document.createElement('option');
                    option.value = especialidad.id; // Guardar el ID en el valor
                    option.textContent = especialidad.especi; // Nombre de la especialidad
                    select.appendChild(option); // Agrega la opción al select
                });
            } else {
                console.error('Error al obtener las especialidades');
            }
        };
        xhr.send();
    }

    // Llama a la función para cargar las especialidades al cargar la página
    cargarEspecialidades();
});

//PRESENTACIONES
document.addEventListener("DOMContentLoaded", function () {
    // Función para cargar las presentaciones
    function cargarPresentaciones() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './gets/obtener_presentaciones.php', true);
        xhr.onload = function () {
            if (this.status == 200) {
                var presentaciones = JSON.parse(this.responseText);
                mostrarPresentaciones(presentaciones);
            } else {
                console.error('Error al obtener las presentaciones');
            }
        };
        xhr.send();
    }

    // Función para mostrar las presentaciones en tarjetas
    function mostrarPresentaciones(presentaciones) {
        var cardContainer = document.getElementById('cardContainer');
        cardContainer.innerHTML = ''; // Limpia el contenedor antes de agregar tarjetas

        if (presentaciones.length === 0) {
            cardContainer.innerHTML = '<div class="no-results-message">No hay psicólogos disponibles.</div>';
            return;
        }

        // Agrupamos especialidades por id de presentación respetando el orden
        var presentacionesMap = [];
        presentaciones.forEach(function (presentacion) {
            // Verificamos si la presentación ya está en el array `presentacionesMap`
            var presentacionExistente = presentacionesMap.find(function (p) {
                return p.id === presentacion.id;
            });

            if (!presentacionExistente) {
                // Si no existe, la añadimos con un array vacío de especialidades
                presentacionesMap.push({
                    ...presentacion, // Copiamos las propiedades de la presentación
                    especialidades: [presentacion.especi] // Inicializamos con la especialidad actual
                });
            } else {
                // Si ya existe, solo añadimos la nueva especialidad
                presentacionExistente.especialidades.push(presentacion.especi);
            }
        });

        // Ahora creamos las tarjetas respetando el orden del JSON original
        presentacionesMap.forEach(function (presentacion) {
            var especialidadesHTML = presentacion.especialidades.join(', '); // Une las especialidades en un string
            var cardHTML = `
            <div class="col-lg-3 col-md-4 mb-3 d-flex mt-5 justify-content-center">
                <div class="card shadow-sm" data-id="${presentacion.id}" onclick="mostrarInformacion(this)">
                    <img src="${presentacion.rutaImagen}" class="card-img-top custom-img" alt="${presentacion.nombre}">
                    <div class="card-body d-flex flex-column">
                        <span class="tooltiptext" style="display: none;">$ ${presentacion.valor}</span>
                        <h5 class="card-title">${presentacion.nombre}</h5>
                        <h6 class="card-title text-success">${presentacion.titulo}</h6>
                        <p class="card-text">${especialidadesHTML}</p>
                        <p class="text-muted">Disponibilidad en: ${presentacion.disponibilidad} hs</p>
                        <div class="mt-auto text-center"> <!-- Se agregó un div aquí -->
                            <strong class="display-6">$ ${presentacion.valor}</strong> <!-- Mostrar el valor -->
                        </div>
                    </div>
                </div>
            </div>






        `;
            cardContainer.insertAdjacentHTML('beforeend', cardHTML);
        });
    }


    // Evento para el envío del formulario
    var filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Evitar el envío del formulario
            aplicarFiltros(); // Llamar a la función para aplicar filtros
        });
    } else {
        console.error('El formulario de filtros no se encontró en el DOM');
    }

    // Función para aplicar filtros
    function aplicarFiltros() {
        var especialidad = document.getElementById('especialidadFilter').value;
        var disponibilidad = document.getElementById('disponibilidadFilter').value;
        var ordenar = document.getElementById('ordenar').value;
        // Verificar los valores que se envían
        console.log('Especialidad:', especialidad, 'Disponibilidad:', disponibilidad, 'Ordenar:', ordenar);




        // Realizar la petición AJAX para obtener las presentaciones filtradas
        var xhr = new XMLHttpRequest();
        xhr.open('GET', `./gets/obtener_presentaciones.php?especialidadFilter=${especialidad}&disponibilidadFilter=${disponibilidad}&ordenar_valor=${ordenar}`, true);
        xhr.onload = function () {
            if (this.status == 200) {
                var presentaciones = JSON.parse(this.responseText);
                console.log(presentaciones)
                mostrarPresentaciones(presentaciones);
            } else {
                console.error('Error al obtener las presentaciones filtradas');
            }
        };
        xhr.send();
    }

    // Carga inicial de presentaciones
    cargarPresentaciones();
});


