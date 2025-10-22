<?php
include '../services/conexion.php';

// Consultar los datos de la tabla 'usuarios'
$sql = "SELECT id, dni, nombres, apellido_paterno, apellido_materno, password, cargo, estado FROM usuarios";
$result = $conn->query($sql);
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
                                <h4 class="mb-0 font-size-18">Usuarios <i class="fas fa-users-cog"></i></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Usuarios</li>
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
                                        <a href="../add_data/new_usuario.php" class="btn btn-primary waves-effect waves-light">Nuevo Usuario</a>
                                    </p>

                                    <table id="state-saving-datatable" class="table activate-select dt-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Nombres</th>
                                                <th>Apellidos</th>
                                                <th>Usuario</th>
                                                <th>Contraseña</th>
                                                <th>Rol</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                $contador = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    $nuevo_estado = ($row['estado'] == 'Activo') ? 'Inactivo' : 'Activo';
                                                    echo "<tr>";
                                                    echo "<td>" . $contador++ . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['nombres']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['apellido_paterno'] . " " . $row['apellido_materno']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['dni']) . "</td>";
                                                    echo "<td>********</td>";
                                                    echo "<td>" . htmlspecialchars($row['cargo']) . "</td>";
                                                    echo "<td>";
                                                    // Cambiar el ícono y el enlace según el estado
                                                    if ($row['estado'] == 'Activo') {
                                                        echo '<a class="btn btn-sm btn-secondary" href="../processes/cambiar_estado.php?id=' . $row['id'] . '&nuevo_estado=' . $nuevo_estado . '" title="Desactivar"><i class="fas fa-user-check"></i></a>';
                                                    } else {
                                                        echo '<a class="btn btn-sm btn-dark" href="../processes/cambiar_estado.php?id=' . $row['id'] . '&nuevo_estado=' . $nuevo_estado . '" title="Activar"><i class="fas fa-user-times"></i></a>';
                                                    }
                                                    // Botón para Editar el usuario, redirige a editar_usuario.php con el id del usuario
                                                    echo '<a class="btn btn-sm btn-info" href="../action/editar_usuarios.php?id=' . $row['id'] . '" title="Editar"><i class="fa fa-pen"></i></a>';

                                                    // Botón para Eliminar el usuario, redirige a eliminar_usuario.php con el id del usuario
                                                    //echo '<a class="btn btn-sm btn-danger" href="../action/eliminar_usuarios.php?id=' . $row['id'] . '" title="Eliminar"><i class="fa fa-trash"></i></a>';

                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7'>No hay usuarios registrados.</td></tr>";
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

        <!-- Sparkline Js-->
        <script src="../plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- Chart Js-->
        <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>

        <!-- Chart Custom Js -->
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
// Cerrar la conexión a la base de datos
$conn->close();
?>