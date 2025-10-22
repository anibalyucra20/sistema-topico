<?php
// Incluye el archivo de conexión a la base de datos
include '../services/conexion.php'; // Asegúrate de que esta ruta sea correcta

// Verifica si se proporciona un ID de paciente válido a través de la URL
if (isset($_GET['id'])) {
    $paciente_id = $_GET['id'];

    // Preparar la consulta para seleccionar al paciente
    $stmt = $conn->prepare("SELECT * FROM pacientes WHERE id = ?");
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $paciente_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se encontró el paciente
    if ($result->num_rows > 0) {
        // Elimina al paciente de la base de datos
        $stmt = $conn->prepare("DELETE FROM pacientes WHERE id = ?");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $paciente_id);
        if ($stmt->execute()) {
            // Eliminación exitosa, redirige a la página de pacientes
            header("Location: ../view/pacientes.php?message=El paciente ha sido eliminado exitosamente.");
            exit();
        } else {
            // Manejar el caso en que la eliminación no fue exitosa
            header("Location: ../view/pacientes.php?error=Error al eliminar el paciente.");
            exit();
        }
    } else {
        // Manejar el caso en que no se encontró un paciente con el ID proporcionado
        header("Location: ../view/pacientes.php?error=ID de paciente no válido.");
        exit();
    }

    $stmt->close();
} else {
    // Manejar el caso en que no se proporcionó un ID de paciente válido
    header("Location: ../view/pacientes.php?error=ID de paciente no válido.");
    exit();
}

// Cierra la conexión a la base de datos
$conn->close();
?>
