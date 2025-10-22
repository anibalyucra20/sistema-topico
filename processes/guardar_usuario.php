<?php
include '../services/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $dni = $_POST['dni'];
    $nombres = $_POST['nombres'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $password = $_POST['password'];
    $cargo = $_POST['cargo'];
    $estado = $_POST['estado'];

    $contrasenia_encriptado = password_hash($password,PASSWORD_DEFAULT);
//en caso ya exista el usuario
    $buscar = "SELECT * FROM usuarios WHERE dni='$dni'";
    if (mysqli_num_rows($conn->query($buscar))) {
        echo "<script>window.alert('Error, usuario ya registrado'); window.history.back();</script>";
    } else {
        // Preparar la consulta SQL
        $sql = "INSERT INTO usuarios (dni, nombres, apellido_paterno, apellido_materno, password, cargo, estado) VALUES ('$dni', '$nombres', '$apellido_paterno', '$apellido_materno', '$contrasenia_encriptado', '$cargo', '$estado')";

        // Ejecutar la consulta
        if ($conn->query($sql)) {
            // Redirigir a usuarios.php si se agregó correctamente
            header("Location: ../view/usuarios.php");
            exit();
        } else {
            //echo "Error al agregar el usuario: " . $conn->error;
            echo "<script>window.alert('Error, no se pudo registrar usuario'); window.history.back();</script>";
        }
    }
}

$conn->close();
