const urlParams = new URLSearchParams(window.location.search);
const presentaciontId = urlParams.get('id');
const valor = urlParams.get('valor');
$(document).ready(function () {
    if (presentaciontId) {
        $.ajax({
            url: `./gets/get_presentacion.php?id=${presentaciontId}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const { presentaciones, comentarios } = data;

                const psicologo = presentaciones[0];
                if (psicologo) {
                    $('#cardContainer').empty();

                    // Tarjeta de presentación
                    const card = `
                        <div class="card mb-3 custom-margin-top" id="cardPresentacion">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="${psicologo.rutaImagen}" class="img-fluid rounded-start custom-img" alt="${psicologo.nombre}">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title">${psicologo.nombre}</h5>
                                    <h5 class="card-titleDos text-muted">${psicologo.titulo}</h5>
                                    <p class="card-text">
                                        Matrícula: MN ${psicologo.matricula} (AR)<br>
                                        Matrícula: MP ${psicologo.matriculaP} (AR)
                                    </p>
                                    <h5 class="card-title">Especialidades</h5>
                                    <p class="card-text">${psicologo.especialidades}</p>
                                    <p class='card-valor tooltiptext' data-valor='${valor === 'local' ? psicologo.valor : psicologo.valor_internacional}'>$ ${valor === 'local' ? psicologo.valor : psicologo.valor_internacional}</p>
                                    <div class="text-center">
                                        <button class="button-33 btn-primary" id="contact">Contactar</button>
                                    </div>

                                    <!-- Carrusel de comentarios -->
                                        <div id="comentariosCarousel" class="carousel slide mt-5" data-bs-ride="carousel">
                                        <div class="carousel-inner" id="carouselComentarios">
                                            ${comentarios.map((comentario, index) => `
                                                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                                    <div class="testimonial">
                                                        <blockquote>"${comentario.comentario}"</blockquote>
                                                        <div></div>
                                                        <p>${comentario.nombre}</p>
                                                    </div>
                                                </div>
                                            `).join('')}
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#comentariosCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Anterior</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#comentariosCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Siguiente</span>
                                        </button>
                                    </div>

                                    <!-- End carrusel-->
                                </div>
                            </div>
                        </div>


                    </div>



                    `;

                    $('#cardContainer').append(card);


                    // Inicializar el carrusel de Bootstrap después de agregarlo al DOM
                    $('#comentariosCarousel').carousel({
                        interval: 5000,  // Puedes ajustar el intervalo a tu preferencia
                        ride: 'carousel'
                    });


                    // Presentación
                    const presentacionCard = `
                        <div class="card mb-5">
                            <div class="card-body">
                            
                                <h5 class="card-title">Presentación</h5>
                                <p class="card-text">${psicologo.descripcion}</p>
                            </div>
                        </div>
                    `;
                    $('#cardContainer').append(presentacionCard);

                    // Ventana modal
                    const modal = `
                        <!-- Modal -->
                            <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content card-modern-shadow" style="background-color: #f4f4f4; border-radius: 15px;">
                                        <div class="modal-header" style="border-bottom: none; padding-bottom: 0; overflow-y: hidden;">
                                            <h5 class="modal-title category-modern" id="contactModalLabel">Aviso Importante</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background: transparent; border: none;"></button>
                                        </div>
                                        <div class="modal-body content-modern">
                                            <h6 class="category-modern">Plataforma Segura</h6>
                                            <p class="description-modern">
                                                Estimado usuario, por favor, ten en cuenta que estás a punto de ser redirigido a nuestra plataforma de pago segura para completar tu transacción. Garantizamos la confidencialidad y seguridad de tus datos durante este proceso. Asegúrate de revisar cuidadosamente los detalles de tu compra antes de proceder con el pago. Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos. ¡Gracias por tu confianza! Equipo de Terapia Libre.
                                            </p>
                                            <div class="mb-3 modern-input-container">
                                                <label for="user-email" class="form-label-modern">Correo Electrónico:</label>
                                                <input type="email" class="form-control-modern" id="user-email" name="user-email" placeholder="Ingresar mail..." required>
                                            </div>
                                            <div style="text-align: center;">
                                                <button class="btn-modern-primary" id="checkout-btn" data-psychologist-id="${psicologo.id}">Contactar Profesional</button>
                                            </div>
                                            <div id="wallet_container" style="margin-top: 10px;">
                                                    <p id="mp-loading-message" style="text-align: center; display: none;">Botón de Mercado Pago cargando...</p>
                                            </div>

                                            <div id="paypal-button-container" style="margin-top: 10px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                    `;
                    $('body').append(modal);

                    const modal_turno = `
                            <div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="calendarModalLabel">Seleccionar Turno</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="calendar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                    $('body').append(modal_turno)



                    // Obtener el valor de si el usuario está logueado o no desde el atributo data
                    var usuarioLogueado = document.body.getAttribute('data-usuario-logueado') === 'true';

                    // Manejar el clic en el botón de contactar
                    /* 
                    document.getElementById('contact').addEventListener('click', function () {
                            if (usuarioLogueado) {
                                // Llamada AJAX para obtener los turnos disponibles del profesional
                                $.ajax({
                                    url: `./gets/get_turnos_disponibles.php?id=${psicologo.id}`,
                                    type: 'GET',
                                    dataType: 'json',
                                    success: function (turnos) {
                                        // Procesar y mostrar el calendario en el modal
                                        mostrarCalendarioModal(turnos);
                                    },
                                    error: function (xhr, status, error) {
                                        console.error('Error en la carga de turnos disponibles:', error);
                                    }
                                });
                            } else {
                                // Redirigir al usuario a la página de inicio de sesión si no está logueado
                                const currentUrl = window.location.href;
                                window.location.href = `../usuario/index.php?redirect_to=${encodeURIComponent(currentUrl)}`;
                            }
                        });
                    */

                    document.getElementById('contact').addEventListener('click', function () {
                        if (usuarioLogueado) {
                            // Llamada AJAX para obtener los turnos disponibles del profesional
                            $.ajax({
                                url: `./gets/get_turnos_disponibles.php?id=${psicologo.id}`,
                                type: 'GET',
                                dataType: 'json',
                                success: function (turnos) {
                                    // Procesar y mostrar el calendario en el modal
                                    console.log(turnos); // Verifica que los turnos están bien formados
                                    mostrarCalendarioModal(turnos);
                                },
                                error: function (xhr, status, error) {
                                    console.error('Error en la carga de turnos disponibles:', error);
                                }
                            });
                        } else {
                            // Redirigir al usuario a la página de inicio de sesión si no está logueado
                            const currentUrl = window.location.href;
                            window.location.href = `../usuario/index.php?redirect_to=${encodeURIComponent(currentUrl)}`;
                        }
                    });



                    function mostrarCalendarioModal(turnos) {
                        var calendarModal = new bootstrap.Modal(document.getElementById('calendarModal'));
                        var calendarEl = document.getElementById('calendar');
                        calendarEl.innerHTML = '';

                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridWeek',
                            themeSystem: 'bootstrap',
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: ''
                            },
                            buttonText: {
                                today: 'Hoy'
                            },
                            selectable: true,
                            locale: 'es',
                            events: turnos.map(turno => {
                                const start = `${turno.fecha}T${turno.hora}`;
                                const end = new Date(start);
                                end.setHours(end.getHours() + 1);

                                // Formatear la hora
                                let [hour, minute] = turno.hora.split(':'); // Divide la hora y el minuto
                                let formattedTime = `${hour}:${minute}`; // Vuelve a construir el formato

                                return {
                                    id: Number(turno.id),
                                    title: formattedTime, // Solo la hora en el título
                                    start: start,
                                    end: end.toISOString(),
                                    color: turno.disponible === "1" ? '#b6e6f6' : '#ff6f61',
                                    textColor: '#000',
                                    extendedProps: {
                                        terapeuta: turno.terapeuta
                                    }
                                };
                            }),
                            eventContent: function (arg) {
                                let eventInfo = arg.event.extendedProps;
                                let time = document.createElement('div');
                                time.innerHTML = `<strong>${arg.event.title}</strong>`; // Mostrar solo la hora

                                let name = document.createElement('div');
                                name.innerHTML = `<small>${eventInfo.terapeuta}</small>`; // Mostrar el nombre debajo

                                return { domNodes: [time, name] };
                            },
                            eventClick: function (info) {
                                if (confirm("¿Quieres seleccionar este turno con el terapeuta?")) {
                                    seleccionarTurno(info.event.id);
                                    window.location.href = "../usuario/dashboard/dashboard.php";
                                }
                            },
                            windowResize: function (view) {
                                // Cambia la vista al tamaño de pantalla al redimensionar
                                if (window.innerWidth < 768) {
                                    calendar.changeView('timeGridDay');
                                } else {
                                    calendar.changeView('dayGridWeek');
                                }
                                calendar.render(); // Asegúrate de volver a renderizar los eventos
                            },
                            editable: false,
                            eventBorderColor: '#ffffff',
                            eventDisplay: 'block',
                            height: 'auto',
                            navLinks: true,
                        });

                        calendarModal.show();

                        calendarModal._element.addEventListener('shown.bs.modal', function () {
                            calendar.render(); // Renderiza el calendario al abrir el modal
                        });
                    }






                    var usuarioId = document.body.getAttribute('data-usuario-id');

                    function seleccionarTurno(turnoId) {
                        if (!usuarioId) {
                            console.error("El ID de usuario no está definido.");
                            return;
                        }
                        console.log(usuarioId)
                        $.ajax({
                            url: './sets/set_reserva_turno.php',
                            type: 'POST',
                            data: {
                                turno_id: turnoId,
                                usuario_id: usuarioId
                            },
                            success: function (response) {
                                try {
                                    const res = JSON.parse(response);
                                    if (res.success) {
                                        alert("Turno reservado exitosamente");
                                    } else {
                                        alert(res.error || "Error al reservar el turno");
                                    }
                                } catch (error) {
                                    console.error("Respuesta no válida:", response);
                                    alert("Hubo un problema con la respuesta del servidor.");
                                }
                            },

                        });
                    }






                } else {
                    console.error('No se encontraron datos para el psicólogo con ID:', presentaciontId);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error en la carga de datos:', error);
            }
        });
    } else {
        console.error('No se encontró el ID del psicólogo en la URL.');
    }
});





