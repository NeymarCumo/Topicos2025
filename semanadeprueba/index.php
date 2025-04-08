<?php
// index.php - Sistema de Asistencia TecNM Campus Ajalpan

// Verificar si ya está logueado
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}

// Procesar el formulario de login si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    require_once 'includes/auth.php';
    $auth = new Auth();
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    if ($auth->login($email, $password)) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Credenciales incorrectas. Por favor intente nuevamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Asistencia | TecNM Campus Ajalpan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #800020; /* Color vino institucional */
            --secondary-color: #343a40; /* Gris oscuro */
            --accent-color: #d4af37; /* Dorado para acentos */
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-color) 0%, #5a0015 100%);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            max-width: 450px;
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            color: var(--secondary-color);
            animation: fadeIn 0.5s ease-in-out;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo {
            max-width: 120px;
            margin-bottom: 1rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #5a0015;
            border-color: #5a0015;
            transform: translateY(-2px);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(128, 0, 32, 0.25);
        }
        
        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .forgot-password:hover {
            color: #5a0015;
            text-decoration: underline;
        }
        
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        
        .modal-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        
        .btn-close {
            filter: invert(1);
        }
        
        .input-group-text {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 1rem;
            background-color: rgba(0, 0, 0, 0.2);
            color: white;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="logo-container">
                <!-- Reemplaza con el logo real del TecNM Ajalpan -->
                <img src="assets/img/logo-tecnm.png" alt="TecNM Campus Ajalpan" class="logo">
                <h3 class="mb-3">Sistema de Asistencia</h3>
                <h5 class="text-muted">TecNM Campus Ajalpan</h5>
            </div>
            
            <?php if (isset($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $error_message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <input type="hidden" name="login" value="1">
                
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Institucional</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="usuario@tecnmajalpan.edu.mx" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
                    </div>
                </div>
                
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                    </button>
                </div>
                
                <div class="text-center">
                    <a href="#" class="forgot-password" data-bs-toggle="modal" data-bs-target="#recoveryModal">
                        <i class="bi bi-question-circle"></i> ¿Olvidaste tu contraseña?
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal de Recuperación de Contraseña -->
    <div class="modal fade" id="recoveryModal" tabindex="-1" aria-labelledby="recoveryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recoveryModalLabel">
                        <i class="bi bi-key-fill"></i> Recuperar Contraseña
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="recoveryForm">
                        <div class="mb-3">
                            <label for="recoveryEmail" class="form-label">Correo Institucional</label>
                            <input type="email" class="form-control" id="recoveryEmail" placeholder="usuario@tecnmajalpan.edu.mx" required>
                        </div>
                        <div class="mb-3">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="text" class="form-control" id="matricula" placeholder="Ingresa tu matrícula" required>
                        </div>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill"></i> Se enviarán instrucciones a tu correo institucional.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="sendRecoveryEmail()">
                        <i class="bi bi-send-fill"></i> Enviar Solicitud
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p class="mb-0">© <?= date('Y') ?> TecNM Campus Ajalpan | Versión 2.0</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function sendRecoveryEmail() {
            const email = document.getElementById('recoveryEmail').value;
            const matricula = document.getElementById('matricula').value;
            
            if (!email || !matricula) {
                alert('Por favor complete todos los campos.');
                return;
            }
            
            // Aquí iría la lógica para enviar la solicitud al servidor
            // Por ahora simulamos el envío
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('recoveryModal'));
            modal.hide();
            
            // Mostrar alerta de éxito
            const alertPlaceholder = document.createElement('div');
            alertPlaceholder.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> Solicitud enviada. Revisa tu correo electrónico.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            document.body.appendChild(alertPlaceholder);
            
            // Eliminar la alerta después de 5 segundos
            setTimeout(() => {
                alertPlaceholder.remove();
            }, 5000);
        }
    </script>
</body>
</html> 
