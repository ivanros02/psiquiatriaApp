<?php
require_once '../../php/conexion.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $input = json_decode(file_get_contents('php://input'), true);
    if ($input === null) {
        http_response_code(400);
        echo json_encode(["error" => "Datos JSON inválidos."]);
        exit;
    }

    $fechaDesde = $input['fechaDesde'] ?? null;
    $fechaHasta = $input['fechaHasta'] ?? null;

    if (!$fechaDesde || !$fechaHasta) {
        http_response_code(400);
        echo json_encode(["error" => "Las fechas son obligatorias."]);
        exit;
    }

    $fechaDesde .= ' 00:00:00';
    $fechaHasta .= ' 23:59:59';

    if ($conexion->connect_error) {
        http_response_code(500);
        echo json_encode(["error" => "Error en la conexión con la base de datos."]);
        exit;
    }

    $query = "SELECT 
        d.psychologist_id,
        p.nombre,
        COUNT(CASE WHEN d.pago_nacional = 1 THEN 1 ELSE NULL END) AS cantidad_nacional,
        SUM(CASE WHEN d.pago_nacional = 1 THEN p.valor ELSE 0 END) AS total_nacional,
        COUNT(CASE WHEN d.pago_nacional = 0 THEN 1 ELSE NULL END) AS cantidad_internacional,
        SUM(CASE WHEN d.pago_nacional = 0 THEN p.valor_internacional ELSE 0 END) AS total_internacional
    FROM datos_usuario d
    INNER JOIN presentaciones p ON d.psychologist_id = p.id_usuario
    WHERE d.fecha BETWEEN ? AND ?
    GROUP BY d.psychologist_id";

    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $conexion->error]);
        exit;
    }

    $stmt->bind_param('ss', $fechaDesde, $fechaHasta);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $row['cantidad_nacional'] = (int) $row['cantidad_nacional'];
        $row['total_nacional'] = (float) $row['total_nacional'];
        $row['cantidad_internacional'] = (int) $row['cantidad_internacional'];
        $row['total_internacional'] = (float) $row['total_internacional'];
        $data[] = $row;
    }

    echo json_encode($data);

    $stmt->close();
    $conexion->close();
}
?>