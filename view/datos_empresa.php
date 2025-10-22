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
                                <h4 class="mb-0 font-size-18">Datos de la Empresa</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">SISTOPI</a></li>
                                        <li class="breadcrumb-item active">Datos de la Empresa</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-pricing">
                            <div class="card-body" style="text-align: center;">
                                    <img src="../assets/images/Logo_Sistopi.jpg" alt="Logo" style="width: 6%;">
                                    <h4 class="font-weight-bold mt-4 text-uppercase">DATOS DEL SISTEMA</h4>
                                    <p class="text-muted mt-3 mb-4" style="text-align: justify;">
                                        El Sistema de Tópico Institucional es una plataforma web diseñada para registrar y gestionar de forma
                                        ordenada las atenciones médicas brindadas dentro del instituto. Permite al personal del tópico registrar
                                        datos de pacientes, registrar procedimientos realizados, controlar el uso de insumos médicos y generar
                                        reportes automáticos. Su interfaz es sencilla, segura y accesible desde cualquier computadora conectada
                                        a internet.
                                    </p>
                                    <table border="1" cellpadding="8" cellspacing="0" style="margin: auto;">
                                        <thead style="background-color:#f2f2f2;">
                                            <tr>
                                                <th>Característica</th>
                                                <th>Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Nombre del sistema</td>
                                                <td>(SISTOPI) Sistema de Tópico Institucional</td>
                                            </tr>
                                            <tr>
                                                <td>Objetivo</td>
                                                <td>Optimizar el registro y control de atenciones médicas</td>
                                            </tr>
                                            <tr>
                                                <td>Usuarios</td>
                                                <td>Personal de tópico autorizado</td>
                                            </tr>
                                            <tr>
                                                <td>Funciones principales</td>
                                                <td>Registro de atenciones, gestión de insumos, reportes</td>
                                            </tr>
                                            <tr>
                                                <td>Plataforma</td>
                                                <td>Web (acceso mediante navegador)</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- end Pricing_card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

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