<?php
// Incluir archivo de conexión a la base de datos
include '../services/conexion.php';

// Obtener el ID del medicamento desde la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verificar si el formulario se ha enviado para realizar la actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar y sanitizar los datos del formulario
    $nombre = $_POST['nombre'];
    $presentacion = $_POST['presentacion'];
    $marca = $_POST['marca'];
    $fecha_vencimiento = $_POST['fecha_vencimiento'];
    $categoria = $_POST['categoria'];
    $laboratorio = $_POST['laboratorio'];
    $lote = $_POST['lote'];
    $proveedor = $_POST['proveedor'];

    // Actualizar el medicamento en la base de datos
    $update_query = "UPDATE medicamentos SET 
                        nombre = ?, 
                        presentacion = ?, 
                        marca = ?, 
                        fecha_vencimiento = ?, 
                        categoria = ?, 
                        laboratorio = ?, 
                        lote = ?, 
                        proveedor = ? 
                     WHERE id = ?";
    
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param('ssssssssi', $nombre, $presentacion, $marca, $fecha_vencimiento, $categoria, $laboratorio, $lote, $proveedor, $id);
    
    if ($stmt->execute()) {
        // Redirigir a la lista de medicamentos después de una actualización exitosa
        header("Location: ../view/almacen_medicamentos.php");
        exit;
    } else {
        echo "Error al actualizar el medicamento.";
    }
}

// Consulta para obtener los datos del medicamento a editar
$query = "SELECT * FROM medicamentos WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();
$medicamento = $resultado->fetch_assoc();

// Consulta para obtener solo los nombres de las categorías
$query = "SELECT * FROM categoria";
$resultado = $conn->query($query);
$categorias = "";
while ($fila = $resultado->fetch_assoc()) {
    $cat_s = "";
    if ($fila['id']==$medicamento['categoria']) {
        $cat_s = " selected";
    }
    $categorias .= "<option value='".$fila['id']."' ".$cat_s." >".$fila['nombre']."</option>";
}

// Consulta para obtener solo los nombres de los laboratorios
$query = "SELECT * FROM laboratorio";
$resultado = $conn->query($query);
$laboratorios = "";
while ($fila = $resultado->fetch_assoc()) {
    $cat_s = "";
    if ($fila['id']==$medicamento['laboratorio']) {
        $cat_s = " selected";
    }
    $laboratorios .= "<option value='".$fila['id']."' ".$cat_s." >".$fila['nombre']."</option>";
}

// Consulta para obtener solo los nombres de los proveedores
$query = "SELECT * FROM proveedores";
$resultado = $conn->query($query);
$proveedores = "";
while ($fila = $resultado->fetch_assoc()) {
    $cat_s = "";
    if ($fila['id']==$medicamento['proveedor']) {
        $cat_s = " selected";
    }
    $proveedores .= "<option value='".$fila['id']."' ".$cat_s." >".$fila['razon_social']."</option>";
}

// Cerrar conexión a la base de datos
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


        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">Editar Medicamento <i
                                        class="fas fa-capsules"></i></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Editar Medicamento</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Editar Medicamento</h4>
                                    <form class="needs-validation" novalidate action="" method="POST">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="validationTooltip01">Nombre</label>
                                                <input type="text" class="form-control" id="validationTooltip01" name="nombre" value="<?php echo htmlspecialchars($medicamento['nombre']); ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip02">Presentación</label>
                                                <input type="text" class="form-control" id="validationTooltip02" name="presentacion" value="<?php echo htmlspecialchars($medicamento['presentacion']); ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip03">Marca</label>
                                                <input type="text" class="form-control" id="validationTooltip03" name="marca" value="<?php echo htmlspecialchars($medicamento['marca']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                                                <input type="date" name="fecha_vencimiento" class="form-control" id="fecha_vencimiento" value="<?php echo htmlspecialchars($medicamento['fecha_vencimiento']); ?>" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="categoria">Categoría</label>
                                                <select class="form-control mb-3" name="categoria" required>
                                                    <option disabled selected>Seleccionar</option>
                                                    <?php echo $categorias; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="laboratorio">Laboratorio</label>
                                                <select class="form-control mb-3" name="laboratorio" required>
                                                    <option disabled selected>Seleccionar</option>
                                                    <?php echo $laboratorios; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="lote">Lote</label>
                                                <input type="text" class="form-control" id="lote" name="lote" value="<?php echo htmlspecialchars($medicamento['lote']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="proveedor">Proveedor</label>
                                                <select class="form-control mb-3" name="proveedor" required>
                                                    <option disabled selected>Seleccionar</option>
                                                    <?php echo $proveedores; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                                        <a href="../view/almacen_medicamentos.php" class="btn btn-danger waves-effect waves-light">Cancelar</a>
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

        <!-- Overlay-->
        <div class="menu-overlay"></div>


        <!-- jQuery  -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/metismenu.min.js"></script>
        <script src="../assets/js/waves.js"></script>
        <script src="../assets/js/simplebar.min.js"></script>

        <!-- third party js -->
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../plugins/datatables/dataTables.bootstrap4.js"></script>
        <script src="../plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>
        <script src="../plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="../plugins/datatables/buttons.html5.min.js"></script>
        <script src="../plugins/datatables/buttons.flash.min.js"></script>
        <script src="../plugins/datatables/buttons.print.min.js"></script>
        <script src="../plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="../plugins/datatables/dataTables.select.min.js"></script>
        <script src="../plugins/datatables/pdfmake.min.js"></script>
        <script src="../plugins/datatables/vfs_fonts.js"></script>
        <!-- third party js ends -->

        <!-- Datatables init -->
        <script src="../assets/pages/datatables-demo.js"></script>


        <!-- Sparkline Js-->
        <script src="../plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- Chart Js-->
        <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>

        <!-- Chart Custom Js-->
        <script src="../assets/pages/knob-chart-demo.js"></script>


        <!-- Morris Js-->
        <script src="../plugins/morris-js/morris.min.js"></script>

        <!-- Raphael Js-->
        <script src="../plugins/raphael/raphael.min.js"></script>

        <!-- Custom Js -->
        <script src="../assets/pages/dashboard-demo.js"></script>

        <!-- App js -->
        <script src="../assets/js/theme.js"></script>

</body>

</html>