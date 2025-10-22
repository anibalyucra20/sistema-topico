<?php
// Iniciar sesión si no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Redirigir a la página de login si no hay sesión activa
    header("Location: login.php");
    exit;
} else {
    // Regenerar el ID de la sesión para evitar problemas de sesión en dispositivos móviles
    session_regenerate_id(true);
}
?>

<header id="page-topbar">
    <div class="navbar-header">

        <div class="d-flex align-items-left">
            <button type="button" class="btn btn-sm mr-2 d-lg-none px-3 font-size-16 header-item waves-effect"
                id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex align-items-center">

            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn header-item waves-effect"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="../assets/images/users/icon-user.png"
                                    alt="Img-User">
                    <!-- Mostrar el nombre del usuario que ha iniciado sesión -->
                    <span class="d-none d-sm-inline-block ml-1" >
                        <?php echo htmlspecialchars($_SESSION['usuario']); ?>
                    </span>
                    <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="../logout.php">
                        <span><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</header>
