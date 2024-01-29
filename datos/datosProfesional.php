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
    <link rel="stylesheet" href="../estilos/styleDatos.css">
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

            <div class="card mb-3"
                style="background-image: url('../img/fondoPresntacion.jpg'); background-size: cover; background-position: center;">

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
                    <div class="contact-icons">
                        <div class="icon-wrapper">

                            <a href="https://api.whatsapp.com/send?phone=<?php echo $psychologistData['telefono']; ?>&text=Hola me contacto desde TerapiaLibre para solicitar una consulta!"
                                target="_blank" rel="noopener noreferrer">
                                <img src="../img/whatsapp-line.svg" alt="Icono de WhatsApp">
                            </a>

                            <p class="phone-number">Contacto por Whatsapp!</p>

                        </div>
                        <div class="icon-wrapper">
                            <a href="">
                                <img src="../img/Phone.png" alt="Icono de Teléfono">
                            </a>
                            <p class="phone-number">Tel:
                                <?php echo $psychologistData['telefono']; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Nueva sección de Puntuación y Opinión 
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Puntuación y Opinión</h5>
        <div class="rating">
            <input type="radio" id="star5" name="rating" value="5">
            <label for="star5">&#9733;</label>
            <input type="radio" id="star4" name="rating" value="4">
            <label for="star4">&#9733;</label>
            <input type="radio" id="star3" name="rating" value="3">
            <label for="star3">&#9733;</label>
            <input type="radio" id="star2" name="rating" value="2">
            <label for="star2">&#9733;</label>
            <input type="radio" id="star1" name="rating" value="1">
            <label for="star1">&#9733;</label>
        </div>        
        <textarea id="opinion" placeholder="Escribe tu opinión"></textarea>
        <button class="btn btn-primary">Enviar</button>
    </div>
</div>
 Fin de la sección de Puntuación y Opinión -->


        </div>
    </div>
    </div>
    </div>

    <!-- Presentacion section end -->





    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <a href="datosProfesional.php" class="logo">
                    <img src="../img/Logo_transparente.png" alt="Logo de Terapia Libre">
                    Terapia Libre
                </a>
                <p>
                    Es una plataforma innovadora que te brinda la libertad de elegir al profesional de salud mental que
                    mejor se adapte a tus necesidades. Con una amplia variedad de expertos y especialistas, la
                    plataforma facilita la búsqueda y selección de tu terapeuta ideal. Priorizamos la salud mental,
                    ofreciéndote un espacio donde puedas acceder a tratamientos personalizados y dedicados a mejorar tu
                    bienestar emocional.
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
    <!--<script src="https://sdk.mercadopago.com/js/v2"></script>-->
    <script src="../scripts/app.js"></script>

</body>

</html>