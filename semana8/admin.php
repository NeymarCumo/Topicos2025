<?php
include 'conexion.php';

$sql = "INSERT INTO usuarios (nombre, email, password, rol) VALUES ('Giovanni','cumoreyesgiovanni7@gmail.com', '" . password_hash('neycushesh', PASSWORD_DEFAULT) . "', 'administrador')";
$result = mysqli_query($conexion, $sql);

if (!$result) {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}else{
    echo "Admin added successfully";
}
?>