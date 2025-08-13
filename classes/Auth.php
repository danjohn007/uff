<?php
/**
 * Authentication Class
 * Handles user sessions and security
 */

class Auth {
    
    /**
     * Login user and create session
     */
    public static function login($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role_id'];
        $_SESSION['role_name'] = $user['role_name'];
        $_SESSION['permissions'] = json_decode($user['permissions'], true);
        $_SESSION['login_time'] = time();
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        return true;
    }
    
    /**
     * Logout user and destroy session
     */
    public static function logout() {
        session_unset();
        session_destroy();
        return true;
    }
    
    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Get current user ID
     */
    public static function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }
    
    /**
     * Get current user role
     */
    public static function getUserRole() {
        return $_SESSION['user_role'] ?? null;
    }
    
    /**
     * Get user permissions
     */
    public static function getPermissions() {
        return $_SESSION['permissions'] ?? [];
    }
    
    /**
     * Check if user has specific permission
     */
    public static function hasPermission($permission) {
        $permissions = self::getPermissions();
        return isset($permissions[$permission]) && $permissions[$permission] === true;
    }
    
    /**
     * Check if user has specific role
     */
    public static function hasRole($role) {
        if (is_array($role)) {
            return in_array(self::getUserRole(), $role);
        }
        return self::getUserRole() === $role;
    }
    
    /**
     * Require authentication
     */
    public static function requireAuth() {
        if (!self::isLoggedIn()) {
            self::redirect('/login.php');
        }
    }
    
    /**
     * Require specific role
     */
    public static function requireRole($role) {
        self::requireAuth();
        
        if (!self::hasRole($role)) {
            http_response_code(403);
            self::redirect('/unauthorized.php');
        }
    }
    
    /**
     * Require specific permission
     */
    public static function requirePermission($permission) {
        self::requireAuth();
        
        if (!self::hasPermission($permission)) {
            http_response_code(403);
            self::redirect('/unauthorized.php');
        }
    }
    
    /**
     * Get current user data
     */
    public static function getUser() {
        if (!self::isLoggedIn()) {
            return null;
        }
        
        $userModel = new User();
        return $userModel->getById(self::getUserId());
    }
    
    /**
     * Check if session is expired (4 hours)
     */
    public static function isSessionExpired() {
        if (!isset($_SESSION['login_time'])) {
            return true;
        }
        
        $sessionLifetime = 4 * 60 * 60; // 4 hours
        return (time() - $_SESSION['login_time']) > $sessionLifetime;
    }
    
    /**
     * Refresh session
     */
    public static function refreshSession() {
        if (self::isLoggedIn() && !self::isSessionExpired()) {
            $_SESSION['login_time'] = time();
            return true;
        }
        return false;
    }
    
    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Verify CSRF token
     */
    public static function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Generate password reset token
     */
    public static function generatePasswordResetToken($userId) {
        $token = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Store token in database (you would need a password_resets table)
        // For now, we'll just return the token
        return $token;
    }
    
    /**
     * Redirect helper
     */
    private static function redirect($location) {
        if (headers_sent()) {
            echo "<script>window.location.href = '$location';</script>";
        } else {
            header("Location: $location");
        }
        exit();
    }
    
    /**
     * Hash password
     */
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    /**
     * Verify password
     */
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Get user dashboard URL based on role
     */
    public static function getDashboardUrl() {
        $role = self::getUserRole();
        
        switch ($role) {
            case ROLE_SUPERADMIN:
                return '/admin/dashboard.php';
            case ROLE_GESTOR:
                return '/gestor/dashboard.php';
            case ROLE_CAPTURISTA:
                return '/capturista/dashboard.php';
            case ROLE_COMERCIO:
                return '/business/dashboard.php';
            case ROLE_USUARIO:
                return '/user/dashboard.php';
            default:
                return '/dashboard.php';
        }
    }
    
    /**
     * Log security event
     */
    public static function logSecurityEvent($event, $details = []) {
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'event' => $event,
            'user_id' => self::getUserId(),
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
            'details' => $details
        ];
        
        // Log to file or database
        error_log(json_encode($logData));
    }
}