<?php
session_start();
if (!isset($_SESSION['user_id'])) { // Cambia esto
    header('Location: ../../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>Perfil de Usuario</h2>
        <form id="perfil-form" action="./abm/update_perfil.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            // Cargar datos del perfil
            $.ajax({
                url: './gets/get_usuario.php',
                type: 'GET',
                success: function (response) {
                    const usuario = JSON.parse(response);
                    $('#nombre').val(usuario.nombre);
                    $('#email').val(usuario.email);
                    $('#telefono').val(usuario.telefono);
                },
                error: function () {
                    alert('Error al cargar los datos del perfil.');
                }
            });
        });

        // Manejo del formulario
        $('#perfil-form').on('submit', function (event) {
            event.preventDefault(); // Previene el envío normal del formulario
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(), // Envía los datos del formulario
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        alert(result.message);
                        window.location.href = 'perfil.php'; // Redirigir después de la actualización
                    } else {
                        alert(result.message); // Mostrar error
                    }
                },
                error: function () {
                    alert('Error al actualizar los datos.');
                }
            });
        });
    </script>
</body>

</html>