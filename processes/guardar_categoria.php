<?php
// Incluir archivo de conexión a la base de datos
include '../services/conexion.php';

// Verificar que los datos fueron enviados a través de POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario y sanitizarlos
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $tipo = isset($_POST['tipo']) ? trim($_POST['tipo']) : '';

    $buscar = "SELECT * FROM categoria WHERE nombre='$nombre'";
    if (mysqli_num_rows($conn->query($buscar))) {
        echo "<script>window.alert('Error, categoria ya registrado'); window.history.back();</script>";
    } else {
        // Verificar que los campos requeridos no estén vacíos
        if (!empty($nombre) && !empty($tipo)) {
            // Preparar la consulta SQL para insertar los datos
            $query = "INSERT INTO categoria (nombre, tipo) VALUES (?, ?)";

            // Preparar la declaración
            if ($stmt = $conn->prepare($query)) {
                // Vincular los parámetros
                $stmt->bind_param("ss", $nombre, $tipo);

                // Ejecutar la declaración y verificar si fue exitosa
                if ($stmt->execute()) {
                    // Redirigir a la página de categorías con un mensaje de éxito
                    header("Location: ../view/categorias.php");
                    exit();
                } else {
                    // En caso de error en la ejecución
                    echo "Error al guardar la categoría: " . $stmt->error;
                }

                // Cerrar la declaración
                $stmt->close();
            } else {
                // En caso de error en la preparación de la consulta
                echo "Error al preparar la consulta: " . $conn->error;
            }
        } else {
            // Redirigir de nuevo al formulario con un mensaje de error si faltan campos
            header("Location: ../add_data/new_categoria.php?mensaje=error_campos");
            exit();
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
