<?php
include '../services/conexion.php'; // Conexión a la BD

// Verificar si se recibió el ID del paciente para editar
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Consulta para obtener los datos del paciente
    $sql = "SELECT * FROM pacientes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $paciente = $result->fetch_assoc(); // Guardar los datos del paciente
    } else {
        echo "Paciente no encontrado.";
        exit;
    }
} else {
    echo "ID de paciente no proporcionado.";
    exit;
}

// Procesar la edición cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni'];
    $nombres = $_POST['nombres'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $programa_estudios = $_POST['programa_estudios'];

    // Actualizar datos del paciente
    $sql_update = "UPDATE pacientes SET dni = ?, nombres = ?, apellido_paterno = ?, apellido_materno = ?, programa_estudios = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssi", $dni, $nombres, $apellido_paterno, $apellido_materno, $programa_estudios, $id);

    if ($stmt_update->execute()) {
        header("Location: ../view/pacientes.php"); // Redirigir de vuelta a pacientes.php después de la edición
        exit;
    } else {
        echo "Error al actualizar el paciente.";
    }
}

$conn->close(); // Cerrar conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php'; ?>

<body>

    <div id="layout-wrapper">
        <div class="header-border"></div>

        <?php include '../layout/header.php'; ?>
        <?php include '../layout/sidebar.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">Editar Paciente <i class="fas fa-user-edit"></i></h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <form action="editar_pacientes.php?id=<?php echo $id; ?>" method="POST">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltipUsername">DNI</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="validationTooltipUsername" name="dni" value="<?php echo htmlspecialchars($paciente['dni']); ?>"
                                                        aria-describedby="validationTooltipUsernamePrepend" required maxlength="8" pattern="\d{8}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                    <div class="invalid-tooltip">
                                                        Inserte un número de DNI válido
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="nombres">Nombres</label>
                                                <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo htmlspecialchars($paciente['nombres']); ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="apellidoPaterno">Apellido Paterno</label>
                                                <input type="text" class="form-control" id="apellidoPaterno" name="apellido_paterno" value="<?php echo htmlspecialchars($paciente['apellido_paterno']); ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="apellidoMaterno">Apellido Materno</label>
                                                <input type="text" class="form-control" id="apellidoMaterno" name="apellido_materno" value="<?php echo htmlspecialchars($paciente['apellido_materno']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-5 mb-3">
                                                <label for="programa_estudios">Programa de Estudios</label>
                                                <select class="form-control mb-3" name="programa_estudios" required>
                                                    <option disabled selected>Seleccionar</option>
                                                    <option value="Enfermería Técnica" <?php echo ($paciente['programa_estudios'] == 'Enfermería Técnica') ? 'selected' : ''; ?>>Enfermería Técnica</option>
                                                    <option value="Diseño y Programación Web" <?php echo ($paciente['programa_estudios'] == 'Diseño y Programación Web') ? 'selected' : ''; ?>>Diseño y Programación Web</option>
                                                    <option value="Industrias Alimentarias" <?php echo ($paciente['programa_estudios'] == 'Industrias Alimentarias') ? 'selected' : ''; ?>>Industrias Alimentarias</option>
                                                    <option value="Producción Agropecuaria" <?php echo ($paciente['programa_estudios'] == 'Producción Agropecuaria') ? 'selected' : ''; ?>>Producción Agropecuaria</option>
                                                    <option value="Mecatrónica Automotriz" <?php echo ($paciente['programa_estudios'] == 'Mecatrónica Automotriz') ? 'selected' : ''; ?>>Mecatrónica Automotriz</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a href="../view/pacientes.php" class="btn btn-secondary">Cancelar</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include '../layout/footer.php'; ?>
        </div>

        <div class="menu-overlay"></div>

        <!-- App js -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/metismenu.min.js"></script>
        <script src="../assets/js/waves.js"></script>
        <script src="../assets/js/simplebar.min.js"></script>
        <script src="../assets/js/theme.js"></script>

</body>

</html>