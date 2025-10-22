<?php
// Conexión a la base de datos
require_once '../services/conexion.php';

// Obtener el id de la atención desde la URL
$id_atencion = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id_atencion) {
    echo "ID de atención no válido.";
    exit;
}

// Consulta para obtener los medicamentos con stock calculado
$sql = "SELECT id, nombre, stock, 'medicamentos' AS origen
FROM medicamentos
WHERE fecha_vencimiento >= CURDATE()
  AND stock > 0
  AND estado = 1

UNION ALL

SELECT id, nombre, stock, 'mmedicamentos' AS origen
FROM mmedicamentos
WHERE fecha_vencimiento >= CURDATE()
  AND stock > 0
  AND estado = 1"; // Filtrar solo los medicamentos con stock mayor o igual a 1

$result = $conn->query($sql);

// Verificamos si encontramos medicamentos
$medicamentos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicamentos[] = $row;
    }
}
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
                                <h4 class="mb-0 font-size-18">Añadir Insumos Usados en la Atención <i
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
                                    <p class="card-subtitle mb-4">Rellenar los datos para poder generar la receta de atención.</p>
                                    <form id="formInsumos">
                                        <input type="hidden" id="id_atencion" value="<?= $id_atencion ?>">

                                        <!-- Seleccionar Medicamento -->
                                        <div class="form-group">
                                            <label for="medicamento">Seleccionar Medicamento</label>
                                            <select class="form-control" id="medicamento">
                                                <option value="">Seleccione un medicamento</option>
                                                <?php foreach ($medicamentos as $medicamento): ?>
                                                    <option value="<?= $medicamento['id'] ?>" data-nombre="<?= $medicamento['nombre'] ?>">
                                                        <?= $medicamento['nombre'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>


                                        <!-- Campo para cantidad -->
                                        <div class="form-group">
                                            <label for="cantidad">Cantidad</label>
                                            <input type="number" class="form-control" id="cantidad" min="1" required>
                                        </div>

                                        <!-- Botón para agregar el insumo -->
                                        <button type="button" class="btn btn-primary" id="addInsumoBtn">Agregar Insumo</button>
                                    </form>

                                    <!-- Tabla de insumos añadidos -->
                                    <h3>Insumos Añadidos</h3>
                                    <table class="table" id="tablaInsumos">
                                        <thead>
                                            <tr>
                                                <th>Medicamento</th>
                                                <th>Cantidad</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Los insumos añadidos aparecerán aquí -->
                                        </tbody>
                                    </table>

                                    <!-- Botón para guardar los insumos -->
                                    <button type="button" class="btn btn-success" id="saveInsumosBtn">Guardar Insumos</button>
                                </div>

                                <script src="path_to_jquery.js"></script>
                                <script src="path_to_bootstrap.js"></script>
                                <script>
                                    let insumos = []; // Array para almacenar los insumos añadidos

                                    // Función para agregar un insumo a la lista
                                    document.getElementById('addInsumoBtn').addEventListener('click', function() {
                                        const medicamentoSelect = document.getElementById('medicamento');
                                        const cantidadInput = document.getElementById('cantidad');
                                        const medicamentoId = medicamentoSelect.value;
                                        const medicamentoNombre = medicamentoSelect.selectedOptions[0]?.text;
                                        const cantidad = cantidadInput.value;

                                        // Validar si se seleccionó un medicamento y se ingresó una cantidad
                                        if (!medicamentoId || !cantidad || cantidad <= 0) {
                                            Swal.fire('Por favor, selecciona un medicamento y una cantidad válida.');
                                            return;
                                        }

                                        // Agregar el insumo al array
                                        insumos.push({
                                            id: medicamentoId,
                                            nombre: medicamentoNombre,
                                            cantidad: cantidad
                                        });

                                        // Actualizar la tabla de insumos
                                        actualizarTablaInsumos();

                                        // Limpiar los campos
                                        medicamentoSelect.value = "";
                                        cantidadInput.value = "";
                                    });

                                    // Función para actualizar la tabla de insumos añadidos
                                    function actualizarTablaInsumos() {
                                        const tbody = document.getElementById('tablaInsumos').getElementsByTagName('tbody')[0];
                                        tbody.innerHTML = ""; // Limpiar tabla antes de actualizarla

                                        insumos.forEach((insumo, index) => {
                                            const row = tbody.insertRow();
                                            row.innerHTML = `
                    <td>${insumo.nombre}</td>
                    <td>${insumo.cantidad}</td>
                    <td><button class="btn btn-danger" onclick="eliminarInsumo(${index})">Eliminar</button></td>
                `;
                                        });
                                    }

                                    // Función para eliminar un insumo de la lista
                                    function eliminarInsumo(index) {
                                        insumos.splice(index, 1);
                                        actualizarTablaInsumos();
                                    }

                                    // Función para guardar los insumos en la base de datos
                                    document.getElementById('saveInsumosBtn').addEventListener('click', function() {
                                        if (insumos.length === 0) {
                                            Swal.fire('No hay insumos para guardar.');
                                            return;
                                        }

                                        const idAtencion = document.getElementById('id_atencion').value;

                                        // Enviar los insumos al servidor para guardarlos
                                        const formData = new FormData();
                                        formData.append('id_atencion', idAtencion);
                                        formData.append('insumos', JSON.stringify(insumos)); // Enviar insumos como un array JSON

                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST', '../processes/guardar_insumos.php', true);

                                        xhr.onload = function() {
                                            if (xhr.status === 200) {
                                                const response = JSON.parse(xhr.responseText);
                                                if (response.success) {
                                                    Swal.fire('Insumos guardados correctamente.');

                                                    // Redirigir a la página de impresión
                                                    window.location.href = response.redirect_url;
                                                } else {
                                                    Swal.fire('Hubo un error al guardar los insumos.');
                                                }
                                            } else {
                                                Swal.fire('Error en la comunicación con el servidor.');
                                            }
                                        };

                                        // Enviar la solicitud con los datos
                                        xhr.send(formData);
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