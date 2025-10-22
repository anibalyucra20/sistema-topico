<?php
// Conectar a la base de datos
include '../services/conexion.php';

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $buscar = "SELECT * FROM laboratorio WHERE nombre='$nombre'";
    if (mysqli_num_rows($conn->query($buscar))) {
        echo "<script>window.alert('Error, laboratorio ya registrado'); window.history.back();</script>";
    } else {
        // Preparar y ejecutar la consulta para insertar el nuevo laboratorio
        $sql = "INSERT INTO laboratorio (nombre, tipo) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $nombre, $tipo);

        if ($stmt->execute()) {
            // Redirigir a la página de laboratorios después de guardar
            header("Location: ../view/laboratorios.php");
            exit;
        } else {
            echo "Error al guardar el laboratorio: " . $stmt->error;
        }

        // Cerrar la declaración
        $stmt->close();
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
