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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

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
                        <form id="perfil-form" action="./abm/update_perfil.php" method="POST">
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
                        <a href="../dashboard.php" class="btn btn-outline-secondary w-100"><i
                                class="bi bi-arrow-left"></i> Volver</a>
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
                                    echo "<tr>
                                    <td>" . $turno['fecha'] . "</td>
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
                            <h5 class="modal-title" id="nuevoTurnoModalLabel">Agregar Nuevo Turno</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="nuevoTurnoForm">
                                <div class="mb-3">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required>
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
        // JavaScript para manejar el envío de formularios y la interacción
        $(document).ready(function () {
            $('#nuevoTurnoForm').on('submit', function (event) {
                event.preventDefault(); // Evitar el envío del formulario por el método tradicional

                // Obtener los datos del formulario
                const profesional_id = <?php echo $usuario_id; ?>; // Asignar el ID de la sesión al profesional_id
                const fecha = $('#fecha').val();
                const hora = $('#hora').val();

                // Verificar que los campos no estén vacíos antes de enviar la solicitud
                if (fecha && hora) {
                    $.ajax({
                        url: './abm/agregar_disponibilidad.php', // Ruta al archivo PHP que manejará la inserción
                        type: 'POST',
                        data: {
                            profesional_id: profesional_id,
                            fecha: fecha,
                            hora: hora
                        },
                        success: function (response) {
                            const result = JSON.parse(response);
                            if (result.success) {
                                alert(result.message);
                                // Opcional: recargar la tabla de turnos o la página para mostrar el nuevo turno
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