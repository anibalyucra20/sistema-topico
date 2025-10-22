<?php
// Conexión a la base de datos y recuperación de datos
include '../services/conexion.php'; // Archivo de conexión a la base de datos

// Verificar si se envió el formulario para actualizar el usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos enviados por el formulario
    $id = $_POST['id'];
    $dni = $_POST['dni'];
    $nombres = $_POST['nombres'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $password = $_POST['password'];
    $cargo = $_POST['cargo'];
    $estado = $_POST['estado'];

    if ($password != "") {
        $password_encrypt = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE usuarios SET dni = '$dni', nombres = '$nombres', apellido_paterno = '$apellido_paterno', 
              apellido_materno = '$apellido_materno', password = '$password_encrypt', cargo = '$cargo', estado = '$estado' 
              WHERE id = $id";
    }else {
        $query = "UPDATE usuarios SET dni = '$dni', nombres = '$nombres', apellido_paterno = '$apellido_paterno', 
              apellido_materno = '$apellido_materno', cargo = '$cargo', estado = '$estado' 
              WHERE id = $id";
    }

    // Preparar y ejecutar la consulta de actualización
    
    
    if ($conn->query($query) === TRUE) {
        // Redirigir a la página de usuarios después de la actualización
        header("Location: ../view/usuarios.php");
        exit();
    } else {
        echo "Error al actualizar el usuario: " . $conn->error;
    }
}

// Verificar que el id del usuario está presente en la URL y es un número
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar los datos del usuario por su ID
    $query = "SELECT * FROM usuarios WHERE id = $id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
} else {
    echo "ID de usuario no válido.";
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<?php include '../layout/head.php'; ?>

<body>

    <!-- Begin page -->
    <div id="../layout-wrapper">
        <div class="header-border"></div>

        <?php include '../layout/header.php'; ?>
        <?php include '../layout/sidebar.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Título de la página -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">Editar Usuario <i class="fas fa-user-edit"></i></h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Editar Usuario</h4>
                                    <p class="card-subtitle mb-4">El DNI es el identificador de usuario en el sistema.</p>

                                    <!-- Formulario de edición de usuario -->
                                    <form class="needs-validation" novalidate method="POST">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['id']); ?>">

                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="dni">DNI/Usuario</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="dni" name="dni" value="<?php echo htmlspecialchars($usuario['dni']); ?>" required maxlength="8" pattern="\d{8}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                    <div class="invalid-tooltip">
                                                        Inserte un número de DNI válido.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="nombres">Nombres</label>
                                                <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo htmlspecialchars($usuario['nombres']); ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="apellidoPaterno">Apellido Paterno</label>
                                                <input type="text" class="form-control" id="apellidoPaterno" name="apellido_paterno" value="<?php echo htmlspecialchars($usuario['apellido_paterno']); ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="apellidoMaterno">Apellido Materno</label>
                                                <input type="text" class="form-control" id="apellidoMaterno" name="apellido_materno" value="<?php echo htmlspecialchars($usuario['apellido_materno']); ?>" required>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="password">Contraseña</label>
                                                <input type="text" class="form-control" id="password" name="password" value="" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="cargo">Cargo</label>
                                                <select class="form-control mb-3" name="cargo" required>
                                                    <option disabled>Seleccionar</option>
                                                    <option value="Administrador" <?php echo $usuario['cargo'] == 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
                                                    <option value="Atencion" <?php echo $usuario['cargo'] == 'Atencion' ? 'selected' : ''; ?>>Atencion</option>
                                                    <option value="Almacen" <?php echo $usuario['cargo'] == 'Almacen' ? 'selected' : ''; ?>>Almacen</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="estado">Estado</label>
                                                <select class="form-control mb-3" name="estado" required>
                                                    <option value="Activo" <?php echo $usuario['estado'] == 'Activo' ? 'selected' : ''; ?>>Activo</option>
                                                    <option value="Inactivo" <?php echo $usuario['estado'] == 'Inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                                                </select>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar Cambios</button>
                                        <a href="../view/usuarios.php" class="btn btn-secondary waves-effect">Cancelar</a>
                                    </form>
                                </div> <!-- end card-body-->
                            </div> <!-- end card -->
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include '../layout/footer.php'; ?>
        </div>
        <!-- END ../layout-wrapper -->

        <div class="menu-overlay"></div>

        <!-- jQuery y otros scripts -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/metismenu.min.js"></script>
        <script src="../assets/js/waves.js"></script>
        <script src="../assets/js/simplebar.min.js"></script>
        <script src="../assets/js/theme.js"></script>
</body>

</html>
