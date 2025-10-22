<?php
// Incluye el archivo de conexión
include('../services/conexion.php');

// Arreglo de tablas
$tablas = [
    'medicamentos',
    'mmedicamentos',
    'pacientes',
    'atenciones',
    'categoria',
    'laboratorio',
    'proveedores'
];

// Arreglo para almacenar los resultados de cada tabla
$conteos = [];

// Contar las filas para cada tabla
foreach ($tablas as $tabla) {
    // Prepara y ejecuta la consulta para contar las filas
    $sql = "SELECT COUNT(*) AS total FROM $tabla";
    $result = $conn->query($sql);

    // Verifica si la consulta se ejecutó correctamente
    if ($result) {
        $row = $result->fetch_assoc();
        $conteos[$tabla] = $row['total'];
    } else {
        $conteos[$tabla] = 0; // Si la consulta falla, asigna 0
    }
}

// Obtener la fecha actual
$hoy = date('Y-m-d');

// Fecha para los medicamentos que están a una semana de vencer
$unaSemana = date('Y-m-d', strtotime('+7 days'));

// Consulta SQL para obtener los medicamentos y mmedicamentos
$sql = "
    (SELECT id, nombre, fecha_vencimiento 
     FROM medicamentos 
     WHERE fecha_vencimiento <= '$unaSemana' AND estado=1)
    UNION
    (SELECT id, nombre, fecha_vencimiento 
     FROM mmedicamentos 
     WHERE fecha_vencimiento <= '$unaSemana'  AND estado=1)
    ORDER BY fecha_vencimiento ASC;
";

// Asumiendo que se realiza la conexión y ejecución de la consulta correctamente
$result = $conn->query($sql); // Aquí se debe tener la conexión correcta

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
                                <h4 class="mb-0 font-size-18">Dashboard</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Dashboard</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <span class="badge badge-soft-info float-right"><i class="fas fa-capsules"></i></span>
                                        <h5 class="card-title mb-0">Medicamentos</h5>
                                    </div>
                                    <div class="row d-flex align-items-center mb-4">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                <?php echo number_format($conteos['medicamentos']); ?>
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="progress shadow-sm" style="height: 5px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                                <!--end card body-->
                            </div><!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <span class="badge badge-soft-danger float-right"><i class="fas fa-briefcase-medical"></i></span>
                                        <h5 class="card-title mb-0">Insumos Médicos</h5>
                                    </div>
                                    <div class="row d-flex align-items-center mb-4">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                <?php echo number_format($conteos['mmedicamentos']); ?>
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="progress shadow-sm" style="height: 5px;">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                                <!--end card body-->
                            </div><!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <span class="badge badge-soft-dark float-right"><i class="fas fa-user-injured"></i></span>
                                        <h5 class="card-title mb-0">Pacientes</h5>
                                    </div>
                                    <div class="row d-flex align-items-center mb-4">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                <?php echo number_format($conteos['pacientes']); ?>
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="progress shadow-sm" style="height: 5px;">
                                        <div class="progress-bar bg-light" role="progressbar" style="width: 100%;"></div>
                                    </div>
                                </div>
                                <!--end card body-->
                            </div><!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <span class="badge badge-soft-success float-right"><i class="fas fa-receipt"></i></span>
                                        <h5 class="card-title mb-0">Atenciones</h5>
                                    </div>
                                    <div class="row d-flex align-items-center mb-4">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                <?php echo number_format($conteos['atenciones']); ?>
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="progress shadow-sm" style="height: 5px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%;"></div>
                                    </div>
                                </div>
                                <!--end card body-->
                            </div><!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <span class="badge badge-soft-dark float-right"><i class="fas fa-list"></i></span>
                                        <h5 class="card-title mb-0">Categorías</h5>
                                    </div>
                                    <div class="row d-flex align-items-center mb-4">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                <?php echo number_format($conteos['categoria']); ?>
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="progress shadow-sm" style="height: 5px;">
                                        <div class="progress-bar bg-dark" role="progressbar" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>
                                <!--end card body-->
                            </div>
                            <!--end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <span class="badge badge-soft-secondary float-right"><i class="fas fa-bong"></i></span>
                                        <h5 class="card-title mb-0">Laboratorios</h5>
                                    </div>
                                    <div class="row d-flex align-items-center mb-4">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                <?php echo number_format($conteos['laboratorio']); ?>
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="progress shadow-sm" style="height: 5px;">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 100%;"></div>
                                    </div>
                                </div>
                                <!--end card body-->
                            </div><!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <span class="badge badge-soft-warning float-right"><i class="fas fa-truck"></i></span>
                                        <h5 class="card-title mb-0">Proveedores</h5>
                                    </div>
                                    <div class="row d-flex align-items-center mb-4">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                <?php echo number_format($conteos['proveedores']); ?>
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="progress shadow-sm" style="height: 5px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;"></div>
                                    </div>
                                </div>
                                <!--end card body-->
                            </div><!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-4">
                                        <span class="badge badge-soft-primary float-right"><i class="fas fa-shopping-cart"></i></span>
                                        <h5 class="card-title mb-0">Ventas</h5>
                                    </div>
                                    <div class="row d-flex align-items-center mb-4">
                                        <div class="col-8">
                                            <h2 class="d-flex align-items-center mb-0">
                                                00
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="progress shadow-sm" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;"></div>
                                    </div>
                                </div>
                                <!--end card body-->
                            </div><!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Vencimiento</h4>
                                    <p class="card-subtitle mb-4 font-size-13">
                                        Productos a una semana de vencer y vencidos
                                    </p>

                                    <div class="table-responsive">
                                        <!-- Tabla para mostrar los medicamentos -->
                                        <table class="table table-centered table-striped table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th>COD</th>
                                                    <th>Producto</th>
                                                    <th>Vencimiento</th>
                                                    <th>Aviso</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Verificar si la consulta devuelve resultados
                                                if ($result->num_rows > 0) {
                                                    // Recorrer los resultados
                                                    while ($row = $result->fetch_assoc()) {
                                                        $id = $row['id'];
                                                        $nombre = $row['nombre'];
                                                        $vencimiento = $row['fecha_vencimiento'];
                                                        $aviso = '';
                                                        $clase = '';

                                                        //buscamos el insumo para determinar y es medicina o material medico
                                                        $consulta = "SELECT id FROM medicamentos WHERE id='$id' AND nombre='$nombre'";
                                                        $result_bb = $conn->query($consulta);
                                                        $boton = '';
                                                        if ($result_bb->num_rows > 0) {
                                                            $medicamentos = $result_bb->fetch_assoc();
                                                            $id_med = $medicamentos['id'];
                                                            $boton = '<a class="btn btn-sm btn-danger" href="../action/eliminar_medicamento.php?id=' . urlencode($medicamentos['id']) . '" title="Dar de Baja"><i class="fa fa-trash"></i></a>';
                                                        }
                                                        $consulta = "SELECT id FROM mmedicamentos WHERE id='$id' AND nombre='$nombre'";
                                                        $result_bb = $conn->query($consulta);
                                                        if ($result_bb->num_rows > 0) {
                                                            $medicamentos = $result_bb->fetch_assoc();
                                                            $id_mmed = $medicamentos['id'];
                                                            $boton = '<a class="btn btn-sm btn-danger" href="../action/eliminar_mmedico.php?id=' . urlencode($medicamentos['id']) . '" title="Dar de Baja"><i class="fa fa-trash"></i></a>';
                                                        }

                                                        // Verificar si el medicamento está vencido o por vencer
                                                        if ($vencimiento < $hoy) {
                                                            $aviso = 'Vencido';
                                                            $clase = 'btn btn-danger btn-sm'; // Fondo rojo
                                                            $button = $boton;
                                                        } elseif ($vencimiento <= $unaSemana) {
                                                            $aviso = 'Por Vencer';
                                                            $clase = 'btn btn-warning btn-sm'; // Fondo amarillo
                                                            $button = '';
                                                        }

                                                        // Mostrar la fila en la tabla
                                                        echo "<tr>
                <td>$id</td>
                <td>$nombre</td>
                <td>$vencimiento</td>
                <td><span class='$clase'>$aviso</span> $button</td>
              </tr>";
                                                    }
                                                } else {
                                                    // Si no hay medicamentos para mostrar
                                                    echo "<tr><td colspan='4' class='text-center'>No hay medicamentos próximos a vencer o vencidos.</td></tr>";
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                                <!--end card body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="card-title">Stock</h4>
                                    <p class="card-subtitle mb-4 font-size-13">
                                        Productos a 5 unidades de agotarse
                                    </p>

                                    <div class="table-responsive">
                                        <table class="table table-centered table-striped table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th>COD</th>
                                                    <th>Producto</th>
                                                    <th>Stock</th>
                                                    <th>Aviso</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Consulta SQL para obtener los medicamentos y mmedicamentos con stock menor o igual a 5
                                                $sql = "
                    (SELECT 
                        m.id, 
                        m.nombre, 
                        (m.cantidad_ingreso - IFNULL(SUM(ai.cantidad), 0)) AS stock
                    FROM 
                        medicamentos m
                    LEFT JOIN 
                        atencion_insumos ai ON m.nombre = ai.insumo_medico
                    GROUP BY 
                        m.id, m.nombre, m.cantidad_ingreso
                    HAVING 
                        stock <= 5)  -- Solo aquellos con stock menor o igual a 5

                    UNION

                    (SELECT 
                        mm.id, 
                        mm.nombre, 
                        (mm.cantidad_ingreso - IFNULL(SUM(ai.cantidad), 0)) AS stock
                    FROM 
                        mmedicamentos mm
                    LEFT JOIN 
                        atencion_insumos ai ON mm.nombre = ai.insumo_medico
                    GROUP BY 
                        mm.id, mm.nombre, mm.cantidad_ingreso
                    HAVING 
                        stock <= 5)  -- Solo aquellos con stock menor o igual a 5
                    ORDER BY stock ASC;
                ";

                                                $result = $conn->query($sql);

                                                if ($result && $result->num_rows > 0):
                                                    while ($medicamento = $result->fetch_assoc()):
                                                ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($medicamento['id']); ?></td>
                                                            <td><?php echo htmlspecialchars($medicamento['nombre']); ?></td>
                                                            <td><?php echo htmlspecialchars($medicamento['stock']); ?></td>
                                                            <td>
                                                                <?php
                                                                // Mostrar mensaje de aviso dependiendo del stock
                                                                if ($medicamento['stock'] == 0) {
                                                                    echo "<span class='btn btn-danger btn-sm'>Agotado</span>";
                                                                } else {
                                                                    echo "<span class='btn btn-warning btn-sm'>Por Agotar</span>";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php endwhile; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">No hay productos con bajo stock.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>



                                <!--end card body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->

                    </div>
                    <!-- end row-->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include '../layout/footer.php'; ?>

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


        <!-- Sparkline Js-->
        <script src="../plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

        <!-- Chart Js-->
        <script src="../plugins/jquery-knob/jquery.knob.min.js"></script>

        <!-- Chart Custom Js-->
        <script src="../assets/pages/knob-chart-demo.js"></script>

        <!-- Google Charts js -->
        <script src="https://www.gstatic.com/charts/loader.js"></script>

        <!-- Google chart custom js-->
        <script src="../assets/pages/google-chart-demo.js"></script>

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