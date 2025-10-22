<?php
// Conectar a la base de datos
include '../services/conexion.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: ../view/proveedores.php");
    exit;
}

// Obtener los datos del proveedor
$sql = "SELECT * FROM proveedores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$proveedor = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $ruc = $_POST['ruc'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $razon_social = $_POST['razon_social'];
    $direccion = $_POST['direccion'];
    $provincia = $_POST['provincia'];
    $distrito = $_POST['distrito'];

    // Actualizar los datos en la base de datos
    $update_sql = "UPDATE proveedores SET ruc = ?, telefono = ?, correo = ?, razon_social = ?, direccion = ?, provincia = ?, distrito = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sssssssi", $ruc, $telefono, $correo, $razon_social, $direccion, $provincia, $distrito, $id);
    $update_stmt->execute();
    $update_stmt->close();

    // Redirigir a la lista de proveedores después de guardar los cambios
    header("Location: ../view/proveedores.php");
    exit;
}
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
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">Editar Proveedor <i class="fas fa-truck"></i></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Editar Proveedor</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Actualizar Proveedor</h4>
                                    <p class="card-subtitle mb-4">Modifique los datos y guarde los cambios.</p>
                                    <form class="needs-validation" action="" method="POST" novalidate>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="rucInput">RUC</label>
                                                <input type="text" class="form-control" id="rucInput" name="ruc" value="<?= htmlspecialchars($proveedor['ruc']) ?>" required maxlength="11" pattern="^(10|20)\d{9}$" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 2 && !/^(10|20)/.test(this.value)) this.value = this.value.slice(0, 2);">
                                                <div class="invalid-tooltip">Inserte un RUC válido</div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="telefono">Teléfono</label>
                                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($proveedor['telefono']) ?>" required maxlength="9" pattern="^9\d{7}$" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 1 && this.value[0] !== '9') this.value = this.value.slice(0, 1);">
                                                <div class="invalid-tooltip">Inserte un número de teléfono válido</div>
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <label for="correo">Correo</label>
                                                <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($proveedor['correo']) ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-11 mb-3">
                                                <label for="razonSocial">Razón Social</label>
                                                <input type="text" class="form-control" id="razonSocial" name="razon_social" value="<?= htmlspecialchars($proveedor['razon_social']) ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="direccion">Dirección</label>
                                                <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($proveedor['direccion']) ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="provincia">Provincia</label>
                                                <input type="text" class="form-control" id="provincia" name="provincia" value="<?= htmlspecialchars($proveedor['provincia']) ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="distrito">Distrito</label>
                                                <input type="text" class="form-control" id="distrito" name="distrito" value="<?= htmlspecialchars($proveedor['distrito']) ?>" required>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                                        <a href="../view/proveedores.php" class="btn btn-secondary waves-effect waves-light">Cancelar</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../layout/footer.php'; ?>
        </div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/metismenu.min.js"></script>
    <script src="../assets/js/waves.js"></script>
    <script src="../assets/js/simplebar.min.js"></script>
    <script src="../assets/js/theme.js"></script>
</body>
</html>
