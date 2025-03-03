<?php
// Parámetros del servidor local
$localhost = "localhost";
$user = "root";
$password = "";
$db = "demo1";

// Conexión a la base de datos
$conexion = mysqli_connect($localhost, $user, $password, $db);

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
} else {
    echo "Conexión exitosa a la base de datos<br>";
}

// Consulta para obtener datos de una tabla (ejemplo: 'usuarios')
$query = "SELECT * FROM usuarios"; // Asegúrate de que la tabla 'usuarios' existe en tu BD
$resultado = mysqli_query($conexion, $query);

// Mostrar datos
if (mysqli_num_rows($resultado) > 0) {
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "ID: " . $fila['id'] . " - Nombre: " . $fila['nombre'] . "<br>";
    }
} else {
    echo "No hay datos en la tabla.";
}

// Cerrar conexión
mysqli_close($conexion);
?>
