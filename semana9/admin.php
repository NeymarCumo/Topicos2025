<?php
include 'conexion.php';

$sql = "INSERT INTO usuarios (email, password, rol) VALUES ('cumoreyesgiovanni7@gmail.com', '" . password_hash('gioreshesh', PASSWORD_DEFAULT) . "', 'admin')";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}else{
    echo "Admin added successfully";
}
?>