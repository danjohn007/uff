<?php
/**
 * User Model
 * Handles all user-related database operations
 */

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Create a new user
     */
    public function create($userData) {
        try {
            $sql = "INSERT INTO users (full_name, email, phone, birth_date, password_hash, role_id, email_verification_token) 
                    VALUES (:full_name, :email, :phone, :birth_date, :password_hash, :role_id, :email_verification_token)";
            
            $stmt = $this->db->prepare($sql);
            
            // Hash password
            $passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
            
            // Generate verification token
            $verificationToken = bin2hex(random_bytes(32));
            
            $stmt->execute([
                ':full_name' => $userData['full_name'],
                ':email' => $userData['email'],
                ':phone' => $userData['phone'],
                ':birth_date' => $userData['birth_date'],
                ':password_hash' => $passwordHash,
                ':role_id' => $userData['role_id'] ?? ROLE_USUARIO,
                ':email_verification_token' => $verificationToken
            ]);
            
            $userId = $this->db->lastInsertId();
            
            // Create free card for end users
            if (($userData['role_id'] ?? ROLE_USUARIO) == ROLE_USUARIO) {
                $this->createFreeCard($userId);
            }
            
            return [
                'success' => true,
                'user_id' => $userId,
                'verification_token' => $verificationToken
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Authenticate user login
     */
    public function authenticate($email, $password) {
        try {
            $sql = "SELECT u.*, ur.name as role_name, ur.permissions 
                    FROM users u 
                    JOIN user_roles ur ON u.role_id = ur.id 
                    WHERE u.email = :email AND u.status = 'active'";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                // Update last login
                $this->updateLastLogin($user['id']);
                
                // Remove sensitive data
                unset($user['password_hash']);
                unset($user['email_verification_token']);
                
                return [
                    'success' => true,
                    'user' => $user
                ];
            }
            
            return [
                'success' => false,
                'error' => 'Credenciales inválidas'
            ];
            
        } catch (PDOException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Get user by ID
     */
    public function getById($userId) {
        try {
            $sql = "SELECT u.*, ur.name as role_name, ur.permissions 
                    FROM users u 
                    JOIN user_roles ur ON u.role_id = ur.id 
                    WHERE u.id = :user_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $user = $stmt->fetch();
            
            if ($user) {
                unset($user['password_hash']);
                unset($user['email_verification_token']);
            }
            
            return $user;
            
        } catch (PDOException $e) {
            return null;
        }
    }
    
    /**
     * Verify email
     */
    public function verifyEmail($token) {
        try {
            $sql = "UPDATE users SET email_verified = 1, email_verification_token = NULL 
                    WHERE email_verification_token = :token";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':token' => $token]);
            
            return $stmt->rowCount() > 0;
            
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Update user profile
     */
    public function updateProfile($userId, $data) {
        try {
            $allowedFields = ['full_name', 'phone', 'birth_date', 'avatar'];
            $updateFields = [];
            $params = [':user_id' => $userId];
            
            foreach ($allowedFields as $field) {
                if (isset($data[$field])) {
                    $updateFields[] = "$field = :$field";
                    $params[":$field"] = $data[$field];
                }
            }
            
            if (empty($updateFields)) {
                return ['success' => false, 'error' => 'No hay campos para actualizar'];
            }
            
            $sql = "UPDATE users SET " . implode(', ', $updateFields) . " WHERE id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            
            return ['success' => true];
            
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Change password
     */
    public function changePassword($userId, $currentPassword, $newPassword) {
        try {
            // Verify current password
            $sql = "SELECT password_hash FROM users WHERE id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $user = $stmt->fetch();
            
            if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
                return ['success' => false, 'error' => 'Contraseña actual incorrecta'];
            }
            
            // Update password
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password_hash = :password_hash WHERE id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':password_hash' => $newPasswordHash,
                ':user_id' => $userId
            ]);
            
            return ['success' => true];
            
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Get user's active card
     */
    public function getUserCard($userId) {
        try {
            $sql = "SELECT uc.*, ct.name as card_type_name, ct.color, ct.discount_limit 
                    FROM user_cards uc 
                    JOIN card_types ct ON uc.card_type_id = ct.id 
                    WHERE uc.user_id = :user_id AND uc.status = 'active' 
                    ORDER BY uc.created_at DESC LIMIT 1";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            
            return $stmt->fetch();
            
        } catch (PDOException $e) {
            return null;
        }
    }
    
    /**
     * Validate user data
     */
    public static function validateRegistration($data) {
        $errors = [];
        
        // Full name validation (minimum 2 words)
        if (empty($data['full_name']) || str_word_count($data['full_name']) < 2) {
            $errors[] = 'El nombre completo debe tener al menos 2 palabras';
        }
        
        // Email validation
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email inválido';
        }
        
        // Phone validation (international format)
        if (empty($data['phone']) || !preg_match('/^\+[1-9]\d{1,14}$/', $data['phone'])) {
            $errors[] = 'Número de teléfono debe estar en formato internacional (+52...)';
        }
        
        // Birth date validation (18+ years)
        if (empty($data['birth_date'])) {
            $errors[] = 'Fecha de nacimiento es requerida';
        } else {
            $birthDate = new DateTime($data['birth_date']);
            $today = new DateTime();
            $age = $today->diff($birthDate)->y;
            
            if ($age < 18) {
                $errors[] = 'Debe ser mayor de 18 años';
            }
        }
        
        // Password validation
        if (empty($data['password']) || strlen($data['password']) < 8) {
            $errors[] = 'La contraseña debe tener al menos 8 caracteres';
        }
        
        return $errors;
    }
    
    /**
     * Check if email exists
     */
    public function emailExists($email) {
        try {
            $sql = "SELECT id FROM users WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            return $stmt->fetch() !== false;
            
        } catch (PDOException $e) {
            return true; // Assume exists on error for safety
        }
    }
    
    /**
     * Private helper methods
     */
    private function updateLastLogin($userId) {
        try {
            $sql = "UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = :user_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
        } catch (PDOException $e) {
            // Ignore login update errors
        }
    }
    
    private function createFreeCard($userId) {
        try {
            $cardNumber = 'UFF' . str_pad(1, 4, '0', STR_PAD_LEFT) . str_pad($userId, 6, '0', STR_PAD_LEFT);
            $qrCode = 'QR' . str_pad(1, 3, '0', STR_PAD_LEFT) . str_pad($userId, 6, '0', STR_PAD_LEFT);
            
            $sql = "INSERT INTO user_cards (user_id, card_type_id, card_number, qr_code, payment_status, expiry_date) 
                    VALUES (:user_id, 1, :card_number, :qr_code, 'completed', DATE_ADD(NOW(), INTERVAL 12 MONTH))";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_id' => $userId,
                ':card_number' => $cardNumber,
                ':qr_code' => $qrCode
            ]);
            
        } catch (PDOException $e) {
            // Ignore card creation errors for now
        }
    }
}