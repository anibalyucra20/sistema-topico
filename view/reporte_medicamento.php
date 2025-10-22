<?php
// Incluir archivo de conexión a la base de datos
include '../services/conexion.php';

// Consulta para obtener todos los medicamentos
$query = "SELECT id, nombre, presentacion, marca, cantidad_ingreso, fecha_vencimiento, categoria, laboratorio, lote, fecha_ingreso, proveedor FROM medicamentos";

$resultado = $conn->query($query);
?>


<!DOCTYPE html>
<html lang="en">

<?php include '../layout/head.php'; ?>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
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
                                <h4 class="mb-0 font-size-18">Reporte de Medicamento</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Reporte de Medicamento</li>
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
                                        <strong>IMPORTANTE:</strong> Para exportar el reporte correctamente presionar en el botón <strong>PDF</strong>
                                    </p>
                                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Insumo</th>
                                                <th>Entrada</th>
                                                <th>Salida</th>
                                                <th>Stock Final</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Consulta SQL que obtiene los datos necesarios
                                            $sql = "
    SELECT 
        m.id, 
        m.nombre, 
        m.cantidad_ingreso, 
        COALESCE(SUM(ai.cantidad), 0) AS salida
    FROM 
        medicamentos m
    LEFT JOIN 
        atencion_insumos ai 
        ON ai.insumo_medico = m.id AND ai.tipo = 1
    WHERE 
        m.estado = 1
    GROUP BY 
        m.id, m.nombre, m.cantidad_ingreso
    ORDER BY 
        m.nombre ASC
";


                                            $resultado = $conn->query($sql); // Ejecutar la consulta

                                            if ($resultado->num_rows > 0):
                                                while ($medicamento = $resultado->fetch_assoc()):
                                                    $stock_final = $medicamento['cantidad_ingreso'] - $medicamento['salida']; // Cálculo del stock final
                                            ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($medicamento['id']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['nombre']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['cantidad_ingreso']); ?></td>
                                                        <td><?php echo htmlspecialchars($medicamento['salida']); ?></td>
                                                        <td><?php echo htmlspecialchars($stock_final); ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No se encontraron medicamentos en el almacén.</td>
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
        <!-- end main content-->

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

    <!-- App js -->
    <script src="../assets/js/theme.js"></script>

</body>

</html>