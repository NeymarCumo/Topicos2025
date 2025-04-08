<?php
// includes/logout.php - Cerrar sesión
require_once 'auth.php';

$auth = new Auth();
$auth->logout();

header('Location: ../index.php');
exit();