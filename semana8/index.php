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
            --primary-color: #800020;
            --primary-dark: #5a0015;
            --secondary-color: #343a40;
            --light-gray: #f8f9fa;
            --dark-gray: #6c757d;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), 
                              url('https://www.tecnm.mx/wp-content/themes/tecnm/images/logo-tecnm.png');
            background-size: 20%;
            background-position: right bottom;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .login-container {
            max-width: 450px;
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
            transition: all 0.3s ease;
        }
        
        .login-container:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo {
            max-width: 120px;
            margin-bottom: 1rem;
        }
        
        .title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .subtitle {
            color: var(--dark-gray);
            font-size: 1rem;
            margin-bottom: 2rem;
        }
        
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 1.2rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(128, 0, 32, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
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
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: var(--dark-gray);
        }
        
        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ddd;
        }
        
        .divider::before {
            margin-right: 1rem;
        }
        
        .divider::after {
            margin-left: 1rem;
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
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            animation: modalopen 0.4s;
        }
        
        @keyframes modalopen {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .close:hover, .close:focus {
            color: var(--primary-dark);
            text-decoration: none;
            cursor: pointer;
            transform: rotate(90deg);
        }
        
        .modal-title {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .footer {
            text-align: center;
            margin-top: 2rem;
            color: var(--dark-gray);
            font-size: 0.9rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 576px) {
            .login-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            .modal-content {
                margin: 20% auto;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-8 col-lg-6">
                <div class="login-container">
                    <div class="logo-container">
                        <img src="assets/img/logo-tecnm.png" alt="TecNM Logo" class="logo">
                        <h2 class="title">Sistema de Asistencia</h2>
                        <p class="subtitle">Tecnológico Nacional de México Campus Ajalpan</p>
                    </div>
                    
                    <div id="loginAlert" class="alert"></div>
                    
                    <form id="loginForm" action="conexion.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="usuario@tecnm.mx">
                            <div class="invalid-feedback">Por favor ingrese un correo válido</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Ingrese su contraseña">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">Por favor ingrese su contraseña</div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary" id="loginButton">
                                <i class="fas fa-sign-in-alt me-2"></i>Ingresar
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="#" class="btn-link" onclick="openModal()">
                            <i class="fas fa-key me-1"></i>Recuperar contraseña
                        </a>
                    </div>
                    
                    <div class="footer">
                        <p>© 2023 TecNM Campus Ajalpan. Todos los derechos reservados.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Recovery Modal -->
    <div id="recoveryModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 class="modal-title"><i class="fas fa-key me-2"></i>Recuperar Contraseña</h3>
            
            <div id="recoveryAlert" class="alert"></div>
            
            <form id="recoveryForm">
                <div class="mb-3">
                    <label for="recoveryUsername" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="recoveryUsername" required placeholder="Ingrese su nombre de usuario">
                    <div class="invalid-feedback">Por favor ingrese su nombre de usuario</div>
                </div>
                <div class="mb-3">
                    <label for="recoveryEmail" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="recoveryEmail" required placeholder="usuario@tecnm.mx">
                    <div class="invalid-feedback">Por favor ingrese un correo válido</div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Enviar Solicitud
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
                loginButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verificando...';
                loginButton.disabled = true;
                
                // Simulate AJAX submission (replace with actual AJAX call)
                setTimeout(() => {
                    // This is where you would normally make an AJAX call to conexion.php
                    // For demonstration, we'll just show a success message
                    
                    // Show success message
                    showAlert('loginAlert', 'success', 'Inicio de sesión exitoso. Redireccionando...');
                    
                    // Reset button
                    loginButton.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Ingresar';
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
                recoveryButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';
                recoveryButton.disabled = true;
                
                // Prepare data for email
                const subject = encodeURIComponent("Solicitud de recuperación de contraseña");
                const body = encodeURIComponent(`Usuario: ${username.value}\nCorreo electrónico: ${email.value}\n\nPor favor, restablezca mi contraseña para el Sistema de Asistencia del TecNM Ajalpan.`);
                
                // Create mailto link
                const mailtoLink = `mailto:arturobl00@msn.com?subject=${subject}&body=${body}`;
                
                // Open email client
                window.location.href = mailtoLink;
                
                // Show success message
                showAlert('recoveryAlert', 'success', 'Se ha abierto su cliente de correo. Por favor envíe la solicitud para recuperar su contraseña.');
                
                // Reset button
                recoveryButton.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Enviar Solicitud';
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