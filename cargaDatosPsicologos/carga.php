<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de carga</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!--icono pestana-->
    <link rel="icon" href="../img/Logo_transparente.png" type="image/x-icon">
    <link rel="shortcut icon" href="../img/Logo_transparente.png" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat&display=swap">
    <style>
        /* Aplicar la fuente Montserrat a todo el documento */
        body {
            font-family: 'Montserrat', sans-serif !important;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
        <div
            class="hidden sm:block fixed top-6 left-6 sm:top-8 sm:left-8 md:top-10 md:left-10 lg:top-12 lg:left-12 xl:top-14 xl:left-14 z-50">
            <!-- Logo -->
            <img class="w-12 sm:w-16 md:w-20 lg:w-24 xl:w-28 h-auto" src="../img/Logo_transparente.png"
                alt="Logo de tu página">
            <!-- Texto -->
            <p class="text-sm text-gray-600">Terapia Libre</p>
        </div>



        <h1 class="text-2xl font-bold mb-4 text-center" style="color: #c1c700;">Panel de carga</h1>
        <?php if (isset ($_GET['status']) && isset ($_GET['message'])): ?>
            <div
                class="<?php echo $_GET['status'] === 'success' ? 'bg-green-200' : 'bg-red-200'; ?> text-green-700 text-lg p-3 mb-4 rounded-md text-center">
                <?php echo $_GET['message']; ?>
            </div>
        <?php endif; ?>
        <form action="procesar_carga.php" method="POST" enctype="multipart/form-data" class="w-full max-w-lg mx-auto">
            <div class="flex flex-wrap -mx-3 mb-6">

                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="imagen">Seleccionar archivo de imagen:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="imagen" name="imagen" type="file">
                </div>

                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="nombre">Nombre:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="nombre" name="nombre" type="text" placeholder="Nombre">
                </div>

                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="titulo">Título:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="titulo" name="titulo" type="text" placeholder="Título">
                </div>

                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="matricula">Matrícula:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="matricula" name="matricula" type="number" placeholder="Matrícula">
                </div>



                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="matricula">Matrícula Provincial:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="matricula" name="matriculaP" type="number" placeholder="Matrícula">
                </div>



                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="especialidad">Especialidades:</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php
                        // Conexión a la base de datos y consulta de las especialidades
                        include '../php/conexion.php';
                        $query = "SELECT * FROM especialidades";
                        $result = $conexion->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $checked = (isset ($_POST['especialidad']) && in_array($row['id'], $_POST['especialidad'])) ? 'checked' : ''; // Ajuste aquí
                                echo '
                <label class="inline-flex items-center">
                    <input type="checkbox" name="especialidad[]" value="' . $row['id'] . '" ' . $checked . ' class="form-checkbox h-5 w-5 text-gray-600">
                    <span class="ml-2 text-gray-700">' . $row['especi'] . '</span>
                </label>';
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="w-full px-3 mb-6 md:mb-0 mt-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="descripcion">Descripción Personal:</label>
                    <textarea
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="descripcion" name="descripcion" placeholder="Descripción"></textarea>
                </div>

                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="matricula">TELÉFONO:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="matricula" name="telefono" type="number" placeholder="TELÉFONO">
                </div>

                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="disponibilidad">Disponibilidad:</label>
                    <select
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="disponibilidad" name="disponibilidad">
                        <option value="24">24 horas</option>
                        <option value="48">48 horas</option>
                        <option value="72">72 horas</option>
                        <option value="96">96 horas</option>
                    </select>
                </div>


                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="valor">Valor:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="valor" name="valor" type="text" placeholder="Valor"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57 && event.charCode != 46;">
                </div>

                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="mail">Correo
                        electrónico:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="mail" name="mail" type="text" placeholder="Correo electrónico"
                        pattern="[^@\s]+@[^@\s]+\.[^@\s]+"
                        title="Por favor, introduce una dirección de correo electrónico válida">
                </div>


                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="whatsapp">WhatsApp:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="whatsapp" name="whatsapp" type="text" placeholder="WhatsApp"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>





                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="instagram">Instagram:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="instagram" name="instagram" type="text" placeholder="Instagram">
                </div>

            </div>
            <div class="flex items-center justify-center mt-6">
                <button
                    class="hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit" style="background-color: #c1c700;">Enviar</button>
            </div>
        </form>
    </div>


</body>

</html>