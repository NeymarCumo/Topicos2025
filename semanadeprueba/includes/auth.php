<?php
// includes/auth.php - Sistema de autenticación para TecNM Ajalpan

class Auth {
    private $pdo;
    
    public function __construct() {
        require_once 'config/db.php';
        try {
            $this->pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ATTR_ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    /**
     * Autentica a un usuario
     */
    public function login($email, $password) {
        try {
            // Buscar usuario en la base de datos
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email AND activo = 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verificar contraseña
                if (password_verify($password, $user['password'])) {
                    // Iniciar sesión
                    session_start();
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_name'] = $user['nombre'];
                    $_SESSION['user_role'] = $user['rol'];
                    
                    // Registrar el acceso
                    $this->registerAccess($user['id']);
                    
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Registra un acceso en el sistema
     */
    private function registerAccess($userId) {
        try {
            $ip = $_SERVER['REMOTE_ADDR'];
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $now = date('Y-m-d H:i:s');
            
            $stmt = $this->pdo->prepare("INSERT INTO accesos (usuario_id, fecha_acceso, ip, navegador) 
                                        VALUES (:user_id, :fecha, :ip, :navegador)");
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':fecha', $now);
            $stmt->bindParam(':ip', $ip);
            $stmt->bindParam(':navegador', $browser);
            $stmt->execute();
            
            return true;
        } catch (PDOException $e) {
            error_log("Error registrando acceso: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Cierra la sesión del usuario
     */
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        return true;
    }
    
    /**
     * Envía correo para recuperar contraseña
     */
    public function sendRecoveryEmail($email, $matricula) {
        try {
            // Verificar que el usuario existe
            $stmt = $this->pdo->prepare("SELECT id, nombre FROM usuarios WHERE email = :email AND matricula = :matricula");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':matricula', $matricula);
            $stmt->execute();
            
            if ($stmt->rowCount() == 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Generar token de recuperación
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Guardar token en la base de datos
                $stmt = $this->pdo->prepare("INSERT INTO password_resets (usuario_id, token, expires_at) 
                                           VALUES (:user_id, :token, :expires)");
                $stmt->bindParam(':user_id', $user['id']);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':expires', $expires);
                $stmt->execute();
                
                // Enviar correo electrónico (simulado)
                $resetLink = "https://" . $_SERVER['HTTP_HOST'] . "/reset-password.php?token=" . $token;
                
                // En producción, usar una librería como PHPMailer
                $to = $email;
                $subject = "Recuperación de contraseña - TecNM Ajalpan";
                $message = "Hola " . $user['nombre'] . ",\n\n";
                $message .= "Para restablecer tu contraseña, haz clic en el siguiente enlace:\n";
                $message .= $resetLink . "\n\n";
                $message .= "Este enlace expirará en 1 hora.\n\n";
                $message .= "Si no solicitaste este cambio, ignora este mensaje.\n";
                $headers = "From: no-reply@tecnmajalpan.edu.mx";
                
                // mail($to, $subject, $message, $headers); // Descomentar en producción
                
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error en recuperación: " . $e->getMessage());
            return false;
        }
    }
}
?>
