<?php
// conexion.php
session_start();

// Configuración de la base de datos
$servername = "localhost";
$username = "cumoreyesgiovanni7@gmail.com";
$password = "gioreshesh";
$dbname = "asistencias";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conn->connect_error]));
}

// Procesar formulario de login si se envió
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    // Consulta para verificar credenciales
    $sql = "SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificar contraseña (asumiendo que está hasheada)
        if (password_verify($password, $user['password'])) {
            // Iniciar sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['rol'];
            
            // Redirigir según el rol
            if ($user['rol'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit();
        } else {
            echo "<script>showAlert('loginAlert', 'danger', 'Credenciales incorrectas');</script>";
        }
    } else {
        echo "<script>showAlert('loginAlert', 'danger', 'Usuario no encontrado');</script>";
    }
    
    $stmt->close();
}

$conn->close();
?>