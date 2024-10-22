<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Registro de Usuario</title>
    <style>
        :root {
            --blue: #dadea9;
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
            /* Ajusta el tamaño del logo en pantallas pequeñas */
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
        .btn-lg {
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        /* Texto responsive */
        h2 {
            font-size: 1.5rem;
            /* Ajusta el tamaño de los encabezados */
        }

        /* Mejora para dispositivos móviles */
        @media (max-width: 576px) {
            body {
                padding-top: 20px;
                /* Ajusta el padding-top para móviles */
            }

            .card {
                margin-top: 10px;
                /* Añadir margen superior para evitar que esté muy pegado */
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4">
                    <!-- Logo centrado arriba de la tarjeta -->
                    <img src="../img/Logo_transparente.png" alt="Logo" class="logo">
                    <h2 class="text-center">Regístrate en <strong>Terapia Libre</strong></h2>

                    <hr>

                    <form action="./control/registro.php" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Crear Cuenta</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="./index.php">¿Ya tienes una cuenta? Inicia sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>