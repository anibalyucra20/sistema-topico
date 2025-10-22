<?php
// Conexión a la base de datos
require_once '../services/conexion.php';

// Verificar si los datos han sido enviados correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos enviados
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $procedimiento = isset($_POST['procedimiento']) ? $_POST['procedimiento'] : null;
    $encargado = isset($_POST['encargado']) ? $_POST['encargado'] : null;
    $fecha_atencion = isset($_POST['fecha_atencion']) ? $_POST['fecha_atencion'] : null;

    // Validar si los campos necesarios están presentes
    if (!$id || !$procedimiento || !$encargado || !$fecha_atencion) {
        echo json_encode(['success' => false, 'message' => 'Faltan campos obligatorios']);
        exit;
    }

    // Insertar los datos de la atención
    try {
        $sql = "INSERT INTO atenciones (paciente, fecha_atencion, procedimiento, encargado) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $id, $fecha_atencion, $procedimiento, $encargado);
        $stmt->execute();

        // Obtener el ID de la atención insertada
        $id_atencion = $stmt->insert_id;

        // Responder con éxito y el ID de la atención
        echo json_encode(['success' => true, 'id_atencion' => $id_atencion]);

    } catch (Exception $e) {
        // Manejo de errores de la base de datos
        echo json_encode(['success' => false, 'message' => 'Error al procesar los datos: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido']);
}
?>
