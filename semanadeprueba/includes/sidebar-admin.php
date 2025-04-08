<?php
// includes/sidebar-admin.php - Barra lateral para administración
?>
<div class="sidebar">
    <div class="p-4">
        <div class="text-center mb-4">
            <img src="../assets/img/logo-tecnm.png" alt="TecNM Ajalpan" class="img-fluid mb-2" style="max-height: 80px;">
            <h5>Sistema de Asistencia</h5>
        </div>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="../dashboard.php">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="maestros.php">
                    <i class="bi bi-person-badge"></i> Maestros
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="materias.php">
                    <i class="bi bi-book"></i> Materias
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-people"></i> Alumnos
                </a>
            </li>
            <li class="nav-item mt-4">
                <a class="nav-link text-danger" href="../includes/logout.php">
                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                </a>
            </li>
        </ul>
    </div>
</div>