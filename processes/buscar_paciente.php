<?php
include '../services/conexion.php'; // Asegúrate de que la conexión a la base de datos esté correcta

// Verificar si el parámetro 'dni' se ha enviado
if (isset($_GET['dni'])) {
    $dni = $_GET['dni'];

    // Validar que el DNI es un número válido
    if (!preg_match('/^\d{8}$/', $dni)) {
        echo json_encode(['success' => false, 'message' => 'DNI no válido']);
        exit;
    }

    // Preparar la consulta para buscar al paciente
    $query = "SELECT * FROM pacientes WHERE dni = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $dni); // 's' significa que estamos pasando una cadena (string)

    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si encontramos el paciente
    if ($result->num_rows > 0) {
        // Si se encuentra el paciente, devolver los datos en formato JSON
        $patient = $result->fetch_assoc();
        echo json_encode([
            'success' => true,
            'id' => $patient['id'],
            'nombres' => $patient['nombres'],
            'apellido_paterno' => $patient['apellido_paterno'],
            'apellido_materno' => $patient['apellido_materno'],
            'programa_estudios' => $patient['programa_estudios']
        ]);
    } else {
        // Si no se encuentra el paciente
        echo json_encode(['success' => false, 'message' => 'Paciente no encontrado']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'DNI no proporcionado']);
}
?>
