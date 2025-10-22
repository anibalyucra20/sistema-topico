<?php
// Incluye el archivo de conexión a la base de datos
include '../services/conexion.php'; // Asegúrate de que esta ruta sea correcta

// Verifica si se proporciona un ID de usuario válido a través de la URL
if (isset($_GET['id'])) {
    $usuario_id = $_GET['id']; // ID del usuario a eliminar

    // Prepara la consulta para verificar si existe el usuario con ese ID
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se encontró el usuario
    if ($result->num_rows > 0) {
        // Elimina el usuario de la base de datos
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $usuario_id);
        if ($stmt->execute()) {
            // Eliminación exitosa, redirige a la página de usuarios
            header("Location: ../view/usuarios.php?message=El usuario ha sido eliminado exitosamente.");
            exit();
        } else {
            // Manejar el caso en que la eliminación no fue exitosa
            header("Location: ../view/usuarios.php?error=Error al eliminar el usuario.");
            exit();
        }
    } else {
        // Manejar el caso en que no se encontró un usuario con el ID proporcionado
        header("Location: ../view/usuarios.php?error=ID de usuario no válido.");
        exit();
    }

    $stmt->close();
} else {
    // Manejar el caso en que no se proporcionó un ID válido
    header("Location: ../view/usuarios.php?error=ID no válido.");
    exit();
}

// Cierra la conexión a la base de datos
$conn->close();
?>
