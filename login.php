<?php
// Iniciar la sesión al comienzo del archivo
session_start();

// Incluir el archivo de conexión a la base de datos
include 'services/conexion.php';

// Variable para almacenar el mensaje de error
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el DNI y la password del formulario
    $dni = $_POST['dni'];
    $password = $_POST['password'];

    // Preparar y ejecutar la consulta SQL, SE UTILIZA BINARY PARA RECONOCER MAYUSCULAS Y MINUSCULAS
    $sql = "SELECT * FROM usuarios WHERE dni = ? AND estado = 'Activo'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró un usuario con los datos proporcionados
    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            
            // Almacenar el nombre y el cargo del usuario en una variable de sesión
            $_SESSION['usuarioid'] = $row['id']; // Asegúrate de que 'nombres' corresponde a la columna correcta de tu base de datos
            $_SESSION['usuario'] = $row['nombres']; // Asegúrate de que 'nombres' corresponde a la columna correcta de tu base de datos
            $_SESSION['cargo'] = $row['cargo']; // Almacenar el cargo

            // Redirigir a la página de dashboard
            header("Location: view/dashboard.php");
            exit;
        } else {
            // Asignar el mensaje de error
            $error = "Contraseña incorrecta";
        }
    } else {
        // Asignar el mensaje de error
        $error = "Usuario inactivo o credenciales incorrectas";
    }

    $stmt->close();
    $conn->close();
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SISTOPI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Sistema de Tópico" name="description" />


    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/Logo_Sistopi.png">

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/theme.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center min-vh-100">
                        <div class="w-100 d-block bg-white shadow-lg rounded my-5">
                            <div class="row">
                                <div class="col-lg-5 d-none d-lg-block bg-login rounded-left"></div>
                                <div class="col-lg-7">
                                    <div class="p-5">
                                        <div class="text-center mb-5">
                                            <a href="index.php" class="text-dark font-size-22 font-family-secondary">
                                                <img width="60px" src="assets/images/Logo_Sistopi.png" alt="Logo_Sistopi"> <b>SISTOPI</b>
                                            </a>
                                        </div>
                                        <h1 class="h5 mb-1">¡Bienvenido al sistema de tópico!</h1>
                                        <p class="text-muted mb-4">Ingrese su usuario y password para acceder al panel de administración.</p>

                                        <?php if (!empty($error)): ?>
                                            <div class="alert alert-danger">
                                                <?= $error; ?>
                                            </div>
                                        <?php endif; ?>

                                        <form class="user" method="post">
                                            <div class="form-group">
                                                <input type="text" name="dni" class="form-control form-control-user" id="exampleInputEmail" placeholder="Usuario"
                                                    pattern="\d{8}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);"
                                                    maxlength="8">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Contraseña">
                                            </div>
                                            <button type="submit" class="btn btn-secondary btn-block waves-effect waves-light">Iniciar Sesión</button>
                                        </form>
                                    </div> <!-- end .padding-5 -->
                                </div> <!-- end col -->
                            </div> <!-- end row -->
                        </div> <!-- end .w-100 -->
                    </div> <!-- end .d-flex -->
                </div> <!-- end col-->
            </div> <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/metismenu.min.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/simplebar.min.js"></script>

    <!-- App js -->
    <script src="assets/js/theme.js"></script>

</body>

</html>