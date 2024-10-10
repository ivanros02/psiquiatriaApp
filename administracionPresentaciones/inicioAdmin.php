<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }

        .login-container {
            margin-top: 100px;
        }

        .login-form {
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .login-form h3 {
            margin-bottom: 30px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="./manejoUsuario/login.php" method="POST" class="login-form">
                    <h3 class="text-center">Iniciar Sesión</h3>

                    <!-- Aquí se mostrará la alerta con JavaScript si existe un error -->
                    <div id="alert-container"></div>

                    <div class="form-group">
                        <label for="username">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username"
                            placeholder="Ingresa tu usuario" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Ingresa tu contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript para mostrar la alerta -->
    <script>
        // Función para obtener los parámetros de la URL
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        // Función para eliminar los parámetros de la URL
        function removeQueryParams() {
            const url = new URL(window.location);
            url.search = '';  // Elimina todos los parámetros de la búsqueda
            window.history.replaceState(null, '', url);  // Reemplaza la URL actual
        }

        // Verificar si existe un error en la URL
        const error = getQueryParam('error');

        if (error) {
            let alertMessage = '';

            if (error === 'incorrect_password') {
                alertMessage = 'Contraseña incorrecta, por favor intenta nuevamente.';
            } else if (error === 'user_not_found') {
                alertMessage = 'Usuario no encontrado, verifica tu nombre de usuario.';
            }

            if (alertMessage) {
                // Crear una alerta de Bootstrap y agregarla al DOM
                const alertContainer = document.getElementById('alert-container');
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger text-center';
                alertDiv.role = 'alert';
                alertDiv.innerHTML = alertMessage;
                alertContainer.appendChild(alertDiv);
            }

            // Eliminar los parámetros de la URL después de mostrar la alerta
            removeQueryParams();
        }

    </script>
</body>

</html>