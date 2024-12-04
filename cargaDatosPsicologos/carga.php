<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terapia Libre</title>

    <!--icono pestana-->
    <link rel="icon" href="../img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="../img/Logo_transparente.png" type="image/x-icon">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- custom css file link  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="../estilos/headerYFooter.css">
    <link rel="stylesheet" href="../estilos/style.css">

    <!-- Agrega los scripts de Bootstrap y jQuery justo antes de cerrar la etiqueta </body> -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- custom js file link  -->
    <script src="js/cargaProfes.js"></script>
</head>

<body>

    <!-- header section starts  -->

    <header class="d-flex justify-content-between align-items-center bg-white shadow fixed-top p-2">
        <a href="../index.php" class="logo d-flex align-items-center text-decoration-none text-success mx-auto mx-lg-0">
            <img src="../img/Logo_transparente.png" alt="Logo de Terapia Libre" class="mr-2" style="width: 7rem;">
            <span>Terapia Libre</span>
        </a>

        <nav class="navbar navbar-expand-lg navbar-light d-none d-lg-flex">
            <ul class="navbar-nav ml-auto">
                <li><a href="../index.php">Inicio</a></li>
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
            </ul>
        </nav>

    </header>

    <!-- header section ends -->

    <div class="container mt-4 py-5">

        <h1 class="text-center mb-4 display-4" style="color: #c1c700; margin-top:10rem !important;">Panel de Carga</h1>

        <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
            <div class="alert <?php echo $_GET['status'] === 'success' ? 'alert-success' : 'alert-danger'; ?> text-center">
                <?php echo $_GET['message']; ?>
            </div>
        <?php endif; ?>

        <form action="procesar_carga.php" method="POST" enctype="multipart/form-data"
            class="mx-auto shadow p-5 rounded-4 fs-3" style="max-width: 700px; background-color: #ffffff;">


            <div class="mb-4">
                <label for="imagen" class="form-label fw-bold">Foto de Perfil:</label>
                <input class="form-control form-control-lg" id="imagen" name="imagen" type="file" required>
            </div>

            <div class="mb-4">
                <label for="nombre" class="form-label fw-bold">Nombre:</label>
                <input class="form-control form-control-lg" id="nombre" name="nombre" type="text" placeholder="Nombre"
                    required>
            </div>

            <div class="mb-4">
                <label for="titulo" class="form-label fw-bold">Título:</label>
                <input class="form-control form-control-lg" id="titulo" name="titulo" type="text" placeholder="Título"
                    required>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="matricula" class="form-label fw-bold">Matrícula Nacional:</label>
                    <input class="form-control form-control-lg" id="matricula" name="matricula" type="number"
                        placeholder="Matrícula" required>
                </div>
                <div class="col-md-6">
                    <label for="matriculaP" class="form-label fw-bold">Matrícula Provincial:</label>
                    <input class="form-control form-control-lg" id="matriculaP" name="matriculaP" type="number"
                        placeholder="Matrícula Provincial" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="especialidad" class="form-label fw-bold">Especialidades:</label>
                <div class="row g-2" id="especialidades-container">
                    <!-- Carga dinámica de especialidades -->
                </div>
            </div>

            <div class="mb-4">
                <label for="descripcion" class="form-label fw-bold">Descripción Personal:</label>
                <textarea class="form-control form-control-lg" id="descripcion" name="descripcion"
                    placeholder="Descripción" rows="4" required></textarea>
            </div>

            <div class="mb-4">
                <label for="telefono" class="form-label fw-bold">Teléfono:</label>
                <input class="form-control form-control-lg" id="telefono" name="telefono" type="number"
                    placeholder="Teléfono" required>
            </div>

            <div class="mb-4">
                <label for="disponibilidad" class="form-label fw-bold">Disponibilidad:</label>
                <select class="form-select form-select-lg" id="disponibilidad" name="disponibilidad" required>
                    <option value="24">24 horas</option>
                    <option value="48">48 horas</option>
                    <option value="72">72 horas</option>
                    <option value="96">96 horas</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="valor" class="form-label fw-bold">Valor Nacional:</label>
                <input class="form-control form-control-lg" id="valor" name="valor" type="text" placeholder="Valor"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 && event.charCode != 46;" required>
            </div>

            <div class="mb-4">
                <label for="valor_internacional" class="form-label fw-bold">Valor Internacional:</label>
                <input class="form-control form-control-lg" id="valor_internacional" name="valor_internacional" type="text"
                    placeholder="Valor en Pesos"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57 && event.charCode != 46;" required>
            </div>


            <div class="mb-4">
                <label for="mail" class="form-label fw-bold">Correo electrónico:</label>
                <input class="form-control form-control-lg" id="mail" name="mail" type="email"
                    placeholder="Correo electrónico" pattern="[^@\s]+@[^@\s]+\.[^@\s]+"
                    title="Introduce una dirección de correo válida" required>
            </div>

            <div class="mb-4">
                <label for="whatsapp" class="form-label fw-bold">WhatsApp:</label>
                <input class="form-control form-control-lg" id="whatsapp" name="whatsapp" type="text"
                    placeholder="WhatsApp" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>

            <div class="mb-4">
                <label for="instagram" class="form-label fw-bold">Instagram:</label>
                <input class="form-control form-control-lg" id="instagram" name="instagram" type="text"
                    placeholder="Instagram">
            </div>

            <div class="d-grid">
                <button class="btn btn-lg btn-warning text-white fw-bold" type="submit"
                    style="background-color: #c1c700;">Enviar</button>
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