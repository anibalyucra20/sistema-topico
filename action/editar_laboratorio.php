<?php
// Conexión a la base de datos
include '../services/conexion.php';

if (isset($_GET['id'])) {
    $laboratorio_id = $_GET['id'];

    // Consultar los datos del laboratorio
    $sql = "SELECT * FROM laboratorio WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $laboratorio_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si el laboratorio existe
    if ($resultado->num_rows === 1) {
        $laboratorio = $resultado->fetch_assoc();
    } else {
        // Redirigir si no existe el laboratorio
        header("Location: ../view/laboratorios.php");
        exit;
    }

    // Procesar la actualización al enviar el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];

        // Actualizar los datos del laboratorio
        $sql_update = "UPDATE laboratorio SET nombre = ?, tipo = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssi", $nombre, $tipo, $laboratorio_id);

        if ($stmt_update->execute()) {
            // Redirigir a laboratorios.php después de la actualización
            header("Location: ../view/laboratorios.php");
            exit;
        } else {
            echo "Error al actualizar el laboratorio.";
        }
    }
} else {
    header("Location: ../view/laboratorios.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php'; ?>
<body>

    <div id="../layout-wrapper">
        <div class="header-border"></div>
        <?php include '../layout/header.php'; ?>
        <?php include '../layout/sidebar.php'; ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">Editar Laboratorio <i class="fas fa-bong"></i></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Laboratorios</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Editar Laboratorio</h4>
                                    <form class="needs-validation" action="editar_laboratorio.php?id=<?php echo $laboratorio_id; ?>" method="POST" novalidate>
                                        <div class="form-row">
                                            <div class="col-md-5 mb-3">
                                                <label for="validationTooltip01">Nombre</label>
                                                <input type="text" class="form-control" id="validationTooltip01" name="nombre" value="<?php echo htmlspecialchars($laboratorio['nombre']); ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip03">Tipo</label>
                                                <select class="form-control mb-3" name="tipo" required>
                                                    <option disabled>Seleccionar</option>
                                                    <option value="Comercial" <?php if ($laboratorio['tipo'] == 1) echo 'selected'; ?>>Comercial</option>
                                                    <option value="Genérico" <?php if ($laboratorio['tipo'] == 2) echo 'selected'; ?>>Genérico</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                                        <a href="../view/laboratorios.php" class="btn btn-danger waves-effect waves-light">Cancelar</a>
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

        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/metismenu.min.js"></script>
        <script src="../assets/js/waves.js"></script>
        <script src="../assets/js/simplebar.min.js"></script>
        <script src="../assets/js/theme.js"></script>
    </div>
</body>
</html>
