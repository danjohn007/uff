<?php
/**
 * General Configuration
 * Uff! Platform - Commerce Platform with Privileged Access
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Application configuration
define('APP_NAME', 'Uff!');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost/uff');
define('BASE_PATH', __DIR__ . '/..');

// Security configuration
define('JWT_SECRET', 'your-secret-key-change-in-production');
define('ENCRYPTION_KEY', 'your-encryption-key-change-in-production');

// Email configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-password');
define('FROM_EMAIL', 'noreply@uff-platform.com');
define('FROM_NAME', 'Uff! Platform');

// PayPal configuration
define('PAYPAL_CLIENT_ID', 'your-paypal-client-id');
define('PAYPAL_CLIENT_SECRET', 'your-paypal-client-secret');
define('PAYPAL_MODE', 'sandbox'); // sandbox or live

// Google Maps API
define('GOOGLE_MAPS_API_KEY', 'your-google-maps-api-key');

// File upload configuration
define('UPLOAD_PATH', BASE_PATH . '/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx']);

// Card configuration
define('FREE_CARD_LIMIT', 5000); // MXN
define('SILVER_CARD_PRICE', 199); // MXN
define('GOLD_CARD_PRICE', 399); // MXN
define('DIAMOND_CARD_PRICE', 799); // MXN

// User roles
define('ROLE_SUPERADMIN', 1);
define('ROLE_GESTOR', 2);
define('ROLE_CAPTURISTA', 3);
define('ROLE_COMERCIO', 4);
define('ROLE_USUARIO', 5);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Timezone
date_default_timezone_set('America/Mexico_City');

// Auto-load classes
spl_autoload_register(function ($className) {
    $directories = [
        BASE_PATH . '/classes/',
        BASE_PATH . '/models/',
        BASE_PATH . '/controllers/',
        BASE_PATH . '/utils/'
    ];
    
    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Include database configuration
require_once __DIR__ . '/database.php';