<?php
// Conexión a la base de datos
include '../services/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $ruc = $_POST['ruc'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $razon_social = $_POST['razon_social'];
    $direccion = $_POST['direccion'];
    $provincia = $_POST['provincia'];
    $distrito = $_POST['distrito'];
    $buscar = "SELECT * FROM proveedores WHERE ruc='$ruc'";
    if (mysqli_num_rows($conn->query($buscar))) {
        echo "<script>window.alert('Error, proveedor ya registrado'); window.history.back();</script>";
    } else {
        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO proveedores (ruc, telefono, correo, razon_social, direccion, provincia, distrito) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Preparar y ejecutar la sentencia
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssssss", $ruc, $telefono, $correo, $razon_social, $direccion, $provincia, $distrito);

            if ($stmt->execute()) {
                // Redirigir con mensaje de éxito
                header("Location: ../view/proveedores.php");
                exit();
            } else {
                echo "Error al agregar el proveedor: " . $stmt->error;
            }

            // Cerrar la sentencia
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conn->error;
        }
    }
}

// Cerrar la conexión
$conn->close();
