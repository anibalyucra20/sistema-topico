<?php
// Incluye el archivo de conexión a la base de datos
include '../services/conexion.php'; // Asegúrate de que esta ruta sea correcta

// Verifica si se proporciona un ID de proveedor válido a través de la URL
if (isset($_GET['id'])) {
    $proveedor_id = $_GET['id']; // ID del proveedor a eliminar

    // Prepara la consulta para verificar si existe el proveedor con ese ID
    $stmt = $conn->prepare("SELECT * FROM proveedores WHERE id = ?");
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $proveedor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se encontró el proveedor
    if ($result->num_rows > 0) {
        // Elimina el proveedor de la base de datos
        $stmt = $conn->prepare("DELETE FROM proveedores WHERE id = ?");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $proveedor_id);
        if ($stmt->execute()) {
            // Eliminación exitosa, redirige a la página de proveedores
            header("Location: ../view/proveedores.php?message=El proveedor ha sido eliminado exitosamente.");
            exit();
        } else {
            // Manejar el caso en que la eliminación no fue exitosa
            header("Location: ../view/proveedores.php?error=Error al eliminar el proveedor.");
            exit();
        }
    } else {
        // Manejar el caso en que no se encontró un proveedor con el ID proporcionado
        header("Location: ../view/proveedores.php?error=ID de proveedor no válido.");
        exit();
    }

    $stmt->close();
} else {
    // Manejar el caso en que no se proporcionó un ID válido
    header("Location: ../view/proveedores.php?error=ID no válido.");
    exit();
}

// Cierra la conexión a la base de datos
$conn->close();
?>
