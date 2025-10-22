<?php
// Incluir archivo de conexión a la base de datos
include '../services/conexion.php';

// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los datos del formulario
    $nombre = $_POST['nombre'];
    $presentacion = $_POST['presentacion'];
    $marca = $_POST['marca'];
    $cantidad = $_POST['cantidad'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $categoria = $_POST['categoria'];
    $laboratorio = $_POST['laboratorio'];
    $lote = $_POST['lote'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $proveedor = $_POST['proveedor'];

    // Limpiar los datos para prevenir inyecciones SQL
    $nombre = $conn->real_escape_string($nombre);
    $presentacion = $conn->real_escape_string($presentacion);
    $marca = $conn->real_escape_string($marca);
    $cantidad = $conn->real_escape_string($cantidad);
    $fecha_vencimiento = $conn->real_escape_string($fecha_vencimiento);
    $categoria = $conn->real_escape_string($categoria);
    $laboratorio = $conn->real_escape_string($laboratorio);
    $lote = $conn->real_escape_string($lote);
    $fecha_ingreso = $conn->real_escape_string($fecha_ingreso);
    $proveedor = $conn->real_escape_string($proveedor);

    // Consulta para insertar el nuevo material médico
    $query = "INSERT INTO mmedicamentos (nombre, presentacion, marca, cantidad_ingreso, stock, fecha_vencimiento, categoria, laboratorio, lote, fecha_ingreso, proveedor)
              VALUES ('$nombre', '$presentacion', '$marca', '$cantidad', '$cantidad', '$fecha_vencimiento', '$categoria', '$laboratorio', '$lote', '$fecha_ingreso', '$proveedor')";

    // Ejecutar la consulta
    if ($conn->query($query) === TRUE) {
        // Redirigir a la página de almacenamiento si se inserta correctamente
        header("Location: ../view/almacen_mmedico.php");
        exit();
    } else {
        // Manejar el error en caso de que la inserción falle
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
