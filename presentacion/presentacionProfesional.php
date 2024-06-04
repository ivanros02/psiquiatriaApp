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
    
    <script src="https://www.mercadopago.com/v2/security.js" view="checkout"></script>
    
    <!-- Initialize the JS-SDK -->
    <script
        src="https://www.paypal.com/sdk/js?client-id=ASuvwaL7zuIKfyr5_OppnnQGrKqyvWDPkSn2BSHYTSR8wHbxOQPZE1JzVQ2Oj8ECpJSJ2XF-0ADkTk4l&currency=USD"></script>


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

                            <button class="btn btn-primary" id="contact">Contactar</button>

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
                            <!-- Agrega el contenedor para los botones de PayPal -->
                            <div id="paypal-button-container"></div>
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
                <a href="https://www.instagram.com/terapia.libre?igsh=MTE3cnBnYXB5OHVwZA=="><i class="bi bi-instagram"></i> Instagram</a>
            </div>




        </div>

        <h1 class="credit">created by <span>WorldSoftSystem</span> | all rights reserved. </h1>

    </section>

    <!-- footer section ends -->


    <!-- custom js file link  -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script src="../scripts/app.js"></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function enviarCorreoElectronicoAComprador(psychologistId, userEmail) {
            // Realizar una solicitud AJAX para enviar el correo electrónico
            $.ajax({
                url: 'https://terapialibre.com.ar/paypal/correo.php',
                method: 'POST',
                data: { psychologist_id: psychologistId, user_email: userEmail },
                success: function (response) {
                    console.log('Correo electrónico enviado correctamente:', response);
                },
                error: function (xhr, status, error) {
                    console.error('Error al enviar el correo electrónico:', error);
                }
            });
        }
        // PAYPAL
        document.getElementById("checkout-btn").addEventListener("click", async () => {
            // Captura el valor del data-valor del span
            const valorSpan = document.querySelector('.tooltiptext').getAttribute('data-valor');
            paypal.Buttons({
                style: {
                    color: 'blue',
                    shape: 'pill',
                    label: 'pay'
                },
                createOrder: function (data, actions) {
                    return actions.order.create({
                        purchase_units: [{

                            amount: {
                                value: valorSpan // Asignar el valor obtenido del span
                            },
                            reference_id: '<?php echo $psychologistData['id']; ?>'
                        }]
                    });
                },
                onApprove: function (data, actions) {
                    let url = '../paypal/captura.php';
                    actions.order.capture().then(function (detalles) {
                        // Obtener la dirección de correo electrónico del usuario
                        const user_email = detalles.payer.email_address;
                        return fetch(url, {
                            method: 'post',
                            headers: {
                                'content-type': 'application/json'
                            },
                            body: JSON.stringify({
                                detalles: detalles
                            })
                        }).then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            } else {
                                return response.text();
                            }
                        }).then(bodyText => {
                            console.log('Received the following instead of valid JSON:', bodyText);
                            try {
                                return JSON.parse(bodyText);
                            } catch (error) {
                                console.error('Error parsing JSON:', error, bodyText);
                                throw error;
                            }
                        }).then(data => {
                            if (data.status === 'success') {
                                console.log('Datos guardados correctamente:', data.message);
                                //enviar mail
                                enviarCorreoElectronicoAComprador('<?php echo $psychologistData['id']; ?>', user_email);
                                // Redireccionar a la URL específica después de que el pago se haya guardado correctamente
                                window.location.href = '../datos/datosProfesional.php?id=<?php echo $psychologistData['id']; ?>';
                            } else {
                                console.error('Error al guardar los datos:', data.message);
                            }
                        }).catch(error => console.error('Error en la solicitud:', error));
                    });
                },
                onCancel: function (data) {
                    alert('Pago cancelado');
                    console.log(data)
                }
            }).render('#paypal-button-container');
        });

        
    </script>
</body>

</html>