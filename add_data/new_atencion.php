<?php
// Archivo: buscar_paciente.php

include '../services/conexion.php'; // Archivo de conexión a la base de datos

// Consulta para obtener los id y nombres de los medicamentos
$sql = "SELECT id, nombre FROM medicamentos 
        UNION 
        SELECT id, nombre FROM mmedicamentos";
$result = $conn->query($sql);

// Crear un array para almacenar los id y nombres de los medicamentos
$medicamentos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicamentos[] = [
            'id' => $row['id'],
            'nombre' => $row['nombre']
        ];
    }
} else {
    echo "No hay resultados";
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<?php include '../layout/head.php'; ?>

<body>

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

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Nueva Atención</h4>
                                    <p class="card-subtitle mb-4">Rellenar los datos para poder generar la receta de atención.<br>
                                        <strong>ADVERTENCIA:</strong> Si los datos no se encuentran, ingréselos manualmente.
                                    </p>
                                    <form class="needs-validation" id="formAtencion" novalidate>
                                        <div class="form-row">
                                            <!-- Campo para DNI -->
                                            <div class="col-md-2 mb-3">
                                                <label for="dni">DNI</label>
                                                <div class="input-group">
                                                    <input type="hidden" name="id_user" id="id_user">
                                                    <input type="text" class="form-control" id="dni" placeholder="01234567" aria-describedby="validationTooltipUsernamePrepend" required maxlength="8" pattern="\d{8}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                    <div class="invalid-tooltip">Inserte un DNI válido</div>
                                                    <div class="input-group-prepend">
                                                        <span type="button" class="input-group-text" id="searchButton" onclick="searchPatient()"><i class="fas fa-search"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Campo para Nombres -->
                                            <div class="col-md-3 mb-3">
                                                <label for="nombres">Nombres</label>
                                                <input type="text" class="form-control" id="nombres" required>
                                            </div>

                                            <!-- Campo para Apellidos -->
                                            <div class="col-md-3 mb-3">
                                                <label for="apellidos">Apellidos</label>
                                                <input type="text" class="form-control" id="apellidos" required>
                                            </div>

                                            <!-- Campo para Programa de Estudios -->
                                            <div class="col-md-3 mb-3">
                                                <label for="programa_estudios">Programa de Estudios</label>
                                                <input type="text" class="form-control" id="programa_estudios" required>
                                            </div>


                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6 mb-3">
                                                <label for="procedimiento">Procedimiento</label>
                                                <input type="text" class="form-control" id="procedimiento" placeholder="Detalle brevemente el proceso de atención realizada." required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="orderDate">Encargado</label>
                                                <input type="hidden" id="id_encargado" value="<?php echo $_SESSION['usuarioid']; ?>">
                                                <input type="text" class="form-control" id="encargado" value="<?php echo htmlspecialchars($_SESSION['usuario']); ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="orderDate">Fecha de Atención</label>
                                                <input type="date" class="form-control" id="orderDate" name="orderDate" autocomplete="off" value="<?= date_default_timezone_set('America/Lima') ? date('Y-m-d') : ''; ?>" required>
                                            </div>
                                        </div>

                                        <!-- Botón para guardar -->
                                        <button class="btn btn-primary waves-effect waves-light" id="saveButton" type="submit">Guardar</button>
                                        <a href="../view/atencion.php" class="btn btn-danger waves-effect waves-light">Cancelar</a>
                                    </form>

                                    <script>
                                        // Función de búsqueda del paciente por DNI
                                        function searchPatient() {
                                            const dni = document.getElementById('dni').value;

                                            // Validar el DNI
                                            if (dni.length === 8) {
                                                var xhr = new XMLHttpRequest();
                                                xhr.open('GET', '../processes/buscar_paciente.php?dni=' + dni, true);

                                                xhr.onload = function() {
                                                    if (xhr.status === 200) {
                                                        const result = JSON.parse(xhr.responseText);

                                                        // Si se encontró el paciente, llenamos los campos
                                                        if (result.success) {

                                                            document.getElementById('id_user').value = result.id;
                                                            document.getElementById('nombres').value = result.nombres;
                                                            document.getElementById('apellidos').value = result.apellido_paterno + ' ' + result.apellido_materno;
                                                            document.getElementById('programa_estudios').value = result.programa_estudios;
                                                        } else {
                                                            // Si no se encuentra el paciente
                                                            Swal.fire('No se encontró un paciente con ese DNI.');
                                                            // Limpiar los campos en caso de error
                                                            document.getElementById('id_user').value = '';
                                                            document.getElementById('nombres').value = '';
                                                            document.getElementById('apellidos').value = '';
                                                            document.getElementById('programa_estudios').value = '';
                                                        }
                                                    } else {
                                                        Swal.fire('Error en la comunicación con el servidor.');
                                                    }
                                                };
                                                xhr.send();
                                            } else {
                                                Swal.fire('Por favor, ingrese un DNI válido (8 dígitos).');
                                            }
                                        }

                                        // Función para guardar la atención médica
                                        function guardarAtencion(event) {
                                            event.preventDefault(); // Evitar envío tradicional del formulario

                                            var form = document.getElementById('formAtencion');
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

                                            const id_user = document.getElementById('id_user').value;
                                            const dni = document.getElementById('dni').value;
                                            const nombres = document.getElementById('nombres').value;
                                            const apellidos = document.getElementById('apellidos').value;
                                            const programaEstudios = document.getElementById('programa_estudios').value;
                                            const procedimiento = document.getElementById('procedimiento').value;
                                            const encargado = document.getElementById('encargado').value;
                                            const id_encargado = document.getElementById('id_encargado').value;
                                            const fechaAtencion = document.getElementById('orderDate').value;

                                            // Verificar que los datos obligatorios estén completos
                                            if (!id_user || !dni || !nombres || !apellidos || !programaEstudios || !procedimiento || !encargado || !fechaAtencion) {
                                                Swal.fire('Por favor, complete todos los campos obligatorios.');
                                                return;
                                            }

                                            // Deshabilitar el botón de guardado mientras se procesa la solicitud
                                            const saveButton = document.getElementById('saveButton');
                                            saveButton.disabled = true;

                                            // Enviar los datos al servidor
                                            var formData = new FormData();
                                            formData.append('id', id_user);
                                            formData.append('procedimiento', procedimiento);
                                            formData.append('encargado', id_encargado);
                                            formData.append('fecha_atencion', fechaAtencion);

                                            var xhr = new XMLHttpRequest();
                                            xhr.open('POST', '../processes/guardar_atencion.php', true);

                                            xhr.onload = function() {
                                                // Volver a habilitar el botón de guardado
                                                saveButton.disabled = false;

                                                if (xhr.status === 200) {
                                                    const response = JSON.parse(xhr.responseText);
                                                    if (response.success) {
                                                        // Si la inserción fue exitosa, redirigir a la página de agregar medicamentos
                                                        window.location.href = "agregar_medicamento.php?id=" + response.id_atencion;
                                                    } else {
                                                        Swal.fire('Hubo un error al guardar los datos.');
                                                    }
                                                } else {
                                                    Swal.fire('Error en la comunicación con el servidor.');
                                                }
                                            };

                                            // Enviar la solicitud con los datos
                                            xhr.send(formData);
                                        }

                                        // Asignar la función de guardar al evento submit del formulario
                                        document.getElementById('formAtencion').addEventListener('submit', guardarAtencion);
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