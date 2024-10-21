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

        .btn-google {
            background-color: #ea4335;
            color: white;
        }

        .btn-facebook {
            background-color: #3b5998;
            color: white;
        }

        .btn-apple {
            background-color: black;
            color: white;
        }

        /* Ajustar el tamaño de los botones */
        .btn-lg {
            padding: 10px 15px;
            font-size: 0.9rem;
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
                    <h2 class="text-center">Iniciar Sesión en <br> <strong>Terapia Libre</strong></h2>

                    <!-- Botones para iniciar sesión con redes sociales -->
                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-google btn-lg">
                            <i class="fab fa-google me-2"></i> Continuar con Google
                        </button>
                        <button class="btn btn-facebook btn-lg">
                            <i class="fab fa-facebook-f me-2"></i> Continuar con Facebook
                        </button>
                        <button class="btn btn-apple btn-lg">
                            <i class="fab fa-apple me-2"></i> Continuar con Apple
                        </button>
                    </div>

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
    </script>
</body>

</html>