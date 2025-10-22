<?php
require_once '../services/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $insumo_medico = $_POST['insumo_medico'];
    $cantidad = $_POST['cantidad'];

    // Insertar insumo en la base de datos
    $sql = "INSERT INTO atencion_insumos (codigo, insumo_medico, cantidad) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $codigo, $insumo_medico, $cantidad);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
