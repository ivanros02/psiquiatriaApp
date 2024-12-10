<?php
// Incluir la conexión a la base de datos
include '../../php/conexion.php';  // Asegúrate de tener una conexión a la base de datos

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Buscar el token en la base de datos
    $query = "SELECT * FROM usuarios WHERE reset_token = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar si el token ha expirado
        $expiry = $user['reset_token_expiry'];
        if (strtotime($expiry) > time()) {
            // El token es válido, mostrar formulario para cambiar la contraseña
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $password = $_POST['password'];
                $password_hash = password_hash($password, PASSWORD_BCRYPT);  // Hashear la nueva contraseña

                // Actualizar la contraseña en la base de datos
                $query = "UPDATE usuarios SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?";
                $stmt = $conexion->prepare($query);
                $stmt->bind_param("ss", $password_hash, $token);
                $stmt->execute();

                echo "Tu contraseña ha sido actualizada.";
            }
        } else {
            echo "El enlace de recuperación ha expirado.";
        }
    } else {
        echo "El token no es válido.";
    }
} else {
    echo "No se proporcionó un token válido.";
}
?>

<!-- Formulario para cambiar la contraseña -->
<form method="POST">
    <div>
        <label for="password">Nueva Contraseña:</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <button type="submit">Cambiar Contraseña</button>
    </div>
</form>
