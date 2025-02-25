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
    var valorSeleccionado = 'local';
    var paginaActual = 1;
    var presentacionesPorPagina = 30;
    var totalPresentaciones = 0;

    var regionModal = new bootstrap.Modal(document.getElementById('regionModal'));
    regionModal.show();

    // Modificar `cargarPresentaciones` para usar filtros activos si están definidos
    function cargarPresentaciones(pagina = 1) {
        if (document.getElementById('especialidadFilter').value || document.getElementById('disponibilidadFilter').value) {
            aplicarFiltros(pagina); // Usar los filtros si están activos
        } else {
            var offset = (pagina - 1) * presentacionesPorPagina;

            var xhr = new XMLHttpRequest();
            xhr.open('GET', `./gets/obtener_presentaciones.php?limit=${presentacionesPorPagina}&offset=${offset}`, true);
            xhr.onload = function () {
                if (this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    totalPresentaciones = response.total;
                    mostrarPresentaciones(response.presentaciones, valorSeleccionado);
                    actualizarBotonesPaginacion(pagina);
                } else {
                    console.error('Error al obtener las presentaciones');
                }
            };
            xhr.send();
        }
    }

    function mostrarPresentaciones(presentaciones, tipoValor) {
        var cardContainer = document.getElementById('cardContainer');
        cardContainer.innerHTML = '';

        if (presentaciones.length === 0) {
            cardContainer.innerHTML = '<div class="no-results-message">No hay psicólogos disponibles.</div>';
            return;
        }

        var presentacionesMap = [];
        presentaciones.forEach(function (presentacion) {
            var presentacionExistente = presentacionesMap.find(p => p.id === presentacion.id);

            if (!presentacionExistente) {
                presentacionesMap.push({ ...presentacion, especialidades: [presentacion.especi] });
            } else {
                presentacionExistente.especialidades.push(presentacion.especi);
            }
        });

        presentacionesMap.forEach(function (presentacion) {
            var especialidadesHTML = presentacion.especialidades.join(', ');
            var valorMostrar = (tipoValor === 'local') ? presentacion.valor : presentacion.valor_internacional;
            var cardHTML = `
            <div class="col-lg-3 col-md-4 mb-3 d-flex mt-5 justify-content-center">
                <div class="card shadow-sm" data-id="${presentacion.id}" onclick="mostrarInformacion(this)">
                    <img src="${presentacion.rutaImagen}" class="card-img-top custom-img" alt="${presentacion.nombre}" loading="lazy">
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

        cardContainer.style.display = 'block';
    }

    // Modificar `actualizarBotonesPaginacion` para mantener los filtros al cambiar de página
    function actualizarBotonesPaginacion(paginaSeleccionada) {
        var paginacionContainer = document.getElementById('paginacion');
        paginacionContainer.innerHTML = '';

        var totalPaginas = Math.ceil(totalPresentaciones / presentacionesPorPagina);

        for (let i = 1; i <= totalPaginas; i++) {
            var button = document.createElement('button');
            button.className = `btn ${i === paginaSeleccionada ? 'btn-primary' : 'btn-outline-primary'} mx-1`;
            button.innerText = i;
            button.onclick = function () {
                paginaActual = i;
                aplicarFiltros(i); // Aplicar filtros con la nueva página
            };
            paginacionContainer.appendChild(button);
        }
    }

    cargarPresentaciones();

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
    // Asegurar que la paginación funcione con filtros
    document.getElementById('filterForm').addEventListener('submit', function (event) {
        event.preventDefault();
        paginaActual = 1; // Reiniciar a la primera página al filtrar
        aplicarFiltros(1);
    });

    // Función para aplicar filtros
    function aplicarFiltros(pagina = 1) {
        var especialidad = document.getElementById('especialidadFilter').value;
        var disponibilidad = document.getElementById('disponibilidadFilter').value;
        var ordenar = document.getElementById('ordenar').value;

        var offset = (pagina - 1) * presentacionesPorPagina;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', `./gets/obtener_presentaciones.php?especialidadFilter=${especialidad}&disponibilidadFilter=${disponibilidad}&ordenar_valor=${ordenar}&limit=${presentacionesPorPagina}&offset=${offset}`, true);
        xhr.onload = function () {
            if (this.status == 200) {
                var response = JSON.parse(this.responseText);
                totalPresentaciones = response.total; // Actualizar el total
                mostrarPresentaciones(response.presentaciones, valorSeleccionado);
                actualizarBotonesPaginacion(pagina); // Asegurar que la paginación se actualiza
            } else {
                console.error('Error al obtener las presentaciones filtradas');
            }
        };
        xhr.send();
    }

    // Carga inicial del modal
    regionModal.show();
});




