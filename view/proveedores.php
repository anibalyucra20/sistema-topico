<?php
// Conexión a la base de datos
include '../services/conexion.php';

// Consultar todos los proveedores
$query = "SELECT * FROM proveedores";
$result = $conn->query($query);

if (!$result) {
    echo "Error en la consulta: " . $conn->error;
    exit();
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
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">Proveedores <i class="fas fa-truck"></i></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Proveedores</li>
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
                                        <a href="../add_data/new_proveedor.php" class="btn btn-primary waves-effect waves-light">Nuevo Proveedor</a>
                                    </p>

                                    <table id="state-saving-datatable" class="table activate-select dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>RUC</th>
                                                <th>Razón Social</th>
                                                <th>Dirección</th>
                                                <th>Correo</th>
                                                <th>Teléfono</th>
                                                <th>Provincia</th>
                                                <th>Distrito</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($proveedor = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($proveedor['ruc']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($proveedor['razon_social']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($proveedor['direccion']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($proveedor['correo']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($proveedor['telefono']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($proveedor['provincia']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($proveedor['distrito']) . "</td>";
                                                    echo "<td>";
                                                    echo "<a class='btn btn-sm btn-info' href='../action/editar_proveedor.php?id=" . $proveedor['id'] . "' title='Editar'><i class='fa fa-pen'></i></a> ";
                                                    echo "<a class='btn btn-sm btn-danger' href='../action/eliminar_proveedor.php?id=" . $proveedor['id'] . "' title='Eliminar' ><i class='fa fa-trash'></i></a>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='8'>No hay proveedores registrados.</td></tr>";
                                            }
                                            ?>
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

        <!-- App js -->
        <script src="../assets/js/theme.js"></script>

</body>

</html>

<?php
// Liberar resultados y cerrar conexión
$result->free();
$conn->close();
?>