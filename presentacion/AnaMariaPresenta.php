<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Salud Online</title>

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
            Terapia libre
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
    <div class="container">
        <div class="row justify-content-center" id="cardContainer">
            <!-- Primera Card -->

            <div class="card mb-3">
                <img src="../img/modelo.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Lic. Ana Maria Pinto</h5>
                    <h5 class="card-titleDos">Lic. en Psicología Terapia Psicoanalitica</h5>
                    <p class="card-text">Matrícula MN 46489 (AR)</p>
                    <button class="btn btn-primary" id="checkout-btn">Contactar</button>

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
                        <button class="btn btn-primary" onclick="window.location.href='https://mpago.la/1NgVPms';">Contactar</button>
                        <!--<div id="wallet_container"></div>-->
                    </div>
                </div>
            </div>

            <!--ventana emergente-->
            <!-- Especialidad -->

            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Especialidades</h5>
                    <p class="card-text">Ansiedad y estrés. Autoestima baja. Miedos al COVID-19. Problemas de
                        concentración. Problemas de familia. Pérdida de un ser querido.</p>
                </div>
            </div>

            <!-- Presentacion -->

            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Presentación</h5>
                    <p class="card-text">Soy Patricia Candia. Psicopedagoga y Psicóloga con más de 20 años de
                        trayectoria.
                        <span id="moreText" style="display: none;">
                            Comencé trabajando con niños y adolescentes, para luego también atender y ayudar a adultos.
                            Me importa la realidad subjetiva que recorre a cada uno de mis pacientes y que determina su
                            modo de comportarse, de desear e incluso de sufrir. Mi formación, experiencia y compromiso
                            con las personas me han permitido poder contenerlos y ayudarlos en cada etapa de su proceso
                            evolutivo.
                            Me entusiasma abordar nuevos horizontes a través de Terapia Mia y de manera online, siendo
                            el análisis un camino donde el paciente se detiene en un momento, y decide replantear su
                            vida con el desafío de volver a empezar. Donde los miedos, ansiedades, angustias y otras
                            dolencias dan paso a los deseos, la palabra, las alegrías, en un camino que tiene como
                            destino final "La verdad". Por eso como terapeuta destaco mi capacidad de escucha y de
                            empatía, que me permiten construir un vínculo ameno, cordial donde mis pacientes se sientan
                            cómodos, contenidos y respetados.
                        </span>
                    </p>
                    <button onclick="toggleText()" class="btn btn-primary" id="botonLeer">Leer más</button>
                </div>
            </div>
            <!-- Nueva sección de Puntuación y Opinión -->
            <!-- Comentario section-->
            <form method="POST" action="../php/enviarcomentario.php" class="comment-form">
                <section id="contact" class="comment-section">
                    <div class="containerComment">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <h2 class="comment-title">Comentarios</h2>
                                <p class="comment-lead">Haz un comentario</p>

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
                                    <input class="btn btn-primary" type="submit" value="Enviar Comentario">
                                </div>

                                <div class="comments-container">
                                    <!-- Aquí se mostrarán los comentarios -->
                                    <?php
                                    $conexion = mysqli_connect("localhost", "root", "", "comentariosphp");
                                    $resultado = mysqli_query($conexion, 'SELECT * FROM comentarios');

                                    while ($comentario = mysqli_fetch_object($resultado)) {
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

            <!--Fin de la sección de Puntuación y Opinión -->


        </div>
    </div>

    <!-- Presentacion section end -->


    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <a href="AnaMariaPresenta.php" class="logo">
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
                <a href="#">instagram</a>
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