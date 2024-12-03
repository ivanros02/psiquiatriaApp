const urlParams = new URLSearchParams(window.location.search);
const presentaciontId = urlParams.get('id');
const valor = urlParams.get('valor');
let turno_id = null;
let variableValor = { local: null, internacional: null };
$(document).ready(function () {
    if (presentaciontId) {
        $.ajax({
            url: `./gets/get_presentacion.php?id=${presentaciontId}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                const { presentaciones, comentarios } = data;

                const psicologo = presentaciones[0];

                variableValor.local = psicologo.valor;
                variableValor.internacional = psicologo.valor_internacional;

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
                                    // Obtener el modal y mostrarlo usando Bootstrap
                                    const modalPago = new bootstrap.Modal(document.getElementById('contactModal'), {
                                        backdrop: 'static',
                                        keyboard: false
                                    });
                                    calendarModal.hide();
                                    modalPago.show();
                                    turno_id = info.event.id;
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

// Función para renderizar el botón de PayPal
function enviarCorreoElectronicoAComprador(psychologistId, userEmail) {
    // Realizar una solicitud AJAX para enviar el correo electrónico
    $.ajax({
        url: 'https://terapialibre.com.ar/paypal/correo.php',
        method: 'POST',
        data: { psychologist_id: psychologistId, user_email: userEmail },
        success: function (response) {
            console.log('Correo electrónico enviado correctamente:', response);
        },
        error: function (xhr, status, error) {
            console.error('Error al enviar el correo electrónico:', error);
        }
    });
}

function realizarReserva(turnoId, usuarioId) {
    if (!turnoId || !usuarioId) {
        console.error('Faltan datos: turnoId o usuarioId');
        return;
    }

    console.log('Intentando realizar la reserva con:', { turnoId, usuarioId });

    fetch('./sets/set_reserva_turno.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ turno_id: turnoId, usuario_id: usuarioId })
    })
        .then(response => {
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log('Reserva realizada con éxito:', data);
            } else {
                console.error('Error al realizar la reserva:', data.error);
            }
        })
        .catch(error => console.error('Error en la solicitud de reserva:', error));
}


//PAGOS
// Variables para controlar si los botones ya fueron creados
let paypalButtonRendered = false;
let mercadoPagoButtonRendered = false;

$(document).on('click', '#checkout-btn', async () => {
    // Deshabilitar el botón para evitar múltiples clics
    $(this).prop('disabled', true);
    // Captura el valor del span
    const valorSpan = variableValor.internacional;
    // PAYPAL
    if (!paypalButtonRendered) {
        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: { value: valorSpan },
                        reference_id: presentaciontId
                    }],
                    application_context: {
                        shipping_preference: 'NO_SHIPPING'  // Desactiva la solicitud de dirección de facturación
                    }
                });
            },
            onApprove: (data, actions) => {
                let url = '../paypal/captura.php';
                actions.order.capture().then(detalles => {
                    const user_email = detalles.payer.email_address;
                    const userId = document.getElementById("user-id").value.trim();
                    console.log(turno_id);
                    console.log(userId)
                    return fetch(url, {
                        method: 'post',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ detalles, userId }) // Enviando los detalles y userId en el cuerpo
                    })
                        .then(response => {
                            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                            return response.json();  // Ahora esperamos JSON directamente
                        })
                        .then(data => {
                            if (data.status === 'success') {
                                console.log('Datos guardados correctamente:', data.message);
                                enviarCorreoElectronicoAComprador(presentaciontId, user_email);
                                console.log(turno_id);
                                console.log(userId)
                                realizarReserva(turno_id, userId); // Asegúrate de tener el turnoId y userId disponibles
                                window.location.href = '../usuario/dashboard/dashboard.php';
                            } else {
                                console.error('Error al guardar los datos:', data.message);
                            }
                        })
                        .catch(error => console.error('Error en la solicitud:', error));
                });
            },

            onCancel: () => {
                alert('Pago cancelado');
            }
        }).render('#paypal-button-container');

        paypalButtonRendered = true;
    }

    // MERCADO PAGO

    // Mostrar el mensaje de "cargando" cuando se hace clic en el botón
    document.getElementById('mp-loading-message').style.display = 'block';
    //moni:APP_USR-ebcfb544-a26e-44bf-8c55-7605f5ecb7d8
    if (!mercadoPagoButtonRendered) {
        const mp = new MercadoPago("APP_USR-ebcfb544-a26e-44bf-8c55-7605f5ecb7d8", { locale: "es-AR" });
        const generateIdempotencyKey = () => {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            return Array.from({ length: 20 }, () => characters.charAt(Math.floor(Math.random() * characters.length))).join('');
        };

        const idempotencyKey = generateIdempotencyKey();
        const userEmail = document.getElementById("user-email").value.trim();

        if (!userEmail) {
            alert("Por favor, ingresa tu correo electrónico.");
            return;
        }

        const precio = parseFloat(variableValor.local);
        const userId = document.getElementById("user-id").value.trim(); // Obtener el ID del usuario

        const formData = {
            userId,  // Cambia userEmail por userId
            psychologistId: presentaciontId
        };

        const orderData = {
            title: document.querySelector(".card-title").innerText,
            quantity: 1,
            price: precio,
            psychologistId: presentaciontId,
            userId,  // Aquí estás enviando el userId
            turno_id,
            additional_info: {
                userId  // Asegúrate de que el userId esté dentro de additional_info
            }
        };


        try {
            const response = await fetch("https://terapialibre.com.ar/create_preference", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Idempotency-Key": idempotencyKey,
                },
                body: JSON.stringify(orderData),
            });

            const preference = await response.json();
            createCheckoutButton(preference.id, mp);

            // Ocultar el mensaje de "cargando" cuando el botón esté listo
            document.getElementById('mp-loading-message').style.display = 'none';

            mercadoPagoButtonRendered = true;
        } catch (error) {
            console.error("Error:", error);
            alert("Ocurrió un error: " + error.message);
        }
    }

});

const createCheckoutButton = (preferenceId, mp) => {
    const bricksBuilder = mp.bricks();
    const renderComponent = async () => {
        if (window.checkoutButton) window.checkoutButton.unmount();

        await bricksBuilder.create("wallet", "wallet_container", { initialization: { preferenceId } });

        // Ocultar el mensaje de "cargando" cuando el botón esté completamente renderizado
        document.getElementById('mp-loading-message').style.display = 'none';
    };
    renderComponent();
};





