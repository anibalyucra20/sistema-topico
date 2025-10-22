<?php
// Incluir archivo de conexión a la base de datos
include '../services/conexion.php';

// Consulta para obtener todos los medicamentos
$query = "SELECT * FROM mmedicamentos WHERE estado=1";
$resultado = $conn->query($query);

// Suponiendo que el ID de la atención ya está disponible (si no, recuperarlo de la URL o sesión)
/*if (isset($_GET['id'])) {
    $id_atencion = $_GET['id'];

    // Consulta para obtener los insumos asociados a esta atención
    $query_insumos = "SELECT * FROM atencion_insumos WHERE atencion_id = $id_atencion";
    $result_insumos = mysqli_query($conn, $query_insumos);

    // Recorremos los insumos y verificamos si hay coincidencias con medicamentos
    if ($result_insumos && mysqli_num_rows($result_insumos) > 0) {
        while ($insumo = mysqli_fetch_assoc($result_insumos)) {
            // Obtenemos el código de insumo y la cantidad
            $codigo_insumo = $insumo['codigo'];
            $cantidad_insumo = $insumo['cantidad'];

            // Consulta para obtener los detalles del medicamento
            $query_medicamento = "SELECT * FROM mmedicamentos WHERE codigo = '$codigo_insumo'";
            $result_medicamento = mysqli_query($conn, $query_medicamento);

            // Verificamos si hay coincidencia con algún medicamento
            if ($result_medicamento && mysqli_num_rows($result_medicamento) > 0) {
                // Si hay coincidencia, obtener la cantidad disponible
                $medicamento = mysqli_fetch_assoc($result_medicamento);
                $cantidad_ingreso = $medicamento['cantidad_ingreso'];

                // Realizamos la operación (resta)
                $cantidad_restante = $cantidad_ingreso - $cantidad_insumo;

                // Mostrar el resultado en la línea de código
                echo "<td>" . $cantidad_restante . "</td>";
            } else {
                // Si no se encuentra el medicamento, mostramos la cantidad de ingreso
                echo "<td>" . $insumo['cantidad'] . "</td>";
            }
        }
    } else {
        echo "<td>No se encontraron insumos</td>";
    }
} else {
    echo "<td>Error: No se proporcionó el ID de atención</td>";
}*/
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
                                <h4 class="mb-0 font-size-18">Almacén de Materiales Médicos <i class="fas fa-briefcase-medical"></i></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Almacén de Materiales Médicos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-subtitle mb-4">
                                        <a href="../add_data/new_mmedico.php" class="btn btn-primary waves-effect waves-light">Nuevo Material Médico</a>
                                    </p>

                                    <table id="state-saving-datatable" class="table activate-select dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>COD</th>
                                                <th>Nombre</th>
                                                <th>Presentación</th>
                                                <th>Categoría</th>
                                                <th>Marca</th>
                                                <th>Stock</th>
                                                <th>Vencimiento</th>
                                                <th>Laboratorio</th>
                                                <th>Lote</th>
                                                <th>Proveedor</th>
                                                <th>Cant.Ingreso</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            

                                            if ($resultado->num_rows > 0):
                                                while ($fila = $resultado->fetch_assoc()):
                                                    // Cálculo del stock: entrada - salida
                                            ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($fila['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($fila['nombre']); ?></td>
                                                        <td><?php echo htmlspecialchars($fila['presentacion']); ?></td>
                                                        <td><?php
                                                        $id_cat = $fila['categoria'];
                                                        $sql = "SELECT * FROM categoria WHERE id=$id_cat";
                                                        $res_cat = $conn->query($sql);
                                                        $catt = $res_cat->fetch_assoc();
                                                        echo htmlspecialchars($catt['nombre']); ?></td>
                                                        <td><?php echo htmlspecialchars($fila['marca']); ?></td>
                                                        <td class="text-right"><?php echo htmlspecialchars($fila['stock']); ?></td> <!-- Aquí mostramos el stock -->
                                                        <td><?php echo htmlspecialchars($fila['fecha_vencimiento']); ?></td>
                                                        <td><?php 
                                                        $id_lab = $fila['laboratorio'];
                                                        $sql = "SELECT * FROM laboratorio WHERE id=$id_lab";
                                                        $res_lab = $conn->query($sql);
                                                        $labb = $res_lab->fetch_assoc();
                                                        echo htmlspecialchars($labb['nombre']); ?></td>
                                                        <td><?php echo htmlspecialchars($fila['lote']); ?></td>
                                                        <td><?php 
                                                        $id_prov = $fila['proveedor'];
                                                        $sql = "SELECT * FROM proveedores WHERE id=$id_prov";
                                                        $res_prov = $conn->query($sql);
                                                        $provv = $res_prov->fetch_assoc();
                                                        echo htmlspecialchars($provv['razon_social']); ?></td>
                                                        <td><?php echo htmlspecialchars($fila['cantidad_ingreso']); ?></td>
                                                        <td>
                                                            <a class="btn btn-sm btn-info" href="../action/editar_mmedico.php?id=<?php echo urlencode($fila['id']); ?>" title="Editar"><i class="fa fa-pen"></i></a>
                                                            <a class="btn btn-sm btn-danger" href="../action/eliminar_mmedico.php?id=<?php echo urlencode($fila['id']); ?>" title="Dar de Baja"><i class="fa fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="12" class="text-center">No se encontraron medicamentos en el almacén.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>


                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                        </div><!-- end col-->
                    </div>
                    <!-- end row-->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include '../layout/footer.php'; ?>

        </div>
        <!-- END layout-wrapper -->

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
        <script src="../assets/js/theme.js"></script>

</body>

</html>

<?php
// Cerrar conexión a la base de datos
$conn->close();
?>