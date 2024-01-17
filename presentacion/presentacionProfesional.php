<?php
// Incluir la conexión a la base de datos
include '../php/conexion.php';

// Iniciar sesión
session_start();

// Obtener el ID del psicólogo desde la URL
$psychologistId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validar el ID del psicólogo
if ($psychologistId <= 0) {
    // Mostrar mensaje de error si el ID no es válido
    echo '<script>alert("ID de psicólogo no válido");</script>';
    exit();
}

// Consultar la base de datos para obtener la información del psicólogo con el ID proporcionado
$query = "SELECT * FROM presentaciones WHERE id = $psychologistId";
$result = mysqli_query($conexion, $query);

// Validar si se encontraron resultados
if (!$result || mysqli_num_rows($result) === 0) {
    // Mostrar mensaje de error si no se encuentra el psicólogo
    echo '<script>alert("No se encontró el psicólogo con el ID proporcionado");</script>';
    exit();
}

// Obtener la información del psicólogo
$psychologistData = mysqli_fetch_assoc($result);

// Consultar comentarios solo para el psicólogo actual
$commentQuery = "SELECT * FROM comentarios WHERE psychologist_id = $psychologistId";
$commentResult = mysqli_query($conexion, $commentQuery);

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terapia Libre</title>

    <!--icono pestana-->
    <link rel="icon" href="../img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="../img/Logo_transparente.png" type="image/x-icon">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../estilos/stylePsicoPresentacion.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">



</head>

<body>
    <!-- header section starts  -->

    <header>

        <a href="../index.php" class="logo">
            <img src="../img/Logo_transparente.png" alt="Logo de Terapia Libre">
            Terapia Libre
        </a>

        <nav class="navbar">
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../psicologosOnline.php">Psicologos</a></li>
            </ul>
        </nav>

        <div class="fas fa-bars"></div>

    </header>
    <!-- header section end  -->


    <!-- Presentacion section -->
    <section id="presentacion">
        <div class="container">
            <div class="row justify-content-center" id="cardContainer">
                <!-- Primera Card -->

                <div class="card mb-3">
                    <img src="<?php echo $psychologistData['rutaImagen']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $psychologistData['nombre']; ?>
                        </h5>
                        <h5 class="card-titleDos">
                            <?php echo $psychologistData['titulo']; ?>
                        </h5>
                        <p class="card-text">Matrícula:MN
                            <?php echo $psychologistData['matricula']; ?>(AR)
                        </p>
                        <button class="btn btn-primary" id="checkout-btn" onclick="abrirModal()">Contactar</button>

                    </div>
                </div>
                <!--ventana emergente-->

                <div class="modal">
                    <div class="modal-background"></div>
                    <div class="modal-content">
                        <!-- Contenido de la ventana modal -->
                        <span class="close">&times;</span>
                        <div class="modal-text">
                            <p>Contenido de la ventana modal</p>
                            <button class="btn btn-primary"
                                onclick="window.location.href='https://mpago.la/1NgVPms';">Contactar</button>
                            <!--<div id="wallet_container"></div>-->
                        </div>
                    </div>
                </div>

                <!--ventana emergente-->
                <!-- Especialidad -->

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Especialidades</h5>
                        <p class="card-text">
                            <?php echo $psychologistData['especialidad']; ?>
                        </p>
                    </div>
                </div>

                <!-- Presentacion -->

                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Presentación</h5>
                        <p class="card-text">
                            <?php echo ($psychologistData['descripcion']); ?>
                        </p>
                    </div>
                </div>
    </section>
    <!-- Nueva sección de Puntuación y Opinión -->
    <section>
        <!-- Comentario section-->
        <?php
        include '../php/conexion.php';

        $resultado = mysqli_query($conexion, 'SELECT * FROM comentarios');
        ?>

        <form method="POST" action="../php/enviarcomentario.php" class="comment-form">
            <section id="contact" class="comment-section">
                <div class="containerComment">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <h2 class="comment-title">Comentarios</h2>
                            <div class="comment-input">
                                <h3 class="input-title">¡Haz un Comentario!</h3>
                                <div class="form-group">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input class="form-control" name="nombre" type="text" id="nombre"
                                        placeholder="Escribe tu nombre" required>
                                </div>
                                <div class="form-group">
                                    <label for="comentario" class="form-label">Comentario:</label>
                                    <textarea class="form-control" name="comentario" cols="30" rows="5" type="text"
                                        id="comentario" placeholder="Escribe tu comentario..."></textarea>
                                </div>
                                <input type="hidden" name="psychologist_id" value="<?php echo $psychologistId; ?>">
                                <input class="btn btn-primary" type="submit" value="Enviar Comentario">
                            </div>

                            <div class="comments-container">
                                <!-- Aquí se mostrarán los comentarios -->
                                <?php
                                while ($comentario = mysqli_fetch_object($commentResult)) {
                                    ?>
                                    <div class="comment">
                                        <b>
                                            <?php echo ($comentario->nombre); ?>
                                        </b>
                                        <span class="comment-date">
                                            <?php echo ($comentario->fecha); ?>
                                        </span>
                                        <p class="comment-text">
                                            <?php echo ($comentario->comentario); ?>
                                        </p>

                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </form>

    </section>
    <!--Fin de la sección de Puntuación y Opinión -->


    </div>
    </div>

    <!-- Presentacion section end -->


    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <a href="#presentacion" class="logo">
                    <img src="../img/Logo_transparente.png" alt="Logo de Terapia Libre">
                    Terapia libre
                </a>
                <p>
                    Te da la posibilidad de contactar a distancia la salud mental online acercandonos a
                    donde estes y ofreciendote la mejor atencion, con la finalidad de atender tus necesidades
                    con los mejores profesionales.
                </p>
            </div>

            <div class="box">
                <h3 class="share">Redes</h3>
                <a href="#">Instagram</a>
            </div>

        </div>

        <h1 class="credit">created by <span>WorldSoftSystem</span> | all rights reserved. </h1>

    </section>

    <!-- footer section ends -->


    <!-- custom js file link  -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script src="../scripts/app.js"></script>

</body>

</html>