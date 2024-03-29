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
// Establecer el conjunto de caracteres a utf8
$conexion->set_charset('utf8');
$result = mysqli_query($conexion, $query);

// Validar si se encontraron resultados
if (!$result || mysqli_num_rows($result) === 0) {
    // Mostrar mensaje de error si no se encuentra el psicólogo
    echo '<script>alert("No se encontró el psicólogo con el ID proporcionado");</script>';
    exit();
}

// Obtener la información del psicólogo
$psychologistData = mysqli_fetch_assoc($result);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


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
                <li><a href="../psicologos/psicologosOnline.php">Psicologos</a></li>
            </ul>
        </nav>

        <div class="fas fa-bars"></div>

    </header>
    <!-- header section end  -->


    <!-- Presentacion section -->
    <section id="presentacion">
        <div class="container">
            <div class="row " id="cardContainer">
                <!-- Primera Card -->
                <div class="cold-md-6">
                    <div class="card mb-3" id="cardPresentacion">
                        <img src="<?php echo $psychologistData['rutaImagen']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <span class='tooltiptext'
                                data-valor='<?php echo htmlspecialchars($psychologistData['valor']); ?>'></span>


                            <h5 class="card-title">
                                <?php echo $psychologistData['nombre']; ?>
                            </h5>
                            <h5 class="card-titleDos">
                                <?php echo $psychologistData['titulo']; ?>
                            </h5>
                            <p class="card-text">
                                Matrícula:MN <?php echo $psychologistData['matricula']; ?>(AR)
                                Matrícula:MP <?php echo $psychologistData['matriculaP']; ?>(AR)
                            </p>

                            <button class="btn btn-primary" id="contact" onclick="abrirModal()">Contactar</button>

                        </div>
                    </div>
                </div>
                <!--ventana emergente-->

                <div class="modal">
                    <div class="modal-background"></div>
                    <div class="modal-content">
                        <!-- Contenido de la ventana modal -->
                        <span class="close">&times;</span>
                        <div class="modal-text">
                            <p>Estimado usuario,

                                Por favor, ten en cuenta que estás a punto de ser redirigido a nuestra plataforma de
                                pago segura para completar tu transacción. Garantizamos la confidencialidad y seguridad
                                de tus datos durante este proceso.

                                Asegúrate de revisar cuidadosamente los detalles de tu compra antes de proceder con el
                                pago. Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.

                                ¡Gracias por tu confianza!

                                Equipo de Terapia Libre
                            </p>

                            <!-- Agrega un campo de entrada para el correo electrónico -->
                            <label for="user-email">Correo Electrónico:</label>
                            <input type="email" id="user-email" name="user-email" placeholder="Ingresar mail..."
                                required>

                            <button class="btn btn-primary" id="checkout-btn"
                                data-psychologist-id="<?php echo $psychologistId; ?>">Contactar Profesional</button>
                            <div id="wallet_container"></div>
                        </div>
                    </div>
                </div>

                <!--ventana emergente-->


                <!-- Especialidad -->
                <div class="card mb-3">
                    <div class="card-body text-left">
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
    <!--
        */*/
     -->
    <!--Fin de la sección de Puntuación y Opinión -->


    </div>
    </div>

    <!-- Presentacion section end -->


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