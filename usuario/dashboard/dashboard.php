<?php
session_start();
if (!isset($_SESSION['user_id'])) { // Cambia esto
    header('Location: ../index.php');
    exit();
}

include '../../php/conexion.php';

$usuario_id = $_SESSION['user_id']; // Cambia esto también

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
    <title>Dashboard</title>
    <!--icono pestana-->
    <link rel="icon" href="../../img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="../../img/Logo_transparente.png" type="image/x-icon">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- custom css file link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="../../estilos/headerYFooter.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:wght@400;700&display=swap');

        html {
            font-size: 62.5%;
            /* 1rem = 10px */
        }

        .custom {
            font-size: 4rem;
            color: var(--green);
            padding: 1rem;
            padding-top: 11rem;
            font-family: 'Things' !important;
        }

        .custom-margin-top {
            margin-top: 1rem;
            margin-bottom: 15rem;
        }

        .btn-chat {
            color: var(--green) !important;
        }

        .btn-video {
            color: var(--green) !important;
        }

        .card {
            border-radius: 30px;
            /* Ajusta el valor a tu preferencia */
        }
    </style>
</head>

<body>
    <header class="d-flex justify-content-between align-items-center bg-white shadow fixed-top p-2">
        <a href="../../index.php" class="logo d-flex align-items-center text-decoration-none text-success mx-auto mx-lg-0">
            <img src="../../img/Logo_transparente.png" alt="Logo de Terapia Libre" class="mr-2" style="width: 7rem;">
            <span>Terapia Libre</span>
        </a>

        <nav class="navbar navbar-expand-lg navbar-light d-none d-lg-flex">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../../index.php">Hola, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./perfil/perfil.php">Perfil</a>
                </li>
            </ul>
        </nav>

        <!-- Menú tipo TikTok solo visible en móviles -->
        <nav class="mobile-navbar d-lg-none fixed-bottom bg-white p-2 shadow">
            <ul class="d-flex justify-content-between w-100 text-center">
                <li>
                    <a href="../../index.php">
                        <i class="fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <li>
                    <a href="./perfil/perfil.php">
                        <i class="fas fa-user"></i>
                        <p>Hola, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></p>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <div class="container-fluid custom-margin-top">
        <div class="row justify-content-center">
            <!-- Main content -->
            <main class="col-12 col-md-10 col-lg-8 d-flex justify-content-center">
                <div class="container-fluid mt-5">
                    <h2 class="display-4 mb-4 text-center custom">Mis terapeutas</h2>

                    <!-- Ajustes a la tabla para pantallas grandes -->
                    <div id="profesionales-list"
                        class="table-responsive table-container shadow-sm p-4 bg-white rounded">
                        <!-- Los datos se cargarán aquí mediante AJAX -->
                    </div>
                </div>
            </main>
        </div>
    </div>



    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <a href="index.php" class="logo">
                    <img src="../../img/Logo_transparente.png" alt="Logo de Terapia Libre">
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
                        class="bi bi-instagram"></i>
                    Instagram</a>
            </div>



        </div>

        <h1 class="credit">created by <span>WorldSoftSystem</span> | all rights reserved. </h1>

    </section>

    <!-- footer section ends -->







    <script>
        $(document).ready(function () {
            // Cargar los profesionales relacionados con el usuario
            $.ajax({
                url: './gets/get_profesionales.php',
                type: 'POST',
                data: { usuario_id: <?= $usuario_id; ?> },
                success: function (response) {
                    $('#profesionales-list').html(response);
                },
                error: function () {
                    $('#profesionales-list').html('<div class="alert alert-danger">Error al cargar la lista de profesionales.</div>');
                }
            });
        });

    </script>
</body>

</html>