<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de carga</title>
    <!--icono pestana-->
    <link rel="icon" href="../img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="../img/Logo_transparente.png" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/headerYFooter.css">
    <style>
        .logo {
            font-size: 2rem;
            color: inherit;
            /* Mantener el color del texto original */
            text-decoration: none;
            /* Eliminar subrayado al pasar el cursor */
            font-weight: bold;
        }

        .logo img {
            width: 5rem;
            /* Ancho de la imagen */
            height: auto;
            /* Altura automática para mantener la proporción */
            margin-right: 10px;
            /* Espacio a la derecha del logo */
            vertical-align: middle;
            /* Alinear verticalmente */
        }

        /*FOOTER*/
        .footer {
            background: #333;
        }

        .footer .box-container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            width: 86%;
            margin: 0 auto;
        }

        .footer .box-container .box {
            margin: 0.5rem;
            flex: 1 1 25rem;
        }

        .footer .box-container .box .logo {
            font-size: 1rem;
            color: var(--green);
        }

        .footer .box-container .box .logo .img {
            width: 1rem;
        }

        .footer .box-container .box p {
            font-size: 1rem;
            color: #ccc;
            padding: 1rem 0;
            text-decoration: none !important;
        }

        .footer .box-container .box .share {
            text-align: center;
            font-size: 1rem;
            color: #fff;
            text-decoration: none !important;
        }

        .footer .box-container .box:nth-child(2) a {
            text-align: center;
            font-size: 1rem;
            color: #eee;
            display: block;
            padding: .5rem 0;
            text-decoration: none !important;
        }

        .footer .credit {
            text-align: center;
            color: #fff;
            font-size: 1rem;
            width: 85%;
            margin: 0 auto;
            padding: 2rem 1rem;
            border-top: .1rem solid #ccc;
        }

        .footer .credit span {
            color: var(--green);
        }
    </style>
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


            </ul>
        </nav>

        <div class="fas fa-bars"></div>

    </header>

    <!-- header section ends -->

    <div class="container mt-4">
        <h1 class="text-center mb-4" style="color: #c1c700; margin-top:10rem;">Panel de carga</h1>
        <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
            <div class="alert <?php echo $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger'; ?> text-center">
                <?php echo $_GET['message']; ?>
            </div>
        <?php endif; ?>
        <form action="procesar_carga.php" method="POST" enctype="multipart/form-data" class="mx-auto"
            style="max-width: 600px;">
            <div class="mb-3">
                <label for="imagen" class="form-label">Foto de Perfil:</label>
                <input class="form-control" id="imagen" name="imagen" type="file" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Nombre" required>
            </div>
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input class="form-control" id="titulo" name="titulo" type="text" placeholder="Título" required>
            </div>
            <div class="mb-3">
                <label for="matricula" class="form-label">Matrícula:</label>
                <input class="form-control" id="matricula" name="matricula" type="number" placeholder="Matrícula"
                    required>
            </div>
            <div class="mb-3">
                <label for="matriculaP" class="form-label">Matrícula Provincial:</label>
                <input class="form-control" id="matriculaP" name="matriculaP" type="number"
                    placeholder="Matrícula Provincial" required>
            </div>
            <div class="mb-3">
                <label for="especialidad" class="form-label">Especialidades:</label>
                <div class="row">
                    <?php
                    // Conexión a la base de datos y consulta de las especialidades
                    include '../php/conexion.php';
                    $query = "SELECT * FROM especialidades";
                    $conexion->set_charset('utf8');
                    $result = $conexion->query($query);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $checked = (isset($_POST['especialidad']) && in_array($row['id'], $_POST['especialidad'])) ? 'checked' : ''; // Ajuste aquí
                            echo '
                    <div class="col-md-6 mb-2">
                        <div class="form-check">
                            <input type="checkbox" name="especialidad[]" value="' . $row['id'] . '" ' . $checked . ' class="form-check-input">
                            <label class="form-check-label">' . $row['especi'] . '</label>
                        </div>
                    </div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción Personal:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción"
                    required></textarea>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">TELÉFONO:</label>
                <input class="form-control" id="telefono" name="telefono" type="number" placeholder="TELÉFONO" required>
            </div>
            <div class="mb-3">
                <label for="disponibilidad" class="form-label">Disponibilidad:</label>
                <select class="form-select" id="disponibilidad" name="disponibilidad" required>
                    <option value="24">24 horas</option>
                    <option value="48">48 horas</option>
                    <option value="72">72 horas</option>
                    <option value="96">96 horas</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor:</label>
                <input class="form-control" id="valor" name="valor" type="text" placeholder="Valor"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 && event.charCode != 46;" required>
            </div>
            <div class="mb-3">
                <label for="mail" class="form-label">Correo electrónico:</label>
                <input class="form-control" id="mail" name="mail" type="text" placeholder="Correo electrónico"
                    pattern="[^@\s]+@[^@\s]+\.[^@\s]+"
                    title="Por favor, introduce una dirección de correo electrónico válida" required>
            </div>
            <div class="mb-3">
                <label for="whatsapp" class="form-label">WhatsApp:</label>
                <input class="form-control" id="whatsapp" name="whatsapp" type="text" placeholder="WhatsApp"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>
            <div class="mb-3">
                <label for="instagram" class="form-label">Instagram:</label>
                <input class="form-control" id="instagram" name="instagram" type="text" placeholder="Instagram">
            </div>
            <div class="d-grid">
                <button class="btn btn-warning text-white" type="submit"
                    style="background-color: #c1c700; margin-bottom: 1rem;">Enviar</button>
            </div>
        </form>
    </div>


    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <a href="../index.php" class="logo">
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
                <a href="https://www.instagram.com/terapia.libre/?igsh=MTE3cnBnYXB5OHVwZA%3D%3D"><i
                        class="bi bi-instagram"></i> Instagram</a>
            </div>



        </div>

        <h1 class="credit">created by <span>WorldSoftSystem</span> | all rights reserved. </h1>

    </section>

    <!-- footer section ends -->



</body>

</html>