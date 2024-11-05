<?php
// Incluir el archivo de conexión
require_once '../../php/conexion.php';

$result = $conexion->query("SELECT c.*,p.nombre AS nombre_prof FROM comentarios_presentaciones c LEFT JOIN presentaciones p ON p.id = c.profesional_id ORDER BY p.nombre");
echo '<table class="table table-bordered">';
echo '<thead>
        <tr>
            <th>ID</th>
            <th>Profesional</th>
            <th>Comentario</th>
            <th>Nom. Coment.</th>
            <th>Acciones</th>
        </tr>
      </thead>';
echo '<tbody>';

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['profesional_id']}</td>
            <td>{$row['nombre_prof']}</td>
            <td>{$row['comentario']}</td>
            <td>{$row['nombre']}</td>
            <td>
                <button class='btn btn-warning btn-sm edit-btn' data-id='{$row['id']}' data-comentario='{$row['comentario']}' data-nombre='{$row['nombre']}'>Editar</button>
                <button class='btn btn-danger btn-sm delete-btn' data-id='{$row['id']}'>Eliminar</button>
            </td>
          </tr>";
}

echo '</tbody>';
echo '</table>';
$conexion->close();
?>
