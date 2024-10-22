const urlParams = new URLSearchParams(window.location.search);
const presentaciontId = urlParams.get('id');
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
                                    <p class='card-valor tooltiptext' data-valor='${psicologo.valor}'>$ ${psicologo.valor}</p>
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




                    // Obtener el valor de si el usuario está logueado o no desde el atributo data
                    var usuarioLogueado = document.body.getAttribute('data-usuario-logueado') === 'true';

                    // Manejar el clic en el botón de contactar
                    document.getElementById('contact').addEventListener('click', function () {
                        if (usuarioLogueado) {
                            // Si el usuario está logueado, mostrar el modal
                            var myModal = new bootstrap.Modal(document.getElementById('contactModal'));
                            myModal.show();
                        } else {
                            // Si no está logueado, redirigir a la página de inicio de sesión
                            // Guarda la URL de redirección
                            const currentUrl = window.location.href;
                            window.location.href = `../usuario/index.php?redirect_to=${encodeURIComponent(currentUrl)}`; // Asegúrate de que la ruta sea correcta
                        }
                    });


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


//PAGOS
// Variables para controlar si los botones ya fueron creados
let paypalButtonRendered = false;
let mercadoPagoButtonRendered = false;

$(document).on('click', '#checkout-btn', async () => {
    // Deshabilitar el botón para evitar múltiples clics
    $(this).prop('disabled', true);
    // Captura el valor del span
    const valorSpan = document.querySelector('.tooltiptext').getAttribute('data-valor');
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
                    }]
                });
            },
            onApprove: (data, actions) => {
                let url = '../paypal/captura.php';
                actions.order.capture().then(detalles => {
                    const user_email = detalles.payer.email_address;
                    const userId = document.getElementById("user-id").value.trim();

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
                            // Ya no necesitas JSON.parse aquí, ya es un objeto
                            if (data.status === 'success') {
                                console.log('Datos guardados correctamente:', data.message);
                                enviarCorreoElectronicoAComprador(presentaciontId, user_email);
                                window.location.href = 'https://terapialibre.com.ar/usuario/dashboard/dashboard.php';
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

        const precio = parseFloat(document.querySelector('.tooltiptext').getAttribute('data-valor'));
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

