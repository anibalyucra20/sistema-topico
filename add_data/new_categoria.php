<!DOCTYPE html>
<html lang="es">

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
                                <h4 class="mb-0 font-size-18">Categorías <i class="fas fa-list"></i></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Categorías</li>
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
                                    <h4 class="card-title">Nueva Categoría</h4>
                                    <p class="card-subtitle mb-4">Rellenar los datos correctamente para poder guardar.</p>
                                    
                                    <!-- Formulario para agregar una nueva categoría -->
                                    <form action="../processes/guardar_categoria.php" method="POST" class="needs-validation" novalidate id="categoriaForm">
                                        <div class="form-row">
                                            <div class="col-md-5 mb-3">
                                                <label for="nombre_categoria">Nombre</label>
                                                <input type="text" name="nombre" class="form-control" id="nombre_categoria" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="tipo_categoria">Tipo</label>
                                                <select name="tipo" class="form-control" id="tipo_categoria" required>
                                                    <option value="" disabled selected>Seleccionar</option>
                                                    <option value="Sin Receta">Sin Receta</option>
                                                    <option value="Con Receta">Con Receta</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                                        <a href="../view/categorias.php" class="btn btn-danger waves-effect waves-light">Cancelar</a>
                                    </form>
                                    <script>
                                        // Función para validar el formulario antes de enviarlo
                                        document.getElementById('categoriaForm').addEventListener('submit', function(event) {
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

                                            if (document.getElementsByName('tipo_categoria').value == "") {
                                                isValid = false;
                                                document.getElementsByName('tipo_categoria').classList.add('is-invalid');
                                            }
                                            // Si algún campo es inválido, no enviar el formulario
                                            if (!isValid) {
                                                event.preventDefault();
                                                event.stopPropagation();
                                                Swal.fire('Por favor, complete todos los campos obligatorios.');
                                                //alert('Por favor, complete todos los campos obligatorios.');
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
