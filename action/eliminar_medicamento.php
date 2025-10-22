<?php
// Incluye el archivo de conexión a la base de datos
include '../services/conexion.php'; // Asegúrate de que esta ruta sea correcta

// Verifica si se proporciona un ID válido a través de la URL
if (isset($_GET['id'])) {
    $medicamento_id = $_GET['id'];  // ID del medicamento a eliminar

    // Prepara la consulta para verificar si existe el medicamento con ese ID
    $stmt = $conn->prepare("SELECT * FROM medicamentos WHERE id = ?");
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $medicamento_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se encontró el medicamento
    if ($result->num_rows > 0) {
        // Elimina el medicamento de la base de datos
        $stmt = $conn->prepare("UPDATE medicamentos SET estado=0 WHERE id = ?");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("i", $medicamento_id);
        if ($stmt->execute()) {
            // Eliminación exitosa, redirige a la página de medicamentos
            echo "<script>
            alert('El medicamento se dio de baja exitosamente.');
            window.history.back();</script>";
            //header("Location: ../view/almacen_medicamentos.php?message=El medicamento ha sido eliminado exitosamente.");
            exit();
        } else {
            // Manejar el caso en que la eliminación no fue exitosa
            echo "<script>
            alert('error=Error al dar de baja el medicamento.');
            window.history.back();</script>";
            //header("Location: ../view/almacen_medicamentos.php?error=Error al eliminar el medicamento.");
            exit();
        }
    } else {
        // Manejar el caso en que no se encontró un medicamento con el ID proporcionado
        echo "<script>
            alert('ID de medicamento no válido.');
            window.history.back();</script>";
        //header("Location: ../view/almacen_medicamentos.php?error=ID de medicamento no válido.");
        exit();
    }

    $stmt->close();
} else {
    // Manejar el caso en que no se proporcionó un ID válido
    echo "<script>
            alert('ID de medicamento no válido.');
            window.history.back();</script>";
    //header("Location: ../view/almacen_medicamentos.php?error=ID no válido.");
    exit();
}

// Cierra la conexión a la base de datos
$conn->close();
