<?php
require_once '../services/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insumo_id = $_POST['insumo_id'];

    // Eliminar insumo de la base de datos
    $sql = "DELETE FROM atencion_insumos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $insumo_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
