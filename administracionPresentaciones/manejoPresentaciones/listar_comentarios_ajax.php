<?php
// Incluir el archivo de conexión
require_once '../../php/conexion.php';

// Obtener parámetros de paginación
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$registrosPorPagina = isset($_GET['registrosPorPagina']) ? (int)$_GET['registrosPorPagina'] : 10;
$offset = ($pagina - 1) * $registrosPorPagina;

// Contar el total de registros
$totalQuery = $conexion->query("SELECT COUNT(*) as total FROM comentarios_presentaciones");
$totalRegistros = $totalQuery->fetch_assoc()['total'];

// Obtener los registros con límite y desplazamiento
$query = "
    SELECT c.*, p.nombre AS nombre_prof 
    FROM comentarios_presentaciones c
    LEFT JOIN presentaciones p ON p.id = c.profesional_id
    ORDER BY p.nombre
    LIMIT $registrosPorPagina OFFSET $offset";
$result = $conexion->query($query);

// Generar la tabla
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

// Generar la paginación
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

echo '<nav>';
echo '<ul class="pagination">';
for ($i = 1; $i <= $totalPaginas; $i++) {
    echo "<li class='page-item " . ($i == $pagina ? 'active' : '') . "'>
            <a class='page-link' href='#' onclick='cargarComentarios($i)'>$i</a>
          </li>";
}
echo '</ul>';
echo '</nav>';

$conexion->close();
?>
