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
                                <h4 class="mb-0 font-size-18">Usuarios <i
                                        class="fas fa-users-cog"></i></h4>

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
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Nuevo Usuario</h4>
                                    <p class="card-subtitle mb-4">El DNI consultará la base de datos de RENIEC para completar los datos y será el identificador de usuario en el sistema.</p>
                                    <form class="needs-validation" novalidate action="../processes/guardar_usuario.php" method="POST" id="usuarioForm">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltipUsername">DNI/USUARIO</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="validationTooltipUsername" name="dni" placeholder="01234567"
                                                        aria-describedby="validationTooltipUsernamePrepend" required maxlength="8" pattern="\d{8}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                    <div class="invalid-tooltip">
                                                        Inserte un número de DNI válido
                                                    </div>
                                                    <div class="input-group-prepend">
                                                        <span type="button" class="input-group-text" id="validationTooltipUsernamePrepend" onclick="buscarDNI()">
                                                            <i class="fas fa-search"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip01">Nombres</label>
                                                <input type="text" class="form-control" id="nombres" name="nombres" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip01">Apellido Paterno</label>
                                                <input type="text" class="form-control" id="apellidoPaterno" name="apellido_paterno" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip01">Apellido Materno</label>
                                                <input type="text" class="form-control" id="apellidoMaterno" name="apellido_materno" required>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-3 mb-3">
                                                <label for="validationTooltip01">Contraseña</label>
                                                <input type="text" class="form-control" id="password" name="password" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="validationTooltip03">Rol</label>
                                                <select class="form-control mb-3" name="cargo" required="required">
                                                    <option disabled value="" selected>Seleccionar</option>
                                                    <option value="Administrador">Administrador</option>
                                                    <option value="Atencion">Atencion</option>
                                                    <option value="Almacen">Almacen</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="validationTooltip03">Estado</label>
                                                <select class="form-control mb-3" name="estado" required="required">
                                                    <option value="Activo" >Activo</option>
                                                    <option value="Inactivo">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Guardar</button>
                                        <a href="../view/usuarios.php" class="btn btn-danger waves-effect waves-light">Cancelar</a>
                                    </form>

                                    <script>
                                        function buscarDNI() {
                                            resetInputs();
                                            const dni = document.getElementById('validationTooltipUsername').value;

                                            if (dni.length === 8) {
                                                fetch(`https://dniruc.apisperu.com/api/v1/dni/${dni}?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImFuZ2VsY2hvY2NhcmFtb3NAZ21haWwuY29tIn0.9i43OwEhs_5qO2lmxn5tb0HvAaPDK1zSVjVbgi3UtWk`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data && data.nombres && data.apellidoPaterno && data.apellidoMaterno) {
                                                            document.getElementById('nombres').value = data.nombres;
                                                            document.getElementById('apellidoPaterno').value = data.apellidoPaterno;
                                                            document.getElementById('apellidoMaterno').value = data.apellidoMaterno;

                                                            // Generación de la contraseña
                                                            const apellidoPaterno = data.apellidoPaterno;
                                                            const contraseñaGenerada = apellidoPaterno + dni;
                                                            document.getElementById('password').value = contraseñaGenerada;

                                                        } else {
                                                            enableInputs();
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error("Error al consultar el API:", error);
                                                        enableInputs();
                                                    });
                                            } else {
                                                alert("Por favor, ingrese un DNI válido de 8 dígitos.");
                                            }
                                        }

                                        function resetInputs() {
                                            document.getElementById('nombres').value = "";
                                            document.getElementById('apellidoPaterno').value = "";
                                            document.getElementById('apellidoMaterno').value = "";
                                            document.getElementById('password').value = ""; // Resetear el campo de contraseña
                                        }

                                        function enableInputs() {
                                            // Implementa la lógica para habilitar los campos si es necesario
                                        }

                                        // Función para validar el formulario antes de enviarlo
                                        document.getElementById('usuarioForm').addEventListener('submit', function(event) {
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
                                            if (document.getElementsByName('cargo').value == "") {
                                                isValid = false;
                                                document.getElementsByName('cargo').classList.add('is-invalid');
                                            }
                                            if (document.getElementsByName('estado').value == "") {
                                                isValid = false;
                                                document.getElementsByName('estado').classList.add('is-invalid');
                                            }
                                            let dnni = document.getElementById('validationTooltipUsername').value;
                                            let cantdni = dnni.length;
                                            if (cantdni < 8) {
                                                isValid = false;
                                                document.getElementById('validationTooltipUsername').classList.add('is-invalid');
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