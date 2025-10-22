<?php
// Incluir el archivo de conexión
include('../services/conexion.php');

// Consulta SQL para obtener los datos
$sql = "SELECT 
a.id AS atencion_id,
a.fecha_atencion,
a.procedimiento,

-- Datos del paciente
p.dni AS paciente_dni,
CONCAT(p.apellido_paterno, ' ', p.apellido_materno, ' ', p.nombres) AS paciente_nombre_completo,
p.programa_estudios,

-- Datos del encargado
u.dni AS encargado_dni,
CONCAT(u.apellido_paterno, ' ', u.apellido_materno, ' ', u.nombres) AS encargado_nombre_completo,
u.cargo AS encargado_cargo

FROM atenciones a
JOIN pacientes p ON a.paciente = p.id
JOIN usuarios u ON a.encargado = u.id
ORDER BY a.id DESC;";

// Ejecutar la consulta
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
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
                                <h4 class="mb-0 font-size-18">Atención <i
                                        class="fas fa-user-md"></i></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Atención</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-subtitle mb-4">
                                    <a href="../add_data/new_atencion.php" class="btn btn-primary waves-effect waves-light">Nueva Atención</a>
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>DNI</th>
                                                <th>Nombre</th>
                                                <th>P.E.</th>
                                                <th>Insumos</th>
                                                <th>Responsable</th>
                                                <th>Fecha</th>
                                                <th>Proc.</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Verificar si la consulta ha devuelto resultados
                                            if (mysqli_num_rows($resultado) > 0) {
                                                // Si hay resultados, mostrar las filas de la tabla
                                                while ($row = mysqli_fetch_assoc($resultado)) {
                                            ?>
                                                    <tr>
                                                        <!-- Mostrar el ID de la atención en la columna # -->
                                                        <td><?php echo $row['atencion_id']; ?></td>
                                                        <td><?php echo $row['paciente_dni']; ?></td>
                                                        <td><?php echo $row['paciente_nombre_completo']; ?></td>
                                                        <td><?php echo $row['programa_estudios']; ?></td>
                                                        <td>
                                                            <!-- Botón para ver los insumos -->
                                                            <a class="btn btn-sm btn-secondary" href="" title="Ver" id="verInsumos<?php echo $row['atencion_id']; ?>"><i class="fas fa-eye"></i></a>
                                                        </td>
                                                        <td><?php echo $row['encargado_nombre_completo']; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($row['fecha_atencion'])); ?></td>

                                                        <td>
                                                            <!-- Botón para ver el procedimiento -->
                                                            <a class="btn btn-sm btn-secondary" href="" title="Ver" id="verProcedimiento<?php echo $row['atencion_id']; ?>"><i class="fas fa-eye"></i></a>
                                                        </td>
                                                        <script>
                                                            // Mostrar insumos con cantidades en el popup (solo los insumos)
                                                            document.getElementById('verInsumos<?php echo $row['atencion_id']; ?>').addEventListener('click', function(e) {
                                                                e.preventDefault(); // Evitar que se recargue la página

                                                                // Crear la tabla de insumos con cantidades
                                                                let insumosHtml = '<table class="table"><thead><tr><th>#</th><th>Insumo</th><th>Cantidad</th></tr></thead><tbody>';

                                                                <?php
                                                                // Obtener los insumos y cantidades de la atencion actual
                                                                $atencion_id = $row['atencion_id'];
                                                                $insumoQuery = "
SELECT 
    m.nombre AS insumo,
    ai.cantidad
FROM atencion_insumos ai
JOIN medicamentos m ON ai.insumo_medico = m.id
WHERE ai.tipo = 1 AND ai.atencion_id = $atencion_id

UNION ALL

SELECT 
    mm.nombre AS insumo,
    ai.cantidad
FROM atencion_insumos ai
JOIN mmedicamentos mm ON ai.insumo_medico = mm.id
WHERE ai.tipo = 2 AND ai.atencion_id = $atencion_id
";
                                                                $insumoResult = mysqli_query($conn, $insumoQuery);
                                                                $contador = 1;
                                                                $insumoResult = mysqli_query($conn, $insumoQuery);
                                                                $contador = 1;
                                                                while ($insumo = mysqli_fetch_assoc($insumoResult)) {
                                                                    echo "insumosHtml += '<tr><td>" . $contador . "</td><td>" . addslashes($insumo['insumo']) . "</td><td>" . $insumo['cantidad'] . "</td></tr>';";
                                                                    $contador++;
                                                                }
                                                                ?>

                                                                insumosHtml += '</tbody></table>';

                                                                // Mostrar el popup con solo la tabla de insumos
                                                                Swal.fire({
                                                                    title: 'Insumos Entregados al Paciente',
                                                                    html: insumosHtml,
                                                                    showCloseButton: true, // Mostrar botón para cerrar
                                                                    width: '80%', // Ancho del popup
                                                                    confirmButtonText: 'Cerrar', // Texto del botón de confirmación
                                                                });
                                                            });

                                                            // Mostrar procedimiento en el popup (solo el procedimiento)
                                                            document.getElementById('verProcedimiento<?php echo $row['atencion_id']; ?>').addEventListener('click', function(e) {
                                                                e.preventDefault(); // Evitar que se recargue la página

                                                                // Mostrar el procedimiento en un popup
                                                                Swal.fire({
                                                                    title: 'Procedimiento de Atención',
                                                                    html: `<p><?php echo $row['procedimiento']; ?></p>`,
                                                                    showCloseButton: true, // Mostrar botón para cerrar
                                                                    confirmButtonText: 'Cerrar', // Texto del botón de confirmación
                                                                });
                                                            });
                                                        </script>
                                                        <td>
                                                            <a class="btn btn-sm btn-dark" href="../print/print-id.php?id=<?php echo $row['atencion_id']; ?>" title="Imprimir"><i class="fas fa-print"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                // Si no hay registros, mostrar un mensaje indicando que no hay datos
                                                ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No se encontraron registros</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->
                            </div>
                            <!-- end card-body-->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
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