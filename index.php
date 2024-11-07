<?php
session_start(); // Asegúrate de iniciar la sesión en todas las páginas

// Verificar si el usuario está logueado
$usuarioLogueado = false;
$nombreUsuario = '';  // Variable para almacenar el nombre del usuario

if (isset($_SESSION['user_id'])) {
    $usuarioLogueado = true;
    $nombreUsuario = $_SESSION['user_nombre'];  // Recuperar el nombre del usuario de la sesión
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terapia Libre</title>
    <meta name="description"
        content="Terapia Libre ofrece servicios de terapia psicológica profesional para ayudar a las personas a mejorar su bienestar emocional y mental.">

    <!--icono pestana-->
    <link rel="icon" href="img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="img/Logo_transparente.png" type="image/x-icon">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- custom css file link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="estilos/headerYFooter.css">
    <link rel="stylesheet" href="estilos/style.css">




    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- WOW.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <!-- bootrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>


    <!-- Agrega los scripts de Bootstrap y jQuery justo antes de cerrar la etiqueta </body> -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Meta Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return; n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
            n.queue = []; t = b.createElement(e); t.async = !0;
            t.src = v; s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1237863354199215');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1237863354199215&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
</head>

<body>

    <!-- header section starts  -->

    <header class="d-flex justify-content-between align-items-center bg-white shadow fixed-top p-2">
        <a href="index.php" class="logo d-flex align-items-center text-decoration-none text-success mx-auto mx-lg-0">
            <img src="./img/Logo_transparente.png" alt="Logo de Terapia Libre" class="mr-2" style="width: 7rem;">
            <span>Terapia Libre</span>
        </a>

        <nav class="navbar navbar-expand-lg navbar-light d-none d-lg-flex">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#service">¿Cuándo acudir a nosotros?</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./cargaDatosPsicologos/carga.php">Soy un profesional</a>
                </li>

                <!-- Mostrar "Perfil" si el usuario está logueado -->
                <?php if ($usuarioLogueado): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./usuario/dashboard/dashboard.php">Hola,
                            <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./usuario/control/logout.php">Cerrar sesión</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./usuario/index.php">Iniciar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <!-- Menú tipo TikTok solo visible en móviles -->
        <nav class="mobile-navbar d-lg-none fixed-bottom bg-white p-2 shadow">
            <ul class="d-flex justify-content-between w-100 text-center">
                <li>
                    <a href="#home">
                        <i class="fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <li>
                    <a href="#about">
                        <i class="fas fa-info-circle"></i>
                        <p>Nosotros</p>
                    </a>
                </li>
                <li>
                    <a href="#service">
                        <i class="fas fa-hands-helping"></i>
                        <p>¿Cuándo acudir?</p>
                    </a>
                </li>
                <li>
                    <a href="./cargaDatosPsicologos/carga.php">
                        <i class="fas fa-user-md"></i>
                        <p>Profesional</p>
                    </a>
                </li>

                <!-- Mostrar "Perfil" si el usuario está logueado en el menú móvil -->
                <?php if ($usuarioLogueado): ?>
                    <li>
                        <a href="./usuario/dashboard/dashboard.php">
                            <i class="fas fa-user"></i>
                            <p>Hola, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></p>
                            <!-- Mostrar el nombre del usuario -->
                        </a>
                    </li>
                    <li>
                        <a href="./usuario/control/logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Cerrar sesión</p>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="./usuario/index.php">
                            <i class="fas fa-user"></i>
                            <p>Iniciar sesión</p>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
    </header>


    <!-- header section ends -->


    <!-- header section ends -->

    <!-- home section starts  -->

    <section class="home" id="home">

        <div class="content">

            <h1 class="wow animate__animated animate__zoomIn">ENCUENTRA DE INMEDIATO <br> EL PROFESIONAL PARA <br>
                INICIAR TU
                TRATAMIENTO.</h1>
            <p class="wow animate__animated animate__zoomIn">Elegí entre más de 1000 especialistas,<br>
                tu asistencia terapéutica de forma <br> inmediata
                con turnos a partir de 24 hs.
            </p>
            <a href="./psicologos/psicologosOnline.php"><button class="btn wow animate__animated animate__zoomIn">BUSCAR
                    UN PROFESIONAL</button></a>

        </div>

    </section>

    <!-- home section ends -->

    <!--icono flotante whatsapp 
    <a href="https://api.whatsapp.com/send?phone=5491161536595" class="btn-wsp" target="_blank">
        <i class="fa fa-whatsapp icono"></i>
    </a>
    -->

    <!-- about section starts  -->

    <section class="about" id="about">
        <div class="container py-5">
            <div class="container py-5">
                <div class="row align-items-center">
                    <!-- Video a la izquierda con un margen superior y un pequeño margen a la derecha, oculto en móviles -->
                    <div class="col-lg-5 col-md-12 mb-4 mb-lg-0 d-none d-md-block" style="margin-top: 16rem;">
                        <video class="w-100 ms-lg-3" autoplay loop muted>
                            <source src="img/nuevoCerebro.mp4" type="video/mp4">
                            Tu navegador no soporta el elemento de video.
                        </video>
                    </div>
                    <!-- Contenido a la derecha -->
                    <div class="col-lg-7 col-md-12">
                        <h2 class="quienesSomos wow animate__animated animate__backInLeft"
                            style="font-size: 3rem; margin-bottom: 20px;">
                            Quienes Somos
                        </h2>
                        <p class="wow animate__animated animate__backInLeft" style="font-size: 2rem;">
                            En nuestra plataforma web, nos encargamos de conectar a los usuarios que requieren atención
                            terapéutica con profesionales altamente competentes. Buscamos facilitar el acceso a
                            servicios de
                            psicoterapia individual de forma conveniente, contando con una amplia variedad de
                            profesionales
                            que ofrecen diferentes especialidades y enfoques terapéuticos. De esta manera, los usuarios
                            tienen
                            la oportunidad de seleccionar al terapeuta que mejor se ajuste a sus necesidades y les
                            acompañe en
                            el proceso de recuperación.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <h2 class="heading wow animate__animated animate__backInLeft" data-wow-delay="0.6s">Comentarios</h2>
            <div class="slider">
                <div class="item">

                    <p>Agradezco mucho por la ayuda recibida durante nuestras sesiones. Su profesionalismo y apoyo han
                        sido fundamentales para mi bienestar emocional. ¡Gracias por tanto!</p>
                    <img src="./img/coments/coment1.jpg" class="imgCard" alt="Usuario 1">

                </div>
                <div class="item">
                    <p>Quiero agradecer sinceramente por la atención psicológica recibida. Su apoyo ha sido fundamental
                        para mi bienestar emocional.</p>
                    <img src="./img/coments/coment1.jpg" class="imgCard" alt="Usuario 1">
                </div>
                <div class="item">
                    <p>Agradezco mucho por la ayuda recibida durante nuestras sesiones. Su profesionalismo y apoyo han
                        sido fundamentales para mi bienestar emocional. Gracias!!</p>
                    <img src="./img/coments/coment1.jpg" class="imgCard" alt="Usuario 1">
                </div>
                <div class="item">
                    <p>Quiero agradecer sinceramente por la atención y el apoyo recibidos. Su profesionalismo ha sido
                        fundamental para mí.</p>
                    <img src="./img/coments/coment1.jpg" class="imgCard" alt="Usuario 1">
                </div>
                <div class="item">
                    <p>Quisiera expresar mi agradecimiento por las rápidas evoluciones terapéuticas que experimente.</p>
                    <img src="./img/coments/coment1.jpg" class="imgCard" alt="Usuario 1">
                </div>
                <div class="item">
                    <p>Su apoyo y orientación han sido fundamentales en mi proceso de sanación y crecimiento personal.
                        ¡Gracias por hacer posible estos avances tan significativos!</p>
                    <img src="./img/coments/coment1.jpg" class="imgCard" alt="Usuario 1">
                </div>
                <button id="next">></button>
                <button id="prev"><</button>
            </div>
        </div>
    </section>


    <!-- about section ends -->

    <!-- service section starts  -->

    <section class="service" id="service">
        <h2 class="heading wow animate__animated animate__backInLeft" data-wow-delay="0.4s">
            ¿En qué situaciones deberías acudir a nuestros profesionales de salud mental?
        </h2>

        <div class="row mt-4 mx-3">
            <!-- Card 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog-card spring-fever card1">
                    <div class="gradient-overlay"></div>
                    <div class="title-content">
                        <h3>Ansiedad</h3>
                        <hr />
                        <div class="intro">Cuando sientas niveles altos de ansiedad y estrés.</div>
                    </div>
                    <div class="card-info">
                        La ansiedad puede afectar tu vida diaria y tus relaciones personales. Nuestros profesionales
                        están capacitados para ayudarte a gestionarla.
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog-card spring-fever card2">
                    <div class="gradient-overlay"></div>
                    <div class="title-content">
                        <h3>Depresión</h3>
                        <hr />
                        <div class="intro">Cuando experimentes sentimientos persistentes de tristeza.</div>
                    </div>
                    <div class="card-info">
                        La depresión no debe ser enfrentada sola. Nuestros terapeutas ofrecen un ambiente seguro y
                        profesional para apoyarte en tu recuperación.
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog-card spring-fever card3">
                    <div class="gradient-overlay"></div>
                    <div class="title-content">
                        <h3>Problemas de relación</h3>
                        <hr />
                        <div class="intro">Cuando enfrentes dificultades en tus relaciones.</div>
                    </div>
                    <div class="card-info">
                        Las relaciones pueden ser complicadas. La terapia te puede ayudar a resolver conflictos y
                        mejorar tus habilidades de comunicación.
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog-card spring-fever card4">
                    <div class="gradient-overlay"></div>
                    <div class="title-content">
                        <h3>Estrés laboral</h3>
                        <hr />
                        <div class="intro">Cuando el trabajo sea abrumador y afecte tu salud mental.</div>
                    </div>
                    <div class="card-info">
                        Nuestros terapeutas pueden guiarte en el manejo del estrés y en cómo balancear mejor tu vida
                        personal y profesional.
                    </div>
                </div>
            </div>
            <!-- Card 5 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog-card spring-fever card5">
                    <div class="gradient-overlay"></div>
                    <div class="title-content">
                        <h3>Autoestima baja</h3>
                        <hr />
                        <div class="intro">Cuando sientas inseguridades que afecten tu autovaloración.</div>
                    </div>
                    <div class="card-info">
                        La autoestima es crucial para tu bienestar. Trabaja en mejorar tu autoconfianza con la guía de
                        un terapeuta.
                    </div>
                </div>
            </div>
            <!-- Card 6 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="blog-card spring-fever card6">
                    <div class="gradient-overlay"></div>
                    <div class="title-content">
                        <h3>Duelo</h3>
                        <hr />
                        <div class="intro">Cuando enfrentes la pérdida de un ser querido.</div>
                    </div>
                    <div class="card-info">
                        El proceso de duelo puede ser abrumador, pero con el apoyo adecuado puedes encontrar formas
                        saludables de sobrellevar la pérdida.
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- service section ends -->


    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <a href="index.php" class="logo">
                    <img src="img/Logo_transparente.png" alt="Logo de Terapia Libre">
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
                <a href="https://www.instagram.com/terapia.libre/?igsh=MTE3cnBnYXB5OHVwZA%3D%3D"><i
                        class="bi bi-instagram"></i> Instagram</a>

                <h3 class="share">Administradores</>
                    <!-- Añadir el enlace de administradores aquí -->
                    <a href="./administracionPresentaciones/inicioAdmin.php"><i class="bi bi-person-circle"></i> Acceder
                        como administrador</a>
            </div>




        </div>

        <h2 class="credit">created by <span>WorldSoftSystem</span> | all rights reserved. </h2>

    </section>

    <!-- footer section ends -->


    <!-- custom js file link  -->
    <script src="scripts/script.js"></script>

</body>

</html>