<!DOCTYPE html>
<html>

<head>
    <title>Terapia Libre</title>
    <link rel="stylesheet" href="../estilos/carga.css">
</head>

<body>

    <form action="procesar_carga.php" method="post" enctype="multipart/form-data">
        <h2>Terapia Libre</h2>
        <p>Formulario de Profesionales</p>

        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="titulo">Título:</label><br>
        <input type="text" id="titulo" name="titulo" required><br><br>

        <label for="matricula">Matrícula Nacional:</label><br>
        <input type="number" id="matricula" name="matricula" required><br><br>

        <label for="matriculaP">Matrícula Provincial:</label><br>
        <input type="number" id="matriculaP" name="matriculaP" required><br><br>

        <label for="especialidad">Especialidad:</label><br>
        <input type="text" id="especialidad" name="especialidad" required><br><br>

        <label for="descripcion">Descripción:</label><br>
        <textarea id="descripcion" name="descripcion" rows="4" required></textarea><br><br>

        <label for="telefono">Teléfono:</label><br>
        <input type="tel" id="telefono" name="telefono" required><br><br>

        <label for="disponibilidad">Disponibilidad:</label><br>
        <select id="disponibilidad" name="disponibilidad" required>
            <option value="24">24 horas</option>
            <option value="48">48 horas</option>
            <option value="72">72 horas</option>
            <option value="96">96 horas</option>
        </select><br><br>

        <label for="valor">Valor:</label><br>
        <input type="number" id="valor" name="valor" required><br><br>

        <label for="mail">Email:</label><br>
        <input type="email" id="mail" name="mail" required><br><br>

        <label for="whatsapp">WhatsApp(11****):</label><br>
        <input type="tel" id="whatsapp" name="whatsapp" ><br><br>

        <label for="instagram">Instagram(Sin '@'):</label><br>
        <input type="text" id="instagram" name="instagram" ><br><br>

        <label for="imagen">Seleccione una imagen:</label><br>
        <input type="file" id="imagen" name="imagen" accept="image/*" required><br><br>

        <input type="submit" value="Enviar">
    </form>

</body>

</html>