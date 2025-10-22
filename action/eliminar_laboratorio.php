<?php
// Incluye el archivo de conexión a la base de datos
include '../services/conexion.php'; // Asegúrate de que esta ruta sea correcta

// Verifica si se proporciona un ID válido a través de la URL
if (isset($_GET['id'])) {
    $laboratorio_id = $_GET['id'];  // ID del laboratorio a eliminar

    // Prepara la consulta para verificar si existe el laboratorio con ese ID
    $stmt = $conn->prepare("SELECT * FROM laboratorio WHERE id = ?");
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $laboratorio_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se encontró el laboratorio
    if ($result->num_rows > 0) {
        // Elimina el laboratorio de la base de datos
        $stmt = $conn->prepare("DELETE FROM laboratorio WHERE id = ?");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $laboratorio_id);
        if ($stmt->execute()) {
            // Eliminación exitosa, redirige a la página de laboratorios
            header("Location: ../view/laboratorios.php?message=El laboratorio ha sido eliminado exitosamente.");
            exit();
        } else {
            // Manejar el caso en que la eliminación no fue exitosa
            header("Location: ../view/laboratorios.php?error=Error al eliminar el laboratorio.");
            exit();
        }
    } else {
        // Manejar el caso en que no se encontró un laboratorio con el ID proporcionado
        header("Location: ../view/laboratorios.php?error=ID de laboratorio no válido.");
        exit();
    }

    $stmt->close();
} else {
    // Manejar el caso en que no se proporcionó un ID válido
    header("Location: ../view/laboratorios.php?error=ID no válido.");
    exit();
}

// Cierra la conexión a la base de datos
$conn->close();
?>
