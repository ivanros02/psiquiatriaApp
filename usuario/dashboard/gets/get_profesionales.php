<?php
include '../../../php/conexion.php';

$usuario_id = $_POST['usuario_id'];

// Obtener los profesionales relacionados con el usuario
$query = "SELECT p.id, p.nombre, p.mail, p.rutaImagen FROM presentaciones p
          INNER JOIN usuario_profesional up ON p.id = up.profesional_id
          WHERE up.usuario_id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<div class="row g-4">'; // Contenedor para las tarjetas
    while ($row = $result->fetch_assoc()) {
        echo '<div class="col-12 col-md-6 col-lg-4">'; // Ajusta el tamaño de las tarjetas
        echo '<div class="card shadow-sm">';
        echo '<div class="card-body d-flex flex-column align-items-center text-center">';
        echo '<img src="../' . htmlspecialchars($row['rutaImagen']) . '" alt="" style="width: 80px; height: 80px" class="rounded-circle mb-3"/>';
        echo '<h5 class="card-title fw-bold" style="font-size: 1.7rem;">' . htmlspecialchars($row['nombre']) . '</h5>';
        echo '<p class="card-text text-muted" style="font-size: 1.4rem;">' . htmlspecialchars($row['mail']) . '</p>';
        echo '<p class="fw-normal" style="font-size: 1.4rem;">Profesional</p>';
        echo '<p class="text-muted" style="font-size: 1.4rem;">Relación establecida</p>';
        echo '<div class="mt-auto">'; // Espacio para botones al final
        echo '<button class="btn btn-link btn-sm btn-rounded btn-chat" data-id="' . $row['id'] . '">';
        echo '<i class="fas fa-comments fa-2x"></i>';
        echo '</button>';
        echo '<button class="btn btn-link btn-sm btn-rounded btn-video" data-id="' . $row['id'] . '">';
        echo '<i class="fas fa-video fa-2x"></i>';
        echo '</button>';
        echo '</div>'; // Cierre del mt-auto
        echo '</div>'; // Cierre del card-body
        echo '</div>'; // Cierre de la card
        echo '</div>'; // Cierre del col
    }
    echo '</div>'; // Cierre del row
} else {
    echo '<div class="alert alert-warning text-center" role="alert">No hay profesionales relacionados.</div>';
}

$stmt->close();
$conexion->close();
?>
