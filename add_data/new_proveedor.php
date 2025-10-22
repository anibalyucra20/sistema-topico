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
                                <h4 class="mb-0 font-size-18">Proveedores <i
                                        class="fas fa-truck"></i></h4>

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
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Nuevo Proveedor</h4>
                                    <p class="card-subtitle mb-4">Rellenar los datos correctamente para poder guardar.</p>
                                    <form class="needs-validation" novalidate action="../processes/guardar_proveedor.php" method="POST" id="proveedorForm">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltipUsername">RUC</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="rucInput" name="ruc" placeholder="20123456789" required maxlength="11"
                                                        pattern="^(10|20)\d{9}$"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 2 && !/^(10|20)/.test(this.value)) this.value = this.value.slice(0, 2);">
                                                    <div class="invalid-tooltip">
                                                        Inserte un RUC válido
                                                    </div>
                                                    <div class="input-group-prepend">
                                                        <span type="button" class="input-group-text" onclick="buscarRUC()">
                                                            <i class="fas fa-search"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip01">Teléfono</label>
                                                <input type="text" class="form-control" id="validationTooltip01" name="telefono" required maxlength="9"
                                                    pattern="^9\d{7}$"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 1 && this.value[0] !== '9') this.value = this.value.slice(0, 1);">
                                                <div class="invalid-tooltip">
                                                    Inserte un número de teléfono válido
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <label for="validationTooltip01">Correo</label>
                                                <input type="email" class="form-control" id="validationTooltip01" name="correo" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-11 mb-3">
                                                <label for="razonSocial">Razón Social</label>
                                                <input type="text" class="form-control" id="razonSocial" name="razon_social" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="direccion">Dirección</label>
                                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="provincia">Provincia</label>
                                                <input type="text" class="form-control" id="provincia" name="provincia" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="distrito">Distrito</label>
                                                <input type="text" class="form-control" id="distrito" name="distrito" required>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                                        <a href="../view/proveedores.php" class="btn btn-danger waves-effect waves-light">Cancelar</a>
                                    </form>
                                    <script>
                                        function buscarRUC() {
                                            const ruc = document.getElementById('rucInput').value;

                                            // Limpiar campos antes de la nueva búsqueda
                                            document.getElementById('razonSocial').value = '';
                                            document.getElementById('direccion').value = '';
                                            document.getElementById('provincia').value = '';
                                            document.getElementById('distrito').value = '';

                                            if (ruc.length === 11) {
                                                fetch(`https://dniruc.apisperu.com/api/v1/ruc/${ruc}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFuZ2VsY2hvY2NhcmFtb3NAZ21haWwuY29tIn0.9i43OwEhs_5qO2lmxn5tb0HvAaPDK1zSVjVbgi3UtWk`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data && data.razonSocial && data.direccion && data.provincia && data.distrito) {
                                                            document.getElementById('razonSocial').value = data.razonSocial;
                                                            document.getElementById('direccion').value = data.direccion;
                                                            document.getElementById('provincia').value = data.provincia;
                                                            document.getElementById('distrito').value = data.distrito;
                                                        } else {
                                                            // Desactivar `disabled` si no se encuentran los datos
                                                            document.getElementById('razonSocial').disabled = false;
                                                            document.getElementById('direccion').disabled = false;
                                                            document.getElementById('provincia').disabled = false;
                                                            document.getElementById('distrito').disabled = false;
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error("Error al consultar el API:", error);
                                                        document.getElementById('razonSocial').disabled = false;
                                                        document.getElementById('direccion').disabled = false;
                                                        document.getElementById('provincia').disabled = false;
                                                        document.getElementById('distrito').disabled = false;
                                                    });
                                            } else {
                                                alert("Por favor, ingrese un RUC válido de 11 dígitos.");
                                            }
                                        }
                                        
                                        // Función para validar el formulario antes de enviarlo
                                        document.getElementById('proveedorForm').addEventListener('submit', function(event) {
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