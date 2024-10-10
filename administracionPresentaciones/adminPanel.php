<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirigir al login si no está logueado
    header("Location: ./manejoUsuario/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <a href="./manejoUsuario/logout.php" class="btn btn-danger mb-3">Cerrar sesión</a>
        <h1>Bienvenido, <?php echo $_SESSION['username']; ?></h1>
        

        <h2>Listado de Presentaciones</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Especialidades</th>
                    <th>Aprobado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody id="presentaciones-list">
                <!-- Las filas de presentaciones se generarán aquí con JS -->
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        // Función para cargar las presentaciones desde el servidor
        function cargarPresentaciones() {
            $.ajax({
                url: './manejoPresentaciones/obtenerPresentaciones.php', // Ruta del archivo PHP que obtiene las presentaciones
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    let rows = '';
                    data.forEach(function (presentacion) {
                        rows += `
                            <tr>
                                <td>${presentacion.id}</td>
                                <td>${presentacion.nombre}</td>
                                <td>${presentacion.especialidades}</td>
                                <td>${presentacion.aprobado == 1 ? 'Sí' : 'No'}</td>
                                <td>
                                    <button class="btn btn-sm btn-success" onclick="cambiarEstado(${presentacion.id}, 1)">Aprobar</button>
                                    <button class="btn btn-sm btn-danger" onclick="cambiarEstado(${presentacion.id}, 0)">Rechazar</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#presentaciones-list').html(rows);
                }
            });
        }

        // Función para cambiar el estado de aprobación de una presentación
        function cambiarEstado(id, aprobado) {
            $.ajax({
                url: './manejoPresentaciones/cambiarEstado.php', // Ruta del archivo PHP que actualiza el estado
                method: 'POST',
                data: { id: id, aprobado: aprobado },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        alert('Estado actualizado con éxito');
                        cargarPresentaciones(); // Recargar la lista de presentaciones
                    } else {
                        alert('Error al actualizar el estado');
                    }
                }
            });
        }

        // Cargar las presentaciones cuando la página esté lista
        $(document).ready(function () {
            cargarPresentaciones();
        });
    </script>
</body>

</html>
