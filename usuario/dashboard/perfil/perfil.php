<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
    </div>

    <script>
        $(document).ready(function () {
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

        $('#perfil-form').on('submit', function (event) {
            event.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        alert(result.message);
                        window.location.href = 'perfil.php';
                    } else {
                        alert(result.message);
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