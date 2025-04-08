<?php
// conexion.php
$servername = "localhost";
$username = "cumoreyesgiovanni7@gmail.com";
$password = "neycushesh";
$dbname = "asistencias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar formulario de login si se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Prevenir inyección SQL
    $email = mysqli_real_escape_string($conn, $email);
    
    // Consulta para verificar credenciales
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verificar contraseña (asumiendo que está hasheada)
        if (password_verify($password, $row['password'])) {
            // Iniciar sesión y redirigir
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_role'] = $row['role'];
            
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>showAlert('loginAlert', 'danger', 'Credenciales incorrectas');</script>";
        }
    } else {
        echo "<script>showAlert('loginAlert', 'danger', 'Usuario no encontrado');</script>";
    }
}

$conn->close();
?>