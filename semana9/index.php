<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Asistencia | TecNM Campus Ajalpan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color:rgb(32, 0, 128);
            --primary-dark: #5a0015;
            --primary-light: #a3435a;
            --secondary-color: #343a40;
            --light-gray: #f8f9fa;
            --dark-gray: #6c757d;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        }
        
        body {
            background: linear-gradient(135deg, #800020 0%,rgb(3, 0, 90) 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-card {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
        }
        
        .card-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #ffcc00 0%, #ff9900 100%);
        }
        
        .logo {
            height: 60px;
            margin-bottom: 15px;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-control {
            height: 48px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding-left: 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(128, 0, 32, 0.2);
        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            height: 48px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        
        .btn-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .input-group-text {
            background: transparent;
            border-right: none;
            cursor: pointer;
        }
        
        .password-container {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--dark-gray);
            z-index: 5;
        }
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.4s;
        }
        
        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .close {
            color: var(--dark-gray);
            float: right;
            font-size: 24px;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .close:hover {
            color: var(--primary-color);
            transform: rotate(90deg);
        }
        
        .alert {
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 20px;
            display: none;
        }
        
        .alert-success {
            background-color: #e6ffed;
            color: #1a7f37;
            border: 1px solid #a7f3b0;
        }
        
        .alert-danger {
            background-color: #ffebe9;
            color: #cf222e;
            border: 1px solid #ffc1c0;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            color: var(--dark-gray);
            font-size: 0.85rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-card {
                border-radius: 12px;
            }
            
            .card-body {
                padding: 25px;
            }
            
            .modal-content {
                margin: 20% auto;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="card-header">
            <img src="assets/img/logo-tecnm.png" alt="TecNM Logo" class="logo">
            <h4>Sistema de Control de Asistencia</h4>
        </div>
        
        <div class="card-body">
            <div id="loginAlert" class="alert"></div>
            
            <form id="loginForm" action="conexion.php" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Institucional</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="usuario@tecnm.edu.mx">
                    </div>
                    <div class="invalid-feedback">Ingrese un correo válido</div>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="password-container">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Ingrese su contraseña">
                        </div>
                        <span class="password-toggle" id="togglePassword">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                    <div class="invalid-feedback">Ingrese su contraseña</div>
                </div>
                
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary" id="loginButton">
                        <i class="fas fa-sign-in-alt me-2"></i> INGRESAR
                    </button>
                </div>
                
                <div class="text-center">
                    <a href="#" class="btn-link" onclick="openModal()">
                        <i class="fas fa-question-circle me-1"></i> Recuperar contraseña
                    </a>
                </div>
            </form>
            
            <div class="footer">
                <p>Tecnológico Nacional de México Campus Ajalpan © 2025</p>
            </div>
        </div>
    </div>

    <!-- Password Recovery Modal -->
    <div id="recoveryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h4 class="mb-4"><i class="fas fa-key me-2"></i> Recuperación de Contraseña</h4>
            
            <div id="recoveryAlert" class="alert"></div>
            
            <form id="recoveryForm">
                <div class="mb-3">
                    <label for="recoveryUsername" class="form-label">Nombre de Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="recoveryUsername" required placeholder="Ingrese su nombre de usuario">
                    </div>
                    <div class="invalid-feedback">Ingrese su nombre de usuario</div>
                </div>
                
                <div class="mb-3">
                    <label for="recoveryEmail" class="form-label">Correo Institucional</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="recoveryEmail" required placeholder="usuario@tecnm.edu.mx">
                    </div>
                    <div class="invalid-feedback">Ingrese un correo válido</div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i> ENVIAR SOLICITUD
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Form validation for login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            let isValid = true;
            
            // Reset validation
            email.classList.remove('is-invalid');
            password.classList.remove('is-invalid');
            
            // Validate email
            if (!email.value || !/^\S+@\S+\.\S+$/.test(email.value)) {
                email.classList.add('is-invalid');
                isValid = false;
            }
            
            // Validate password
            if (!password.value) {
                password.classList.add('is-invalid');
                isValid = false;
            }
            
            if (isValid) {
                // Show loading state
                const loginButton = document.getElementById('loginButton');
                loginButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> VERIFICANDO...';
                loginButton.disabled = true;
                
                // Simulate AJAX submission (replace with actual AJAX call)
                setTimeout(() => {
                    // This is where you would normally make an AJAX call to conexion.php
                    // For demonstration, we'll just show a success message
                    
                    // Show success message
                    showAlert('loginAlert', 'success', 'Inicio de sesión exitoso. Redireccionando...');
                    
                    // Reset button
                    loginButton.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i> INGRESAR';
                    loginButton.disabled = false;
                    
                    // In a real scenario, you would redirect or handle the response here
                    // window.location.href = 'dashboard.php';
                }, 1500);
            }
        });
        
        // Password recovery form
        document.getElementById('recoveryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('recoveryUsername');
            const email = document.getElementById('recoveryEmail');
            let isValid = true;
            
            // Reset validation
            username.classList.remove('is-invalid');
            email.classList.remove('is-invalid');
            
            // Validate username
            if (!username.value) {
                username.classList.add('is-invalid');
                isValid = false;
            }
            
            // Validate email
            if (!email.value || !/^\S+@\S+\.\S+$/.test(email.value)) {
                email.classList.add('is-invalid');
                isValid = false;
            }
            
            if (isValid) {
                // Show loading state
                const recoveryButton = this.querySelector('button[type="submit"]');
                recoveryButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> PROCESANDO...';
                recoveryButton.disabled = true;
                
                // Prepare data for email
                const subject = encodeURIComponent("Solicitud de recuperación de contraseña - TecNM Ajalpan");
                const body = encodeURIComponent(`Usuario: ${username.value}\nCorreo electrónico: ${email.value}\n\nPor favor, restablezca mi contraseña para el Sistema de Asistencia del TecNM Campus Ajalpan.`);
                
                // Create mailto link
                const mailtoLink = `mailto:soporte@tecnm.edu.mx?subject=${subject}&body=${body}`;
                
                // Open email client
                window.location.href = mailtoLink;
                
                // Show success message
                showAlert('recoveryAlert', 'success', 'Se ha abierto su cliente de correo. Por favor envíe la solicitud para recuperar su contraseña.');
                
                // Reset button
                recoveryButton.innerHTML = '<i class="fas fa-paper-plane me-2"></i> ENVIAR SOLICITUD';
                recoveryButton.disabled = false;
                
                // Close modal after 5 seconds
                setTimeout(closeModal, 5000);
            }
        });
        
        // Modal functions
        function openModal() {
            document.getElementById('recoveryModal').style.display = 'block';
            // Reset form when opening
            document.getElementById('recoveryForm').reset();
            document.getElementById('recoveryAlert').style.display = 'none';
        }
        
        function closeModal() {
            document.getElementById('recoveryModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == document.getElementById('recoveryModal')) {
                closeModal();
            }
        }
        
        // Show alert message
        function showAlert(elementId, type, message) {
            const alertElement = document.getElementById(elementId);
            alertElement.textContent = message;
            alertElement.className = `alert alert-${type}`;
            alertElement.style.display = 'block';
            
            // Hide alert after 5 seconds
            setTimeout(() => {
                alertElement.style.display = 'none';
            }, 5000);
        }
    </script>
</body>
</html>
