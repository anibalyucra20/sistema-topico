<?php
header('Content-Type: application/json; charset=utf-8');

// DEBUG: logea errores a un archivo (asegúrate de crear la carpeta logs con permisos 755/775)
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', __DIR__ . '/../logs/php-error.log');

$debug = [];

try {
    // Limpia cualquier salida previa por BOM o espacios de includes
    if (ob_get_length()) ob_end_clean();

    $debug[] = 'start';

    // Incluye la conexión
    $connPath = realpath(__DIR__ . '/../services/conexion.php');
    $debug[] = ['connPath' => $connPath ?: 'NO_REALPATH'];
    if (!$connPath || !file_exists($connPath)) {
        echo json_encode(['success' => false, 'message' => 'No se encuentra conexion.php', 'debug' => $debug], JSON_UNESCAPED_UNICODE);
        exit;
    }
    include $connPath;
    $debug[] = 'included_conexion';

    // Verifica que $conn exista y sea mysqli
    if (!isset($conn)) {
        echo json_encode(['success' => false, 'message' => 'La variable $conn no está definida en conexion.php', 'debug' => $debug], JSON_UNESCAPED_UNICODE);
        exit;
    }
    if (!($conn instanceof mysqli)) {
        // Si es PDO, también avisa
        $debug[] = ['conn_type' => is_object($conn) ? get_class($conn) : gettype($conn)];
        echo json_encode(['success' => false, 'message' => 'La conexión no es mysqli (¿es PDO?)', 'debug' => $debug], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($conn->connect_errno) {
        echo json_encode(['success' => false, 'message' => 'Error de conexión: '.$conn->connect_error, 'debug' => $debug], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $debug[] = ['host_info' => mysqli_get_host_info($conn)];

    // Parámetro DNI
    if (!isset($_GET['dni'])) {
        echo json_encode(['success' => false, 'message' => 'DNI no proporcionado', 'debug' => $debug], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $dni = $_GET['dni'];
    if (!preg_match('/^\d{8}$/', $dni)) {
        echo json_encode(['success' => false, 'message' => 'DNI no válido', 'debug' => $debug], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Consulta (sin get_result para evitar problema mysqlnd)
    $sql = "SELECT id, nombres, apellido_paterno, apellido_materno, programa_estudios FROM pacientes WHERE dni = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Error prepare: '.$conn->error, 'debug' => $debug], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $stmt->bind_param('s', $dni);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error execute: '.$stmt->error, 'debug' => $debug], JSON_UNESCAPED_UNICODE);
        $stmt->close();
        exit;
    }

    $stmt->store_result();
    $debug[] = ['rows' => $stmt->num_rows];

    if ($stmt->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Paciente no encontrado', 'debug' => $debug], JSON_UNESCAPED_UNICODE);
        $stmt->close();
        exit;
    }

    $stmt->bind_result($id, $nombres, $ap, $am, $pe);
    $stmt->fetch();
    $stmt->close();

    echo json_encode([
        'success' => true,
        'id' => $id,
        'nombres' => $nombres,
        'apellido_paterno' => $ap,
        'apellido_materno' => $am,
        'programa_estudios' => $pe,
        'debug' => $debug
    ], JSON_UNESCAPED_UNICODE);
    $conn->close();
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'message' => 'EXCEPTION: '.$e->getMessage(), 'debug' => $debug], JSON_UNESCAPED_UNICODE);
}
