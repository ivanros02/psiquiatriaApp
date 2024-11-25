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
if ($id_presentacion !== null) {  // Si es profesional
    $stmt = $conexion->prepare("SELECT d.fecha AS fecha_reserva, u.nombre, u.email, u.telefono, u.id AS id_usuario, d.hora AS hora_turno
                                FROM reservas_turnos r
                                LEFT JOIN disponibilidad_turnos d ON d.id = r.turno_id
                                LEFT JOIN usuarios u ON u.id = r.usuario_id
                                WHERE d.profesional_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultReservas = $stmt->get_result();

    if ($resultReservas) {
        while ($rowReserva = $resultReservas->fetch_assoc()) {
            $reservas[] = [
                'fecha_reserva' => $rowReserva['fecha_reserva'],
                'hora_turno' => $rowReserva['hora_turno'],
                'nombre' => $rowReserva['nombre'],
                'email' => $rowReserva['email'],
                'telefono' => $rowReserva['telefono'],
                'id' => $rowReserva['id_usuario']
            ];
        }
    }
    $stmt->close();
}

// Obtener las reservas del usuario si es un usuario regular
$reservasUsuario = [];
if ($id_presentacion === null) {  // Si es usuario regular
    $stmt = $conexion->prepare("SELECT dispo.fecha AS fecha_reserva, u.nombre, u.email, u.telefono, u.id AS id_usuario, dispo.hora AS hora_turno, dispo.profesional_id AS profesionalId, p.valor_internacional, p.valor, p.id AS presentacionId, r.turno_id
                                FROM reservas_turnos r
                                LEFT JOIN disponibilidad_turnos dispo ON dispo.id = r.turno_id
                                LEFT JOIN usuarios u ON u.id = dispo.profesional_id
                                LEFT JOIN presentaciones p ON p.id_usuario = dispo.profesional_id
                                WHERE r.usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultReservasUsuario = $stmt->get_result();

    if ($resultReservasUsuario) {
        while ($rowReserva = $resultReservasUsuario->fetch_assoc()) {
            $reservasUsuario[] = [
                'fecha_reserva' => $rowReserva['fecha_reserva'],
                'hora_turno' => $rowReserva['hora_turno'],
                'nombre' => $rowReserva['nombre'],
                'email' => $rowReserva['email'],
                'telefono' => $rowReserva['telefono'],
                'profesionalId' => $rowReserva['profesionalId'],
                'valor_internacional' => $rowReserva['valor_internacional'],
                'valor' => $rowReserva['valor'],
                'presentacionId' => $rowReserva['presentacionId'],
                'turno_id' => $rowReserva['turno_id'],
                'id' => $rowReserva['id_usuario']
            ];
        }
    }
    $stmt->close();
}

// Determinar la fuente de reservas según el tipo de usuario
$eventos = [];
if ($id_presentacion !== null) {
    // Si es un profesional, usar $reservas
    $eventos = array_map(function ($reserva) {
        $fechaHora = $reserva['fecha_reserva'] . 'T' . $reserva['hora_turno'];
        return [
            'title' => 'Reservado',
            'start' => $fechaHora,
            'allDay' => false,
            'description' => 'Nombre: ' . $reserva['nombre'] . '<br>Email: ' . $reserva['email'] . '<br>Teléfono: ' . $reserva['telefono'] . '<br>Hora: ' . $reserva['hora_turno'],
            'usuarioId' => $reserva['id']
        ];
    }, $reservas);
} else {
    // Si es un usuario regular, usar $reservasUsuario
    $eventos = array_map(function ($reserva) {
        $fechaHora = $reserva['fecha_reserva'] . 'T' . $reserva['hora_turno'];
        return [
            'title' => 'Reservado',
            'start' => $fechaHora,
            'allDay' => false,
            'description' => 'Nombre Prof.: ' . $reserva['nombre'] . '<br>Email Prof.: ' . $reserva['email'] . '<br>Teléfono Prof.: ' . $reserva['telefono'] . '<br>Hora: ' . $reserva['hora_turno'] . '<br>Valor Internacional: ' . $reserva['valor_internacional'] . '<br>Valor Nacional: ' . $reserva['valor'],
            'profesionalId' => $reserva['profesionalId'],
            'presentacionId' => $reserva['presentacionId'],
            'turno_id' => $reserva['turno_id'],
            'usuarioId' => $reserva['id']
        ];
    }, $reservasUsuario);
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
                            Mis Turnos
                        <?php endif; ?>
                    </h2>

                    <div id="calendar" class="table-responsive table-container shadow-sm p-4 bg-white rounded"></div>

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
                    <button type="button" class="btn btn-danger ms-2" id="cancelarTurnoButton"
                        style="display:none;">Cancelar Turno</button>
                    <button type="button" class="btn btn-primary" id="startChatButton">Crear enlace de
                        videollamada</button>

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
        let nombreProf = null;
        let valorN = null;
        let valorInter = null;
        let idPresentacion = null;




        let presentaciontId = null;

        let api; // Variable para almacenar la instancia de JitsiMeetExternalAPI

        function iniciarVideoLlamada(enlace) {
            const domain = 'meet.jit.si';
            const roomName = enlace.split('/').pop();

            // Verificar si api ya está definido y eliminar la instancia anterior si existe
            if (typeof api !== 'undefined' && api !== null) {
                api.dispose();  // Limpiar instancia anterior
            }

            // Verificar si el contenedor de video está disponible
            const videoContainer = document.querySelector('#video-conference');
            if (!videoContainer) {
                console.error('El contenedor #video-conference no se encuentra en el DOM.');
                return;  // No continuar si no existe el contenedor
            }

            // Configuración de la videollamada
            const options = {
                roomName: roomName,
                width: '100%',
                height: '100%',
                parentNode: videoContainer,
                interfaceConfigOverwrite: {
                    DISABLE_JOIN_LEAVE_NOTIFICATIONS: true,
                    SHOW_JITSI_WATERMARK: false,
                    SHOW_POWERED_BY: false,
                    TOOLBAR_BUTTONS: ['microphone', 'camera', 'hangup', 'chat', 'raisehand', 'videobackgroundblur'],
                },
                configOverwrite: {
                    startWithVideoMuted: false,
                    startWithAudioMuted: false,
                    prejoinPageEnabled: false,
                    enableUserRolesBasedOnToken: false,
                    enableWelcomePage: false,
                }
            };

            // Inicializar la API de Jitsi
            api = new JitsiMeetExternalAPI(domain, options);

            // Evento cuando la videollamada termina
            api.addEventListener('videoConferenceLeft', function () {
                console.log('La videollamada ha terminado.');

                // Llamada AJAX para eliminar el registro de la videollamada
                $.ajax({
                    url: './sets/eliminar_videollamada.php', // Archivo PHP para eliminar
                    type: 'POST',
                    data: {
                        profesional_id: profesionalId,  // Asegúrate de que estas variables estén definidas en el contexto global
                        paciente_id: usuarioId
                    },
                    success: function (response) {
                        const resultado = JSON.parse(response);
                        if (resultado.status === 'success') {
                            console.log('Registro de videollamada eliminado exitosamente.');
                        } else {
                            console.error('Error al eliminar la videollamada:', resultado.message);
                        }
                    },
                    error: function () {
                        console.error('Error en la solicitud para eliminar la videollamada.');
                    }
                });
            });

            // Manejo de errores en la videollamada
            api.addEventListener('videoConferenceFailed', function (error) {
                console.log('Error en la videollamada:', error);
                alert('Error al unirse a la videollamada: ' + error.message);
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
                editable: <?php echo $id_presentacion !== null ? 'true' : 'false'; ?>, // Editable solo si es profesional
                events: <?php echo json_encode($eventos, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>,
                eventClick: function (event) {
                    if (event) {
                        // Actualiza la información en el modal de detalles
                        $('#modalTitle').text(event.title);
                        $('#modalDate').text(event.start.format('DD/MM/YYYY'));
                        $('#modalDescription').html(event.description);
                        $('#eventModal').modal('show'); // Muestra el modal de detalles del turno

                        <?php if ($id_presentacion !== null): ?>
                            // Lógica de profesionales: permite crear videollamadas
                            const usuarioId = event.usuarioId;
                            const profesionalId = <?= $usuario_id; ?>;
                            $('#startChatButton-paciente').hide();
                            // Verificar existencia de la videollamada
                            $.ajax({
                                url: './gets/obtener_videollamada.php',
                                type: 'POST',
                                data: { profesional_id: profesionalId, paciente_id: usuarioId },
                                success: function (response) {
                                    const resultado = response;

                                    if (resultado.status === 'success') {
                                        $('#startChatButton').text('Iniciar videollamada');
                                        $('#startChatButton').off('click').on('click', function () {
                                            $('#videoCallModal').modal('show');
                                            iniciarVideoLlamada(resultado.enlace);
                                        });
                                    } else {
                                        $('#startChatButton').text('Crear enlace de videollamada');
                                        $('#startChatButton').off('click').on('click', function () {
                                            const enlaceVideoLlamada = generarEnlaceVideoLlamada();

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
                                                        $('#videoCallModal').modal('show');
                                                        iniciarVideoLlamada(enlaceVideoLlamada);
                                                    } else {
                                                        alert('Error: ' + resultado.message); // Muestra el mensaje si ya existe
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
                        <?php else: ?>
                            // Lógica de pacientes: verificar si existe una videollamada y si el pago está completado
                            const usuarioId = <?= $usuario_id; ?>;
                            const profesionalId = event.profesionalId;

                            // Supongamos que 'event' es el evento seleccionado
                            const descripcion = event.description;

                            idPresentacion = event.presentaciontId;
                            valorN = descripcion.match(/Valor Nacional: (\d+)/)?.[1];
                            valorInter = descripcion.match(/Valor Internacional: (\d+)/)?.[1];
                            nombreProf = descripcion.match(/Nombre Prof: (\d+)/)?.[1];

                            // Verificar existencia de la videollamada y estado del pago
                            $.ajax({
                                url: './gets/obtener_videollamada_user.php',
                                type: 'POST',
                                data: { usuario_id: usuarioId, profesional_id: profesionalId },
                                success: function (response) {
                                    const resultado = response;

                                    if (resultado.status === 'success' && resultado.enlace) {
                                        $('#startChatButton').show();
                                        $('#startChatButton').text('Unirse a videollamada');
                                        $('#startChatButton').off('click').on('click', function () {
                                            $('#videoCallModal').modal('show');
                                            iniciarVideoLlamada(resultado.enlace);
                                        });
                                    } 
                                },
                                error: function () {
                                    alert('Error al verificar la existencia de la videollamada.');
                                    $('#startChatButton').hide();
                                }
                            });


                        <?php endif; ?>


                    }
                }
            });

            // Función para generar el enlace de videollamada
            function generarEnlaceVideoLlamada() {
                const idReunion = 'reunion-' + Date.now();
                return `https://meet.jit.si/${idReunion}`;
            }
        });
    </script>
</body>

</html>