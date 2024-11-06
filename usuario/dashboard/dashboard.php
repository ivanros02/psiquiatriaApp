<?php
session_start();
if (!isset($_SESSION['user_id'])) { // Cambia esto
    header('Location: ../index.php');
    exit();
}

include '../../php/conexion.php';

$usuario_id = $_SESSION['user_id']; // Cambia esto también

// Verificar si el usuario está logueado
$usuarioLogueado = false;
$nombreUsuario = '';  // Variable para almacenar el nombre del usuario
$id_presentacion = null; // Variable para almacenar el id_presentacion

if (isset($_SESSION['user_id'])) {
    $usuarioLogueado = true;
    $nombreUsuario = $_SESSION['user_nombre'];  // Recuperar el nombre del usuario de la sesión

    // Consulta para obtener el id_presentacion del usuario
    $query = "SELECT id_presentacion FROM usuarios WHERE id = $usuario_id";
    $result = $conexion->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_presentacion = $row['id_presentacion'];
    }
}

// Obtener las reservas del profesional si es un profesional
$reservas = [];
if ($id_presentacion !== null) {
    $queryReservas = "SELECT r.fecha_reserva, u.nombre, u.email, u.telefono, u.id AS id_usuario, d.hora AS hora_turno
                      FROM reservas_turnos r
                      LEFT JOIN disponibilidad_turnos d ON d.id = r.turno_id
                      LEFT JOIN usuarios u ON u.id = r.usuario_id
                      WHERE d.profesional_id = $usuario_id";
    $resultReservas = $conexion->query($queryReservas);

    if ($resultReservas) {
        while ($rowReserva = $resultReservas->fetch_assoc()) {
            $reservas[] = [
                'fecha_reserva' => $rowReserva['fecha_reserva'],
                'hora_turno' => $rowReserva['hora_turno'], // Incluir la hora
                'nombre' => $rowReserva['nombre'],
                'email' => $rowReserva['email'],
                'telefono' => $rowReserva['telefono'],
                'id' => $rowReserva['id_usuario']
            ];
        }
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!--icono pestana-->
    <link rel="icon" href="../../img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="../../img/Logo_transparente.png" type="image/x-icon">

    <!-- CSS de FullCalendar -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- custom css file link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="../../estilos/headerYFooter.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/es.js"></script>
    <script src='https://meet.jit.si/external_api.js'></script>

    <!-- custom js file link  -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <!-- MercadoPago -->
    <script src="https://www.mercadopago.com/v2/security.js" view="checkout"></script>

    <!-- PayPal SDK -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=ASuvwaL7zuIKfyr5_OppnnQGrKqyvWDPkSn2BSHYTSR8wHbxOQPZE1JzVQ2Oj8ECpJSJ2XF-0ADkTk4l&currency=USD"></script>


    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:wght@400;700&display=swap');

        html {
            font-size: 62.5%;
            /* 1rem = 10px */
        }

        .custom {
            font-size: 4rem;
            color: var(--green);
            padding: 1rem;
            padding-top: 11rem;
            font-family: 'Things' !important;
        }

        .custom-margin-top {
            margin-top: 1rem;
            margin-bottom: 15rem;
        }

        .btn-chat {
            color: var(--green) !important;
        }

        .btn-video {
            color: var(--green) !important;
        }

        .card {
            border-radius: 30px;
            /* Ajusta el valor a tu preferencia */
        }

        .modal-content {
            font-size: 1.5rem;
            /* Ajusta el tamaño de la fuente a tu preferencia */
        }

        #modalDescription p {
            margin-bottom: 0.5rem;
            /* Espacio entre líneas */
        }
    </style>
</head>

<body>
    <header class="d-flex justify-content-between align-items-center bg-white shadow fixed-top p-2">
        <a href="../../index.php"
            class="logo d-flex align-items-center text-decoration-none text-success mx-auto mx-lg-0">
            <img src="../../img/Logo_transparente.png" alt="Logo de Terapia Libre" class="mr-2" style="width: 7rem;">
            <span>Terapia Libre</span>
        </a>

        <nav class="navbar navbar-expand-lg navbar-light d-none d-lg-flex">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">Hola,
                        <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./perfil/perfil.php">Perfil</a>
                </li>
            </ul>
        </nav>

        <!-- Menú tipo TikTok solo visible en móviles -->
        <nav class="mobile-navbar d-lg-none fixed-bottom bg-white p-2 shadow">
            <ul class="d-flex justify-content-between w-100 text-center">
                <li>
                    <a href="../../index.php">
                        <i class="fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <li>
                    <a href="./perfil/perfil.php">
                        <i class="fas fa-user"></i>
                        <p>Hola, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></p>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container-fluid custom-margin-top">
        <div class="row justify-content-center">
            <!-- Main content -->
            <main class="col-12 col-md-10 col-lg-8 d-flex justify-content-center">
                <div class="container-fluid mt-5">
                    <h2 class="display-4 mb-4 text-center custom">
                        <?php if ($id_presentacion !== null): ?>
                            PACIENTES
                        <?php else: ?>
                            Mis terapeutas
                        <?php endif; ?>
                    </h2>

                    <?php if ($id_presentacion !== null): ?>
                        <!-- Cargar calendario -->
                        <div id='calendar' class="table-responsive table-container shadow-sm p-4 bg-white rounded"></div>
                    <?php else: ?>
                        <!-- Ajustes a la tabla para pantallas grandes -->
                        <div id="profesionales-list"
                            class="table-responsive table-container shadow-sm p-4 bg-white rounded">
                            <!-- Los datos se cargarán aquí mediante AJAX -->
                        </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal de TURNO -->
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Detalles del Turno</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Título:</strong> <span id="modalTitle"></span></p>
                    <p><strong>Fecha:</strong> <span id="modalDate"></span></p>
                    <p><strong>Descripción:</strong></p>
                    <p id="modalDescription"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="startChatButton">Crear enlace de video
                        llamada</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para la videollamada -->
    <!-- Modal para la videollamada -->
    <div class="modal fade" id="videoCallModal" tabindex="-1" aria-labelledby="videoCallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 90%; /* Limita el ancho máximo */">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoCallModalLabel">Videollamada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body" style="height: 70vh; /* Ajusta la altura del modal */">
                    <div id="video-conference" style="width: 100%; height: 100%; min-height: 400px;"></div>
                    <!-- Ajuste del tamaño -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card-modern-shadow" style="background-color: #f4f4f4; border-radius: 15px;">
                <div class="modal-header" style="border-bottom: none; padding-bottom: 0; overflow-y: hidden;">
                    <h5 class="modal-title category-modern" id="contactModalLabel">Aviso Importante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background: transparent; border: none;"></button>
                </div>
                <div class="modal-body content-modern">
                    <h6 class="category-modern">Plataforma Segura</h6>
                    <p class="description-modern">
                        Estimado usuario, por favor, ten en cuenta que estás a punto de ser redirigido a nuestra
                        plataforma de pago segura para completar tu transacción. Garantizamos la confidencialidad y
                        seguridad de tus datos durante este proceso. Asegúrate de revisar cuidadosamente los detalles de
                        tu compra antes de proceder con el pago. Si tienes alguna pregunta o necesitas asistencia, no
                        dudes en contactarnos. ¡Gracias por tu confianza! Equipo de Terapia Libre.
                    </p>
                    <div style="text-align: center;">
                        <button class="btn-modern-primary" id="checkout-btn"
                            data-psychologist-id="${psicologo.id}">Contactar Profesional</button>
                    </div>
                    <div id="wallet_container" style="margin-top: 10px;">
                        <p id="mp-loading-message" style="text-align: center; display: none;">Botón de Mercado Pago
                            cargando...</p>
                    </div>

                    <div id="paypal-button-container" style="margin-top: 10px;"></div>
                </div>
            </div>
        </div>
    </div>




    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <a href="index.php" class="logo">
                    <img src="../../img/Logo_transparente.png" alt="Logo de Terapia Libre">
                    Terapia Libre
                </a>
                <p>
                    Es una plataforma innovadora que te ofrece la libertad de elegir al profesional de salud mental
                    ideal para ti. Con una amplia variedad de expertos, facilitamos la búsqueda y selección de tu
                    terapeuta, priorizando tu bienestar emocional con tratamientos personalizados.
                </p>
            </div>

            <div class="box">
                <h3 class="share">Redes</h3>
                <a href="https://www.instagram.com/terapia.libre/?igsh=MTE3cnBnYXB5OHVwZA%3D%3D"><i
                        class="bi bi-instagram"></i>
                    Instagram</a>
            </div>

        </div>

        <h1 class="credit">created by <span>WorldSoftSystem</span> | all rights reserved. </h1>

    </section>

    <!-- footer section ends -->

    <script>
        let presentaciontId = null;

        $(document).on('click', '.btn-video', function () {
            const usuarioId = <?= $usuario_id; ?>; // ID del usuario actual
            const profesionalId = $(this).data('id'); // ID del presentacion desde el atributo data-id
            presentaciontId = profesionalId;
            // Llamar al archivo PHP para verificar el estado de la videollamada o del pago
            $.ajax({
                url: './gets/obtener_videollamada.php',
                type: 'POST',
                data: { usuario_id: usuarioId, profesional_id: profesionalId },
                success: function (response) {
                    const resultado = JSON.parse(response);

                    if (resultado.status === 'success') {
                        $('#videoCallModal').modal('show'); // Abre el modal de videollamada
                        iniciarVideoLlamada(resultado.enlace); // Inicia la videollamada con el enlace proporcionado
                    } else if (resultado.status === 'no_payment') {
                        // Muestra el modal de pago en lugar de la videollamada
                        $('#contactModal').modal('show'); // Mostrar el modal de pago
                        $('#checkout-btn').data('psychologist-id', profesionalId); // Asociar el profesionalId al botón de pago
                    } else if (resultado.status === 'no_call') {
                        alert('Espera a que tu terapeuta cree la videollamada.');
                    }
                },
                error: function () {
                    alert('Error al obtener la información de la videollamada.');
                }
            });
        });



        let api; // Variable para almacenar la instancia de JitsiMeetExternalAPI

        function iniciarVideoLlamada(enlace) {
            const domain = 'meet.jit.si';

            // Extraer solo el nombre de la sala de la URL
            const roomName = enlace.split('/').pop(); // Obtén el nombre de la sala

            // Si ya hay una instancia, destrúyela antes de crear una nueva
            if (api) {
                api.dispose(); // Destruir la instancia anterior
            }

            const options = {
                roomName: roomName,
                width: '100%', // Ajustar el ancho al 100%
                height: '100%', // Ajustar la altura al 100%
                parentNode: document.querySelector('#video-conference'), // Asegúrate que este elemento existe
                interfaceConfigOverwrite: {
                    // Configuraciones de la interfaz, si deseas personalizar
                },
                configOverwrite: {
                    // Configuraciones adicionales, si deseas
                }
            };

            api = new JitsiMeetExternalAPI(domain, options);

            // Agregar evento para saber cuándo se cierra la llamada
            api.addEventListener('videoConferenceLeft', function () {
                alert('Gracias por usar terapia libre.'); // Alerta al finalizar la videollamada
                $('#videoCallModal').modal('hide'); // Cerrar el modal después de la llamada
                api.dispose(); // Destruir la instancia al salir
                api = null; // Reiniciar la variable
            });
        }





        $(document).ready(function () {

            // Inicializar el calendario
            $('#calendar').fullCalendar({
                locale: 'es',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                events: <?php
                // Convertir las reservas a un formato JSON compatible con FullCalendar
                if (!empty($reservas)) {
                    $eventos = array_map(function ($reserva) {
                        return [
                            'title' => 'Reservado',
                            'start' => $reserva['fecha_reserva'],
                            'allDay' => true,
                            'description' => 'Nombre: ' . $reserva['nombre'] . '<br>Email: ' . $reserva['email'] . '<br>Teléfono: ' . $reserva['telefono'] . '<br>Hora: ' . $reserva['hora_turno'],
                            'usuarioId' => $reserva['id']
                        ];
                    }, $reservas);

                    echo json_encode($eventos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                } else {
                    echo '[]';
                }
                ?>,
                // Función para manejar el clic en un evento del calendario
                eventClick: function (event) {
                    if (event) {
                        // Actualiza la información en el modal de detalles
                        $('#modalTitle').text(event.title);
                        $('#modalDate').text(event.start.format('DD/MM/YYYY'));
                        $('#modalDescription').html(event.description);
                        $('#eventModal').modal('show'); // Muestra el modal de detalles del turno

                        const usuarioId = event.usuarioId;
                        const profesionalId = <?= $usuario_id; ?>;

                        // Realizar la verificación de existencia de la videollamada
                        $.ajax({
                            url: './gets/obtener_videollamada.php',
                            type: 'POST',
                            data: { profesional_id: profesionalId, paciente_id: usuarioId },
                            success: function (response) {
                                const resultado = response;

                                // Configuración del botón basado en la existencia de una llamada
                                if (resultado.status === 'success') {
                                    $('#startChatButton').text('Iniciar videollamada');
                                    $('#startChatButton').off('click').on('click', function () {
                                        $('#videoCallModal').modal('show'); // Muestra el modal de videollamada
                                        iniciarVideoLlamada(resultado.enlace); // Inicia la videollamada con el enlace existente
                                    });
                                } else {
                                    $('#startChatButton').text('Crear enlace de videollamada');
                                    $('#startChatButton').off('click').on('click', function () {
                                        const enlaceVideoLlamada = generarEnlaceVideoLlamada();

                                        // Guardar la videollamada en la base de datos
                                        $.ajax({
                                            url: './sets/guardar_videollamada.php',
                                            type: 'POST',
                                            data: {
                                                profesional_id: profesionalId,
                                                paciente_id: usuarioId,
                                                fecha_hora: moment().format('YYYY-MM-DD HH:mm:ss'),
                                                enlace: enlaceVideoLlamada
                                            },
                                            success: function (response) {
                                                const resultado = JSON.parse(response);
                                                if (resultado.status === 'success') {
                                                    alert('Videollamada creada. Enlace: ' + enlaceVideoLlamada);
                                                    $('#videoCallModal').modal('show'); // Muestra el modal de videollamada
                                                    iniciarVideoLlamada(enlaceVideoLlamada); // Inicia la videollamada con el nuevo enlace
                                                } else {
                                                    alert('Error al crear la videollamada: ' + resultado.message);
                                                }
                                            },
                                            error: function () {
                                                alert('Error al crear la videollamada.');
                                            }
                                        });
                                    });
                                }
                            },
                            error: function () {
                                alert('Error al obtener el estado de la videollamada.');
                            }
                        });
                    }
                }


            });

            // Función para generar el enlace de video llamada
            function generarEnlaceVideoLlamada() {
                // Generar un ID único para la reunión
                const idReunion = 'reunion-' + Date.now(); // Esto generará un ID único basado en la marca de tiempo
                return `https://meet.jit.si/${idReunion}`;
            }

            // Cargar los profesionales relacionados con el usuario
            <?php if ($id_presentacion === null): ?>
                $.ajax({
                    url: './gets/get_profesionales.php',
                    type: 'POST',
                    data: { usuario_id: <?= $usuario_id; ?> },
                    success: function (response) {
                        $('#profesionales-list').html(response);
                    },
                    error: function () {
                        $('#profesionales-list').html('<div class="alert alert-danger">Error al cargar la lista de profesionales.</div>');
                    }
                });
            <?php endif; ?>
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
                            }],
                            application_context: {
                                shipping_preference: "NO_SHIPPING"  // Esta línea desactiva el campo de dirección
                            }
                        });
                    },
                    onApprove: (data, actions) => {
                        let url = '../../paypal/captura.php';
                        actions.order.capture().then(detalles => {
                            const user_email = detalles.payer.email_address;
                            const userId = <?= $usuario_id; ?>;
                            console.log(detalles);
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
            if (!mercadoPagoButtonRendered) {
                // Mostrar el mensaje de "cargando" solo si el botón no ha sido renderizado
                document.getElementById('mp-loading-message').style.display = 'block';

                const mp = new MercadoPago("APP_USR-ebcfb544-a26e-44bf-8c55-7605f5ecb7d8", { locale: "es-AR" });
                const generateIdempotencyKey = () => {
                    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                    return Array.from({ length: 20 }, () => characters.charAt(Math.floor(Math.random() * characters.length))).join('');
                };

                const idempotencyKey = generateIdempotencyKey();
                const precio = parseFloat(document.querySelector('.tooltiptext').getAttribute('data-valor'));
                const userId = <?= $usuario_id; ?>; // Obtener el ID del usuario

                const orderData = {
                    title: document.querySelector(".card-title").innerText,
                    quantity: 1,
                    price: precio,
                    psychologistId: presentaciontId,
                    userId,
                    additional_info: { userId }
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

                    mercadoPagoButtonRendered = true; // Marcar que el botón ha sido renderizado
                } catch (error) {
                    console.error("Error:", error);
                    alert("Ocurrió un error: " + error.message);
                    document.getElementById('mp-loading-message').style.display = 'none'; // Ocultar el mensaje de carga
                    $(this).prop('disabled', false); // Volver a habilitar el botón en caso de error
                }
            } else {
                // Si el botón ya ha sido renderizado, simplemente oculta el mensaje de carga
                document.getElementById('mp-loading-message').style.display = 'none';
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
    </script>
</body>

</html>