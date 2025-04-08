<?php
// reset-password.php - Restablecer contraseña
require_once 'includes/config/db.php';
require_once 'includes/auth.php';

$auth = new Auth();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($token) {
        $error = 'Token inválido';
    } elseif (empty($password) {
        $error = 'La contraseña no puede estar vacía';
    } elseif ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden';
    } else {
        try {
            $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ATTR_ERRMODE_EXCEPTION);
            
            // Verificar token
            $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = :token AND used = 0 AND expires_at > NOW()");
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            
            if ($stmt->rowCount() === 1) {
                $reset = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Actualizar contraseña
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :user_id");
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':user_id', $reset['usuario_id']);
                $stmt->execute();
                
                // Marcar token como usado
                $stmt = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE token = :token");
                $stmt->bindParam(':token', $token);
                $stmt->execute();
                
                $success = 'Contraseña actualizada correctamente. Ahora puedes <a href="index.php">iniciar sesión</a>.';
            } else {
                $error = 'Token inválido o expirado';
            }
        } catch (PDOException $e) {
            $error = 'Error al procesar la solicitud: ' . $e->getMessage();
        }
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña | TecNM Ajalpan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #800020;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, #5a0015 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .reset-container {
            max-width: 500px;
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo {
            max-width: 120px;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="logo-container">
            <img src="assets/img/logo-tecnm.png" alt="TecNM Ajalpan" class="logo">
            <h4 class="mt-3">Restablecer Contraseña</h4>
        </div>
        
        <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <?php else: ?>
        
        <form method="POST" action="">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
            
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-key-fill"></i> Restablecer Contraseña
                </button>
            </div>
        </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
