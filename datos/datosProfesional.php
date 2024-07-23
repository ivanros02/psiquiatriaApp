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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Salud Online</title>

    <!--icono pestana-->
    <link rel="icon" href="../img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="../img/Logo_transparente.png" type="image/x-icon">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../estilos/headerYFooter.css">
    <link rel="stylesheet" href="../estilos/styleDatos.css">
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">



</head>

<body>
    <!-- header section starts  -->

    <header>

        <a href="#" class="logo">
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
                    <p class="card-text">
                        Matrícula:MN
                        <?php echo $psychologistData['matricula']; ?>(AR)
                        Matrícula:MP
                        <?php echo $psychologistData['matriculaP']; ?>(AR)
                    </p>
                    <!-- Div para contener los iconos -->
                    <div class="cajitas">
                    <a class="iconito icon-whatsapp" href="https://api.whatsapp.com/send?phone=<?php echo $psychologistData['whatsapp']; ?>&text=Hola%20me%20contacto%20desde%20Terapia%20Libre.%20Quiero%20solicitar%20un%20turno!"><i class="fab fa-whatsapp"></i></a>


                        <a class="iconito icon-instagram"
                            href="https://www.instagram.com/<?php echo $psychologistData['instagram']; ?>"><i
                                class="fab fa-instagram"></i></a>

                        <a class="iconito icon-gmail" href="mailto:<?php echo $psychologistData['mail']; ?>"><i
                                class="far fa-envelope"></i></a>

                    </div>

                </div>
            </div>


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
    <!--<script src="https://sdk.mercadopago.com/js/v2"></script>-->
    <script src="../scripts/datos.js"></script>

</body>

</html>