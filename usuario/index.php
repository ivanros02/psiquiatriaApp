<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Inicio de Sesión</title>
    <style>
        :root {
            --blue: #b6e6f6;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--blue);
            padding: 20px;
            padding-top: 50px;
            /* Espacio extra en la parte superior */
            box-sizing: border-box;

        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin: 0 auto 15px auto;
            display: block;
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

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card p-4">
                    <!-- Logo centrado arriba de la tarjeta -->
                    <img src="../img/Logo_transparente.png" alt="Logo" class="logo">
                    <!-- Alerta de éxito (oculta por defecto) -->
                    <div id="alerta-exito" class="alert alert-success d-none" role="alert">
                        Usuario creado correctamente. Ahora puedes iniciar sesión.
                    </div>
                    <!-- Alerta de error (oculta por defecto) -->
                    <div id="alerta-error" class="alert alert-danger d-none" role="alert">
                        Correo o contraseña incorrectos.
                    </div>

                    <h2 class="text-center">Iniciar Sesión en <br> <strong>Terapia Libre</strong></h2>

                    <hr>

                    <form action="./control/login.php" method="POST">
                        <input type="hidden" name="redirect_to"
                            value="<?php echo isset($_GET['redirect_to']) ? htmlspecialchars($_GET['redirect_to']) : ''; ?>">

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="registrar.php">Crear una cuenta</a>
                    </div>
                    <div class="text-center mt-3">
                        <a href="./recuperar/recuperar.php">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mostrar alerta si el registro fue exitoso
        const urlParams = new URLSearchParams(window.location.search);
        const registroExitoso = urlParams.get('registro');
        const alertaExito = document.getElementById('alerta-exito');

        if (registroExitoso === 'exitoso' && alertaExito) {
            alertaExito.classList.remove('d-none');
        }

        // Mostrar alerta de error si las credenciales son incorrectas
        const error = urlParams.get('error');
        const alertaError = document.getElementById('alerta-error');

        if (error === 'invalid_credentials' && alertaError) {
            alertaError.classList.remove('d-none');
        }
    </script>
</body>

</html>