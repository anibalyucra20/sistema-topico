<?php
include '../services/conexion.php';

if (isset($_GET['id']) && isset($_GET['nuevo_estado'])) {
    $id = $_GET['id'];
    $nuevo_estado = $_GET['nuevo_estado'];

    // Preparar la consulta para actualizar el estado del usuario
    $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Enlazar los parámetros y ejecutar la consulta
        $stmt->bind_param("si", $nuevo_estado, $id);

        if ($stmt->execute()) {
            // Redirigir de vuelta a usuarios.php después de actualizar
            header("Location: ../view/usuarios.php");
            exit();
        } else {
            echo "Error al actualizar el estado: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }
} else {
    echo "ID o nuevo estado no especificado.";
}

$conn->close();
?>
