<?php
session_start(); // Asegúrate de iniciar la sesión en todas las páginas

// Verificar si el usuario está logueado
$usuarioLogueado = false;
$nombreUsuario = '';  // Variable para almacenar el nombre del usuario
$usuarioId= '';  // Guarda el ID del usuario en la sesión

if (isset($_SESSION['user_id'])) {
    $usuarioLogueado = true;
    $nombreUsuario = $_SESSION['user_nombre'];  // Recuperar el nombre del usuario de la sesión
    $usuarioId = $_SESSION['user_id'];  // Recuperar el nombre del usuario de la sesión
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terapia Libre</title>

    <!-- Icono de pestaña -->
    <link rel="icon" href="../img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="../img/Logo_transparente.png" type="image/x-icon">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../estilos/headerYFooter.css">
    <link rel="stylesheet" href="../estilos/stylePsicoPresentacion.css">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- jQuery (cargar solo una vez) -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Bootstrap JS (usar la misma versión que el CSS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

   

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet"/>
    <!-- FullCalendar JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

    <!-- custom js file link  -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <!-- MercadoPago -->
    <script src="https://www.mercadopago.com/v2/security.js" view="checkout"></script>

    <!-- PayPal SDK -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=ASuvwaL7zuIKfyr5_OppnnQGrKqyvWDPkSn2BSHYTSR8wHbxOQPZE1JzVQ2Oj8ECpJSJ2XF-0ADkTk4l&currency=USD"></script>



    <script src="./js/presentacionProf.js"></script>
</head>


<body data-usuario-logueado="<?php echo $usuarioLogueado ? 'true' : 'false'; ?>" data-usuario-id="<?php echo $usuarioId; ?>">


    <!-- header section starts  -->

    <!-- header section starts  -->

    <header class="d-flex justify-content-between align-items-center bg-white shadow fixed-top p-2">
        <a href="../index.php" class="logo d-flex align-items-center text-decoration-none text-success mx-auto mx-lg-0">
            <img src="../img/Logo_transparente.png" alt="Logo de Terapia Libre" class="mr-2" style="width: 7rem;">
            <span>Terapia Libre</span>
        </a>

        <nav class="navbar navbar-expand-lg navbar-light d-none d-lg-flex">
            <ul class="navbar-nav ml-auto">
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../psicologos/psicologosOnline.php">Psicologos</a></li>
                <!-- Mostrar "Perfil" si el usuario está logueado -->
                <?php if ($usuarioLogueado): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../usuario/dashboard/dashboard.php">Hola,
                            <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../usuario/control/logout.php">Cerrar sesión</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../usuario/index.php">Iniciar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Menú tipo TikTok solo visible en móviles -->
        <nav class="mobile-navbar d-lg-none fixed-bottom bg-white p-2 shadow">
            <ul class="d-flex justify-content-between w-100 text-center">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">
                        <i class="fas fa-home"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../psicologos/psicologosOnline.php">
                        <i class="fas fa-users"></i>
                        <span>Psicologos</span>
                    </a>
                </li>
                <!-- Mostrar "Perfil" si el usuario está logueado en el menú móvil -->
                <?php if ($usuarioLogueado): ?>
                    <li>
                        <a href="../usuario/dashboard/dashboard.php">
                            <i class="fas fa-user"></i>
                            <p>Hola, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></p>
                        </a>
                    </li>
                    <li>
                        <a href="../usuario/control/logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Cerrar sesión</p>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="../usuario/index.php">
                            <i class="fas fa-user"></i>
                            <p>Iniciar sesión</p>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

    </header>
    <!-- header section end  -->

    <section id="presentacion">
        <div class="container">
            <input type="hidden" id="user-id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">

            <div class="row" id="cardContainer">
                <!-- Las tarjetas se llenarán dinámicamente aquí -->
            </div>

        </div>
    </section>






    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <a href="index.php" class="logo">
                    <img src="../img/Logo_transparente.png" alt="Logo de Terapia Libre">
                    Terapia Libre
                </a>
                <p>
                    Es una plataforma innovadora que te ofrece la libertad de elegir al profesional de salud mental
                    ideal para ti. Con una amplia variedad de expertos, facilitamos la búsqueda y selección de tu
                    terapeuta, priorizando tu bienestar emocional con tratamientos personalizados.
                </p>
            </div>

            <div class="box">
                <h3 class="share">Redes</h3>
                <a href="https://www.instagram.com/terapia.libre?igsh=MTE3cnBnYXB5OHVwZA=="><i
                        class="bi bi-instagram"></i> Instagram</a>
            </div>




        </div>

        <h1 class="credit">created by <span>WorldSoftSystem</span> | all rights reserved. </h1>

    </section>

    <!-- footer section ends -->




</body>

</html>