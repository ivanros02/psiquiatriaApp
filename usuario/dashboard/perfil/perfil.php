<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit();
}

include '../../../php/conexion.php';

$usuario_id = $_SESSION['user_id'];
$usuarioLogueado = false;
$nombreUsuario = '';
$id_presentacion = null;

if (isset($_SESSION['user_id'])) {
    $usuarioLogueado = true;
    $nombreUsuario = $_SESSION['user_nombre'];

    // Consulta para obtener el id_presentacion del usuario
    $query = "SELECT id_presentacion FROM usuarios WHERE id = $usuario_id";
    $result = $conexion->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_presentacion = $row['id_presentacion'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Flatpickr locale español -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <!-- Cargar el archivo de localización español -->

    <style>
        :root {
            --blue: #b6e6f6;
        }

        body {
            background-color: var(--blue) !important;
        }

        .btn-primary {
            color: #000;
            background-color: var(--blue);
            border-color: var(--blue);
        }

        .btn-primary:hover {
            color: #000;
            background-color: var(--blue);
            border-color: var(--blue);
        }

        /* Posicionar el botón Volver en la esquina superior izquierda */
        #volverBtn {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1000;
            /* Asegura que el botón esté por encima de otros elementos */
            padding: 10px 20px;
            border-radius: 50px;
            background-color: var(--blue);
        }

        /* Responsivo: Ajustar el tamaño del botón en pantallas más pequeñas */
        @media (max-width: 768px) {
            #volverBtn {
                padding: 8px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4"><i class="bi bi-person-circle"></i> Perfil de Usuario
                        </h2>
                        <!-- Formulario de perfil -->
                        <form id="perfil-form" action="" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    placeholder="Escribe tu nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Escribe tu email" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono"
                                    placeholder="Escribe tu teléfono" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3"><i class="bi bi-save"></i>
                                Actualizar</button>
                        </form>

                        <?php if ($id_presentacion !== null): ?>
                            <a href="https://www.mercadopago.com.ar/subscriptions/checkout?preapproval_plan_id=2c9380848f81302d018f81f9c2da004b"
                                target="_blank" id="mercadoPagoBtn" class="btn btn-success w-100 mb-3">
                                <i class="bi bi-credit-card"></i> Suscribirse
                            </a>
                        <?php endif; ?>

                        <!-- Modal para cambiar la contraseña -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cambiarContrasenaModalLabel">Cambiar Contraseña</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="cambiarContrasenaForm">
                                        <div class="mb-3">
                                            <label for="contrasenaActual" class="form-label">Contraseña Actual</label>
                                            <input type="password" class="form-control" id="contrasenaActual"
                                                name="contrasenaActual" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nuevaContrasena" class="form-label">Nueva Contraseña</label>
                                            <input type="password" class="form-control" id="nuevaContrasena"
                                                name="nuevaContrasena" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmarContrasena" class="form-label">Confirmar Nueva
                                                Contraseña</label>
                                            <input type="password" class="form-control" id="confirmarContrasena"
                                                name="confirmarContrasena" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Cambiar Contraseña</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Botón Volver -->
        <a href="../dashboard.php" class="btn btn-outline-secondary" id="volverBtn">
            <i class="bi bi-arrow-left"></i> Volver
        </a>

        <!-- Modal para editar un turno -->
        <div class="modal fade" id="editarTurnoModal" tabindex="-1" aria-labelledby="editarTurnoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarTurnoModalLabel">Editar Turno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editarTurnoForm">
                            <input type="hidden" id="turnoId" name="id">
                            <div class="mb-3">
                                <label for="editarFecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="editarFecha" name="fecha" required>
                            </div>
                            <div class="mb-3">
                                <label for="editarHora" class="form-label">Hora</label>
                                <input type="time" class="form-control" id="editarHora" name="hora" required>
                            </div>
                            <div class="mb-3">
                                <label for="editarDisponible" class="form-label">Disponible</label>
                                <select class="form-select" id="editarDisponible" name="disponible">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>



        <!-- Sección de disponibilidad de turnos -->
        <?php if ($id_presentacion !== null): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center"><i class="bi bi-calendar-check"></i> Disponibilidad de Turnos</h3>
                    <table class="table table-striped table-responsive-sm mt-3">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Disponible</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query_turnos = "SELECT * FROM disponibilidad_turnos WHERE profesional_id = $usuario_id";
                            $result_turnos = $conexion->query($query_turnos);

                            if ($result_turnos && $result_turnos->num_rows > 0) {
                                while ($turno = $result_turnos->fetch_assoc()) {
                                    // Formatear la fecha
                                    $fecha_formateada = DateTime::createFromFormat('Y-m-d', $turno['fecha'])->format('d/m/Y');

                                    echo "<tr>
                                    <td>" . $fecha_formateada . "</td>
                                    <td>" . $turno['hora'] . "</td>
                                    <td>" . ($turno['disponible'] ? 'Sí' : 'No') . "</td>
                                    <td>
                                        <button class='btn btn-sm btn-warning me-2' data-id='" . $turno['id'] . "'>Editar</button>
                                        <button class='btn btn-sm btn-danger' data-id='" . $turno['id'] . "'>Eliminar</button>
                                    </td>
                                </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>No hay turnos disponibles.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#nuevoTurnoModal"><i
                            class="bi bi-plus-circle"></i> Nuevo Turno</button>
                </div>
            </div>

            <!-- Modal para agregar un nuevo turno -->
            <div class="modal fade" id="nuevoTurnoModal" tabindex="-1" aria-labelledby="nuevoTurnoModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="nuevoTurnoModalLabel">Agregar Nuevos Turnos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="nuevoTurnoForm">
                                <div class="mb-3">
                                    <label for="fechas" class="form-label">Fechas</label>
                                    <input type="text" class="form-control" id="fechas" name="fechas"
                                        placeholder="Selecciona múltiples fechas (separadas por coma)" required>

                                </div>
                                <div class="mb-3">
                                    <label for="hora" class="form-label">Hora</label>
                                    <input type="time" class="form-control" id="hora" name="hora" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i>
                                    Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>

    <script>
        document.getElementById('cambiarContrasenaForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const contrasenaActual = document.getElementById('contrasenaActual').value;
            const nuevaContrasena = document.getElementById('nuevaContrasena').value;
            const confirmarContrasena = document.getElementById('confirmarContrasena').value;

            // Validación de contraseñas
            if (nuevaContrasena !== confirmarContrasena) {
                alert('Las contraseñas no coinciden');
                return;
            }

            // Verifica si las contraseñas no están vacías
            if (!contrasenaActual || !nuevaContrasena || !confirmarContrasena) {
                alert('Por favor, rellena todos los campos');
                return;
            }

            // Log de depuración
            console.log('Contraseña actual:', contrasenaActual);
            console.log('Nueva contraseña:', nuevaContrasena);

            // Enviar la solicitud AJAX para cambiar la contraseña
            fetch('./abm/cambiar_contrasena.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    contrasenaActual: contrasenaActual,
                    nuevaContrasena: nuevaContrasena
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    // Verifica si la respuesta del servidor es correcta
                    console.log(data);  // Log de la respuesta
                    if (data.success) {
                        alert('Contraseña cambiada con éxito');
                    } else {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error al cambiar la contraseña:', error);
                    alert('Hubo un problema al cambiar la contraseña.');
                });
        });


        document.addEventListener("DOMContentLoaded", function () {
            // Realizar la solicitud AJAX para obtener los datos del perfil
            fetch('./gets/get_user_data.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    // Log para depurar la respuesta antes de convertirla a JSON
                    console.log(response);
                    return response.json();
                })
                .then(data => {
                    // Si no hay error, completar el formulario con los datos
                    if (!data.error) {
                        document.getElementById('nombre').value = data.nombre;
                        document.getElementById('email').value = data.email;
                        document.getElementById('telefono').value = data.telefono;
                    } else {
                        alert(data.error); // Mostrar el error en caso de que no se pueda cargar el perfil
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los datos:', error);
                    alert('Hubo un problema al cargar los datos del perfil.');
                });
        });

        document.getElementById('perfil-form').addEventListener('submit', function (event) {
            event.preventDefault(); // Evita que el formulario se envíe de la forma tradicional

            // Crear el objeto con los datos del formulario
            const formData = new FormData(this);

            // Enviar la solicitud AJAX para actualizar los datos
            fetch('./abm/update_perfil.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())  // Espera respuesta en texto
                .then(data => {
                    alert("Perfil actualizado");  // Muestra el mensaje que devuelve el servidor
                })
                .catch(error => {
                    console.error('Error al actualizar los datos:', error);
                    alert('Hubo un problema al actualizar los datos del perfil.');
                });
        });



        // Manejar el envío del formulario de edición
        document.getElementById('editarTurnoForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Evita el envío del formulario normal

            const formData = new FormData(this);

            fetch('./abm/editar_turno.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Si la edición fue exitosa, recargar la página para ver los cambios
                        location.reload();
                    } else {
                        alert('Hubo un error al actualizar el turno.');
                    }
                });
        });

        // Captura el clic en el botón Editar
        document.querySelectorAll('.btn-warning').forEach(button => {
            button.addEventListener('click', function () {
                const turnoId = this.getAttribute('data-id');

                // Llenar los campos del modal de edición con datos del turno
                fetch(`./gets/obtener_turno.php?id=${turnoId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('turnoId').value = data.id;
                        document.getElementById('editarFecha').value = data.fecha;
                        document.getElementById('editarHora').value = data.hora;
                        document.getElementById('editarDisponible').value = data.disponible;
                        new bootstrap.Modal(document.getElementById('editarTurnoModal')).show();
                    });
            });
        });

        // Captura el clic en el botón Eliminar
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', function () {
                const turnoId = this.getAttribute('data-id');
                if (confirm('¿Estás seguro de que deseas eliminar este turno?')) {
                    fetch(`./abm/eliminar_turno.php?id=${turnoId}`, { method: 'POST' })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            } else {
                                alert('Error al eliminar el turno');
                            }
                        });
                }
            });
        });

        $(document).ready(function () {
            flatpickr("#fechas", {
                mode: "multiple", // Permite seleccionar múltiples fechas
                dateFormat: "Y-m-d", // Formato de la fecha
                locale: "es", // Ahora sí debería funcionar el locale en español
                allowInput: true, // Permite que el usuario también escriba fechas manualmente
            });
        });


        // JavaScript para manejar el envío de formularios y la interacción
        $(document).ready(function () {
            $('#nuevoTurnoForm').on('submit', function (event) {
                event.preventDefault(); // Evitar el envío del formulario por el método tradicional

                // Obtener los datos del formulario
                const profesional_id = <?php echo $usuario_id; ?>; // Asignar el ID de la sesión al profesional_id
                const fechas = $('#fechas').val().split(',').map(fecha => fecha.trim()); // Convertir las fechas en un array
                const hora = $('#hora').val();

                // Verificar que los campos no estén vacíos antes de enviar la solicitud
                if (fechas.length > 0 && hora) {
                    $.ajax({
                        url: './abm/agregar_disponibilidad.php', // Ruta al archivo PHP que manejará la inserción
                        type: 'POST',
                        data: {
                            profesional_id: profesional_id,
                            fechas: fechas,
                            hora: hora
                        },
                        success: function (response) {
                            const result = JSON.parse(response);
                            if (result.success) {
                                alert(result.message);
                                // Opcional: recargar la tabla de turnos o la página para mostrar los nuevos turnos
                                location.reload(); // Recargar la página para actualizar la lista de turnos
                            } else {
                                alert(result.message);
                            }
                        },
                        error: function () {
                            alert('Error al agregar la disponibilidad. Inténtalo de nuevo.');
                        }
                    });
                } else {
                    alert('Por favor, completa todos los campos.');
                }
            });
        });



    </script>
</body>

</html>