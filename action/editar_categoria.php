<?php
// Incluir archivo de conexión a la base de datos
include '../services/conexion.php';

// Verificar si se recibió un ID y obtener los datos de la categoría
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Preparar la consulta para obtener la categoría
    $stmt = $conn->prepare("SELECT nombre, tipo FROM categoria WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nombre, $tipo);
    $stmt->fetch();
    $stmt->close();
}

// Verificar si el formulario fue enviado para actualizar la categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nombre']) && isset($_POST['tipo'])) {
        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        
        // Preparar la consulta para actualizar la categoría
        $stmt = $conn->prepare("UPDATE categoria SET nombre = ?, tipo = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nombre, $tipo, $id);
        
        if ($stmt->execute()) {
            // Redirigir a categorias.php después de una actualización exitosa
            header("Location: ../view/categorias.php");
            exit;
        } else {
            echo "Error al actualizar la categoría.";
        }
        
        $stmt->close();
    }
}

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
                                <h4 class="mb-0 font-size-18">Editar Categoría <i class="fas fa-list"></i></h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Editar Categoría</li>
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
                                    <h4 class="card-title">Editar Categoría</h4>
                                    <p class="card-subtitle mb-4">Modificar los datos y guardar cambios.</p>
                                    
                                    <!-- Formulario para editar la categoría -->
                                    <form class="needs-validation" method="POST" novalidate>
                                        <div class="form-row">
                                            <div class="col-md-5 mb-3">
                                                <label for="nombre">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label for="tipo">Tipo</label>
                                                <select class="form-control" id="tipo" name="tipo" required>
                                                    <option value="Sin Receta" <?php if ($tipo == 'Sin Receta') echo 'selected'; ?>>Sin Receta</option>
                                                    <option value="Con Receta" <?php if ($tipo == 'Con Receta') echo 'selected'; ?>>Con Receta</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                                        <a href="../view/categorias.php" class="btn btn-danger waves-effect waves-light">Cancelar</a>
                                    </form>
                                </div> <!-- end card-body-->
                            </div> <!-- end card -->
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include '../layout/footer.php'; ?>
        </div>
        <!-- END layout-wrapper -->

        <!-- Overlay-->
        <div class="menu-overlay"></div>

        <!-- Scripts -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/metismenu.min.js"></script>
        <script src="../assets/js/waves.js"></script>
        <script src="../assets/js/simplebar.min.js"></script>
        <script src="../assets/js/theme.js"></script>
</body>

</html>
