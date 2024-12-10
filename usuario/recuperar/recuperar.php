<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <!--icono pestana-->
    <link rel="icon" href="../../img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="../../img/Logo_transparente.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            margin: 0;
        }
        .d-flex-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            background-color: white;
        }
        .card h2 {
            margin-bottom: 30px;
            text-align: center;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
        }
        .btn-custom {
            background-color: #b6e6f6;
            color: #005f73;
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            width: 100%;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #7cc2df;
            color: #003d52;
        }
        .card-footer {
            text-align: center;
            margin-top: 20px;
        }
        .card-footer a {
            text-decoration: none;
            color: #005f73;
            font-size: 14px;
        }
        .card-footer a:hover {
            text-decoration: underline;
        }
        /* Responsive tweaks */
        @media (max-width: 576px) {
            .card {
                padding: 20px;
            }
            .btn-custom {
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<div class="d-flex-container">
    <div class="card">
        <h2>Recuperar Contraseña</h2>
        <form action="./enviar_email.php" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Ingresa tu correo electrónico">
            </div>
            <button type="submit" class="btn-custom">Enviar enlace de recuperación</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
