<?php
// Incluye el archivo de conexión a la base de datos
include '../services/conexion.php'; // Asegúrate de que esta ruta sea correcta

// Verifica si se proporciona un ID válido a través de la URL
if (isset($_GET['id'])) {
    $categoria_id = $_GET['id'];  // ID de la categoría a eliminar

    // Prepara la consulta para verificar si existe la categoría con ese ID
    $stmt = $conn->prepare("SELECT * FROM categoria WHERE id = ?");
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se encontró la categoría
    if ($result->num_rows > 0) {
        // Elimina la categoría de la base de datos
        $stmt = $conn->prepare("DELETE FROM categoria WHERE id = ?");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $categoria_id);
        if ($stmt->execute()) {
            // Eliminación exitosa, redirige a la página de categorías
            header("Location: ../view/categorias.php?message=La categoría ha sido eliminada exitosamente.");
            exit();
        } else {
            // Manejar el caso en que la eliminación no fue exitosa
            header("Location: ../view/categorias.php?error=Error al eliminar la categoría.");
            exit();
        }
    } else {
        // Manejar el caso en que no se encontró una categoría con el ID proporcionado
        header("Location: ../view/categorias.php?error=ID de categoría no válido.");
        exit();
    }

    $stmt->close();
} else {
    // Manejar el caso en que no se proporcionó un ID válido
    header("Location: ../view/categorias.php?error=ID no válido.");
    exit();
}

// Cierra la conexión a la base de datos
$conn->close();
?>
