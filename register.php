<?php
require_once 'config/config.php';

// Check if user is already logged in
if (Auth::isLoggedIn()) {
    header('Location: ' . Auth::getDashboardUrl());
    exit();
}

// Handle registration form submission
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'birth_date' => $_POST['birth_date'] ?? '',
        'password' => $_POST['password'] ?? '',
        'role_id' => ROLE_USUARIO
    ];
    
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validate data
    $errors = User::validateRegistration($userData);
    
    // Check password confirmation
    if ($userData['password'] !== $confirmPassword) {
        $errors[] = 'Las contraseñas no coinciden';
    }
    
    // Check if email already exists
    $userModel = new User();
    if ($userModel->emailExists($userData['email'])) {
        $errors[] = 'El email ya está registrado';
    }
    
    if (empty($errors)) {
        $result = $userModel->create($userData);
        
        if ($result['success']) {
            $success = 'Registro exitoso. Por favor, verifica tu email para activar tu cuenta.';
            // TODO: Send verification email
        } else {
            $error = $result['error'];
        }
    } else {
        $error = implode('<br>', $errors);
    }
}

// Get selected plan from URL
$selectedPlan = $_GET['plan'] ?? 'free';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Uff! Platform</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center py-5">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0">
                            <i class="fas fa-star text-warning me-2"></i>
                            Uff! Platform
                        </h3>
                        <p class="mb-0 mt-2">Crear Cuenta</p>
                    </div>
                    <div class="card-body p-5">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo htmlspecialchars($success); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Plan Selection -->
                        <div class="mb-4">
                            <h5 class="mb-3">Selecciona tu Plan</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="plan-option <?php echo $selectedPlan === 'free' ? 'active' : ''; ?>" data-plan="free">
                                        <div class="text-center p-3 border rounded">
                                            <i class="fas fa-star fa-2x text-secondary mb-2"></i>
                                            <h6>Gratis</h6>
                                            <p class="small mb-0">$0 / Para siempre</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="plan-option <?php echo $selectedPlan === 'silver' ? 'active' : ''; ?>" data-plan="silver">
                                        <div class="text-center p-3 border rounded">
                                            <i class="fas fa-medal fa-2x text-secondary mb-2"></i>
                                            <h6>Plata</h6>
                                            <p class="small mb-0">$199 / Año</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="plan-option <?php echo $selectedPlan === 'gold' ? 'active' : ''; ?>" data-plan="gold">
                                        <div class="text-center p-3 border rounded">
                                            <i class="fas fa-crown fa-2x text-warning mb-2"></i>
                                            <h6>Oro</h6>
                                            <p class="small mb-0">$399 / Año</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="plan-option <?php echo $selectedPlan === 'diamond' ? 'active' : ''; ?>" data-plan="diamond">
                                        <div class="text-center p-3 border rounded">
                                            <i class="fas fa-gem fa-2x text-info mb-2"></i>
                                            <h6>Diamante</h6>
                                            <p class="small mb-0">$799 / Año</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <form method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="csrf_token" value="<?php echo Auth::generateCSRFToken(); ?>">
                            <input type="hidden" id="selected_plan" name="selected_plan" value="<?php echo $selectedPlan; ?>">
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="full_name" class="form-label">
                                        <i class="fas fa-user me-2"></i>Nombre Completo *
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="full_name" 
                                           name="full_name" 
                                           value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>"
                                           placeholder="Nombre y Apellidos"
                                           required>
                                    <div class="invalid-feedback">
                                        Ingrese su nombre completo (mínimo 2 palabras).
                                    </div>
                                    <div class="form-text">Debe incluir nombre y apellido.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>Correo Electrónico *
                                    </label>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                           placeholder="tu@email.com"
                                           required>
                                    <div class="invalid-feedback">
                                        Ingrese un email válido.
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone me-2"></i>WhatsApp *
                                    </label>
                                    <input type="tel" 
                                           class="form-control" 
                                           id="phone" 
                                           name="phone" 
                                           value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                                           placeholder="+52 55 1234 5678"
                                           pattern="^\+[1-9]\d{1,14}$"
                                           required>
                                    <div class="invalid-feedback">
                                        Formato: +52 55 1234 5678
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="birth_date" class="form-label">
                                        <i class="fas fa-calendar me-2"></i>Fecha de Nacimiento *
                                    </label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="birth_date" 
                                           name="birth_date" 
                                           value="<?php echo htmlspecialchars($_POST['birth_date'] ?? ''); ?>"
                                           max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>"
                                           required>
                                    <div class="invalid-feedback">
                                        Debe ser mayor de 18 años.
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Contraseña *
                                    </label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control" 
                                               id="password" 
                                               name="password" 
                                               placeholder="••••••••"
                                               minlength="8"
                                               required>
                                        <button class="btn btn-outline-secondary" 
                                                type="button" 
                                                id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <div class="invalid-feedback">
                                            Mínimo 8 caracteres.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <label for="confirm_password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Confirmar Contraseña *
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           placeholder="••••••••"
                                           required>
                                    <div class="invalid-feedback">
                                        Las contraseñas deben coincidir.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        Acepto los <a href="#" target="_blank">Términos y Condiciones</a> 
                                        y la <a href="#" target="_blank">Política de Privacidad</a> *
                                    </label>
                                    <div class="invalid-feedback">
                                        Debe aceptar los términos y condiciones.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        Quiero recibir el boletín semanal con ofertas exclusivas
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                                </button>
                            </div>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="text-center">
                            <p class="mb-3">¿Ya tienes una cuenta?</p>
                            <a href="login.php" class="btn btn-outline-primary">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </a>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-center py-3">
                        <small class="text-muted">
                            <a href="index.html" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i>Volver al inicio
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    
    <script>
        // Plan selection
        document.querySelectorAll('.plan-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove active class from all options
                document.querySelectorAll('.plan-option').forEach(o => o.classList.remove('active'));
                
                // Add active class to clicked option
                this.classList.add('active');
                
                // Update hidden input
                document.getElementById('selected_plan').value = this.dataset.plan;
                
                // Update visual styling
                this.style.background = '#e3f2fd';
                this.style.borderColor = '#2196f3';
            });
        });
        
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Validate password confirmation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.setCustomValidity('Las contraseñas no coinciden');
            } else {
                this.setCustomValidity('');
            }
        });
        
        // Validate full name (minimum 2 words)
        document.getElementById('full_name').addEventListener('input', function() {
            const words = this.value.trim().split(/\s+/);
            if (words.length < 2 || words[1] === '') {
                this.setCustomValidity('Debe incluir nombre y apellido');
            } else {
                this.setCustomValidity('');
            }
        });
        
        // Phone number formatting
        document.getElementById('phone').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 0 && !value.startsWith('52')) {
                value = '52' + value;
            }
            this.value = '+' + value;
        });
    </script>
</body>
</html>