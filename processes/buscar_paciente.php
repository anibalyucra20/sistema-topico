<?php
header('Content-Type: application/json; charset=utf-8');
// Función para limpiar recursivamente a UTF-8
function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $k => $v) { $mixed[$k] = utf8ize($v); }
        return $mixed;
    } elseif (is_string($mixed)) {
        // Convierte a UTF-8 solo si no lo es
        return mb_convert_encoding($mixed, 'UTF-8', 'UTF-8, ISO-8859-1, ISO-8859-15, CP1252');
    }
    return $mixed;
}

include '../services/conexion.php'; // Debe crear $conn = new mysqli(...)

// Verificar si el parámetro 'dni' se ha enviado
if (!isset($_GET['dni'])) {
    echo json_encode(['success' => false, 'message' => 'DNI no proporcionado']);
    exit;
}

$dni = $_GET['dni'];

// Validar que el DNI es un número válido
if (!preg_match('/^\d{8}$/', $dni)) {
    echo json_encode(['success' => false, 'message' => 'DNI no válido']);
    exit;
}

// Selecciona columnas explícitas y en orden fijo
$sql = "SELECT id, nombres, apellido_paterno, apellido_materno, programa_estudios 
        FROM pacientes 
        WHERE dni = ?";

if (!$stmt = $conn->prepare($sql)) {
    echo json_encode(['success' => false, 'message' => 'Error de preparación: '.$conn->error]);
    exit;
}

$stmt->bind_param("s", $dni);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error al ejecutar: '.$stmt->error]);
    $stmt->close();
    exit;
}

// ¡Sin get_result()! Compatibilidad con servidores sin mysqlnd
$stmt->store_result();
if ($stmt->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Paciente no encontrado']);
    $stmt->close();
    exit;
}

$stmt->bind_result($id, $nombres, $apellido_paterno, $apellido_materno, $programa_estudios);
$stmt->fetch();

echo json_encode([
    'success' => true,
    'id' => $id,
    'nombres' => $nombres,
    'apellido_paterno' => $apellido_paterno,
    'apellido_materno' => $apellido_materno,
    'programa_estudios' => $programa_estudios
]);

$stmt->close();
$conn->close();
