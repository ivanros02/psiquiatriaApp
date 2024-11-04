function mostrarInformacion(card) {
    const psychologistId = card.getAttribute('data-id'); // Obtiene el ID del psicólogo
    const valorSeleccionado = (document.getElementById('btnArgentina').classList.contains('active')) ? 'local' : 'internacional'; // Verifica qué botón está activo
    if (psychologistId) { // Verifica que psychologistId no sea nulo
        window.location.href = `../presentacion/presentacionProfesional.php?id=${psychologistId}&valor=${valorSeleccionado}`; // Incluye el valor en la URL
    } else {
        console.error('ID del psicólogo no encontrado.');
    }
}

// Variable para almacenar el valor de la región seleccionada
let valorSeleccionado = 'local'; // Valor por defecto

function seleccionarRegion(region) {
    valorSeleccionado = region; // Guarda el valor seleccionado

    // Elimina la clase 'active' de ambos botones
    document.getElementById('btnArgentina').classList.remove('active');
    document.getElementById('btnRestoMundo').classList.remove('active');

    // Añade la clase 'active' al botón seleccionado
    if (region === 'local') {
        document.getElementById('btnArgentina').classList.add('active');
    } else {
        document.getElementById('btnRestoMundo').classList.add('active');
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

// PRESENTACIONES
document.addEventListener("DOMContentLoaded", function () {
    var valorSeleccionado = 'local'; // Valor por defecto (local)

    // Mostrar modal de selección de región
    var regionModal = new bootstrap.Modal(document.getElementById('regionModal'));
    regionModal.show(); // Mostrar modal al cargar la página

    // Función para cargar las presentaciones
    function cargarPresentaciones() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', './gets/obtener_presentaciones.php', true);
        xhr.onload = function () {
            if (this.status == 200) {
                var presentaciones = JSON.parse(this.responseText);
                mostrarPresentaciones(presentaciones, valorSeleccionado);
            } else {
                console.error('Error al obtener las presentaciones');
            }
        };
        xhr.send();
    }

    // Función para mostrar las presentaciones en tarjetas
    function mostrarPresentaciones(presentaciones, tipoValor) {
        var cardContainer = document.getElementById('cardContainer');
        cardContainer.innerHTML = ''; // Limpia el contenedor antes de agregar tarjetas

        if (presentaciones.length === 0) {
            cardContainer.innerHTML = '<div class="no-results-message">No hay psicólogos disponibles.</div>';
            return;
        }

        // Agrupamos especialidades por id de presentación respetando el orden
        var presentacionesMap = [];
        presentaciones.forEach(function (presentacion) {
            var presentacionExistente = presentacionesMap.find(function (p) {
                return p.id === presentacion.id;
            });

            if (!presentacionExistente) {
                presentacionesMap.push({
                    ...presentacion,
                    especialidades: [presentacion.especi]
                });
            } else {
                presentacionExistente.especialidades.push(presentacion.especi);
            }
        });

        // Ahora creamos las tarjetas respetando el orden del JSON original
        presentacionesMap.forEach(function (presentacion) {
            var especialidadesHTML = presentacion.especialidades.join(', ');
            var valorMostrar = (tipoValor === 'local') ? presentacion.valor : presentacion.valor_internacional;
            var cardHTML = `
            <div class="col-lg-3 col-md-4 mb-3 d-flex mt-5 justify-content-center">
                <div class="card shadow-sm" data-id="${presentacion.id}" onclick="mostrarInformacion(this)">
                    <img src="${presentacion.rutaImagen}" class="card-img-top custom-img" alt="${presentacion.nombre}">
                    <div class="card-body d-flex flex-column">
                        <span class="tooltiptext" style="display: none;">$ ${valorMostrar}</span>
                        <h5 class="card-title">${presentacion.nombre}</h5>
                        <h6 class="card-title text-success">${presentacion.titulo}</h6>
                        <p class="card-text">${especialidadesHTML}</p>
                        <p class="text-muted">Disponibilidad en: ${presentacion.disponibilidad} hs</p>
                        <div class="mt-auto text-center">
                            <strong class="display-6">$ ${valorMostrar}</strong>
                        </div>
                    </div>
                </div>
            </div>
            `;
            cardContainer.insertAdjacentHTML('beforeend', cardHTML);
        });

        // Mostrar el contenedor de tarjetas
        cardContainer.style.display = 'block';
    }

    // Manejar la selección de la región
    document.getElementById('btnArgentina').addEventListener('click', function () {
        valorSeleccionado = 'local'; // Establecer el valor a local
        cargarPresentaciones(); // Cargar las presentaciones
        regionModal.hide(); // Ocultar modal
    });

    document.getElementById('btnRestoMundo').addEventListener('click', function () {
        valorSeleccionado = 'internacional'; // Establecer el valor a internacional
        cargarPresentaciones(); // Cargar las presentaciones
        regionModal.hide(); // Ocultar modal
    });

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

        // Realizar la petición AJAX para obtener las presentaciones filtradas
        var xhr = new XMLHttpRequest();
        xhr.open('GET', `./gets/obtener_presentaciones.php?especialidadFilter=${especialidad}&disponibilidadFilter=${disponibilidad}&ordenar_valor=${ordenar}`, true);
        xhr.onload = function () {
            if (this.status == 200) {
                var presentaciones = JSON.parse(this.responseText);
                mostrarPresentaciones(presentaciones, valorSeleccionado); // Pasar el valor seleccionado
            } else {
                console.error('Error al obtener las presentaciones filtradas');
            }
        };
        xhr.send();
    }

    // Carga inicial del modal
    regionModal.show();
});




