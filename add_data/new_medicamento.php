<?php
// Incluir archivo de conexión a la base de datos
include '../services/conexion.php';

// Consulta para obtener solo los nombres de las categorías
$query = "SELECT * FROM categoria";
$resultado_categoria = $conn->query($query);

// Almacenar resultados en un array
$categorias = "";
while ($cat = $resultado_categoria->fetch_assoc()) {
    $categorias.= "<option value=".$cat['id'].">".$cat['nombre']."</option>";
}

// Consulta para obtener solo los nombres de los laboratorios
$query = "SELECT * FROM laboratorio";
$resultado_lab = $conn->query($query);

// Almacenar resultados en un array
$laboratorios = "";
while ($lab = $resultado_lab->fetch_assoc()) {
    $laboratorios .= "<option value=".$lab['id'].">".$lab['nombre']."</option>";
}

// Consulta para obtener solo los nombres de los proveedores
$query = "SELECT * FROM proveedores";
$resultado_prov = $conn->query($query);

// Almacenar resultados en un array
$proveedores = "";
while ($prov = $resultado_prov->fetch_assoc()) {
    $proveedores .= "<option value=".$prov['id'].">".$prov['razon_social']."</option>";
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
                                <h4 class="mb-0 font-size-18">Almacén de Medicamentos <i
                                        class="fas fa-capsules"></i></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Almacén de Medicamentos</li>
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
                                    <h4 class="card-title">Nuevo Medicamento</h4>
                                    <p class="card-subtitle mb-4">Rellenar los datos correctamente para poder guardar.</p>
                                    <form class="needs-validation" novalidate action="../processes/guardar_medicamento.php" method="POST" id="medicamentoForm">
                                        <div class="form-row">
                                            <div class="col-md-4 mb-3">
                                                <label for="validationTooltip01">Nombre</label>
                                                <input type="text" class="form-control" id="validationTooltip01" name="nombre" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip02">Presentación</label>
                                                <input type="text" class="form-control" id="validationTooltip02" name="presentacion" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip03">Composición</label>
                                                <input type="text" class="form-control" id="validationTooltip03" name="marca" required>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="validationTooltip04">Cantidad/Unidades</label>
                                                <input type="text" class="form-control" id="validationTooltip04" name="cantidad" required
                                                    pattern="[1-9][0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/^0+/, '')">
                                                <div class="invalid-tooltip">
                                                    Cantidad invalida.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                                                <input type="date" name="fecha_vencimiento" class="form-control" id="fecha_vencimiento" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="categoria">Categoría</label>
                                                <select class="form-control mb-3" name="categoria" required>
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <?php echo $categorias; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="laboratorio">Laboratorio</label>
                                                <select class="form-control mb-3" name="laboratorio" required>
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <?php echo $laboratorios; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="lote">Lote</label>
                                                <input type="text" class="form-control" id="lote" name="lote" required
                                                    pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="fecha_ingreso">Fecha de Ingreso</label>
                                                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" autocomplete="off" value="<?= date('Y-m-d'); ?>" required />
                                            </div>
                                            <div class="col-md-3 mb-3 ml-auto">
                                                <label for="proveedor">Proveedor</label>
                                                <select class="form-control mb-3" name="proveedor" required>
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <?php echo $proveedores; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                                        <a href="../view/almacen_medicamentos.php" class="btn btn-danger waves-effect waves-light">Cancelar</a>
                                    </form>

                                    <script>
                                        // Función para validar el formulario antes de enviarlo
                                        document.getElementById('medicamentoForm').addEventListener('submit', function(event) {
                                            var form = this;
                                            var isValid = true;

                                            // Verificar si hay campos vacíos
                                            var fields = form.querySelectorAll('[required]');
                                            fields.forEach(function(field) {
                                                if (!field.value) {
                                                    isValid = false;
                                                    field.classList.add('is-invalid');
                                                } else {
                                                    field.classList.remove('is-invalid');
                                                }
                                            });
                                            if (document.getElementsByName('categoria').value == "") {
                                                isValid = false;
                                                document.getElementsByName('categoria').classList.add('is-invalid');
                                            }
                                            if (document.getElementsByName('laboratorio').value == "") {
                                                isValid = false;
                                                document.getElementsByName('laboratorio').classList.add('is-invalid');
                                            }
                                            if (document.getElementsByName('proveedor').value == "") {
                                                isValid = false;
                                                document.getElementsByName('proveedor').classList.add('is-invalid');
                                            }

                                            // Si algún campo es inválido, no enviar el formulario
                                            if (!isValid) {
                                                event.preventDefault();
                                                event.stopPropagation();
                                                Swal.fire('Por favor, complete todos los campos obligatorios.');
                                            }
                                        });
                                    </script>

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