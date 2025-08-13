-- Uff! Platform Database Schema
-- Commerce Platform with Privileged Access
-- MySQL 5.7+ / 8.0+

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Create database
CREATE DATABASE IF NOT EXISTS `uff_platform` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `uff_platform`;

-- ==========================================
-- User Roles Table
-- ==========================================
CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `permissions` json,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Users Table
-- ==========================================
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `birth_date` date NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `email_verification_token` varchar(255),
  `avatar` varchar(255),
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `last_login` timestamp NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  KEY `fk_users_role` (`role_id`),
  CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Business Categories Table
-- ==========================================
CREATE TABLE `business_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `icon` varchar(100),
  `color` varchar(7),
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Businesses Table
-- ==========================================
CREATE TABLE `businesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `business_type` varchar(100) NOT NULL,
  `category_id` int(11),
  `rfc` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `country` varchar(100) DEFAULT 'México',
  `latitude` decimal(10, 8),
  `longitude` decimal(11, 8),
  `legal_representative` varchar(255) NOT NULL,
  `representative_id` varchar(20) NOT NULL,
  `business_hours` json,
  `logo` varchar(255),
  `images` json,
  `description` text,
  `benefits_offered` text,
  `verification_status` enum('pending','verified','rejected') DEFAULT 'pending',
  `verification_documents` json,
  `verification_notes` text,
  `verified_at` timestamp NULL,
  `verified_by` int(11),
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rfc` (`rfc`),
  KEY `fk_businesses_user` (`user_id`),
  KEY `fk_businesses_category` (`category_id`),
  KEY `fk_businesses_verifier` (`verified_by`),
  CONSTRAINT `fk_businesses_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_businesses_category` FOREIGN KEY (`category_id`) REFERENCES `business_categories` (`id`),
  CONSTRAINT `fk_businesses_verifier` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Card Types Table
-- ==========================================
CREATE TABLE `card_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `discount_limit` decimal(10, 2) NOT NULL,
  `color` varchar(7) NOT NULL,
  `benefits` json,
  `is_physical` tinyint(1) DEFAULT 0,
  `physical_cost` decimal(10, 2) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- User Cards Table
-- ==========================================
CREATE TABLE `user_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `card_type_id` int(11) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `qr_code` varchar(255) NOT NULL,
  `used_amount` decimal(10, 2) DEFAULT 0,
  `physical_requested` tinyint(1) DEFAULT 0,
  `physical_shipped` tinyint(1) DEFAULT 0,
  `shipping_address` text,
  `shipping_cost` decimal(10, 2) DEFAULT 0,
  `payment_id` varchar(255),
  `payment_status` enum('pending','completed','failed','refunded') DEFAULT 'pending',
  `expiry_date` date,
  `status` enum('active','expired','suspended') DEFAULT 'active',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `card_number` (`card_number`),
  UNIQUE KEY `qr_code` (`qr_code`),
  KEY `fk_cards_user` (`user_id`),
  KEY `fk_cards_type` (`card_type_id`),
  CONSTRAINT `fk_cards_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_cards_type` FOREIGN KEY (`card_type_id`) REFERENCES `card_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Promotions Table
-- ==========================================
CREATE TABLE `promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10, 2) NOT NULL,
  `minimum_purchase` decimal(10, 2) DEFAULT 0,
  `max_discount` decimal(10, 2),
  `valid_from` date NOT NULL,
  `valid_until` date NOT NULL,
  `usage_limit` int(11),
  `times_used` int(11) DEFAULT 0,
  `applicable_card_types` json,
  `terms_conditions` text,
  `image` varchar(255),
  `status` enum('active','inactive','expired') DEFAULT 'active',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_promotions_business` (`business_id`),
  KEY `idx_promotions_dates` (`valid_from`, `valid_until`),
  CONSTRAINT `fk_promotions_business` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Transactions Table
-- ==========================================
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `card_id` int(11) NOT NULL,
  `promotion_id` int(11),
  `transaction_code` varchar(50) NOT NULL,
  `original_amount` decimal(10, 2) NOT NULL,
  `discount_amount` decimal(10, 2) NOT NULL,
  `final_amount` decimal(10, 2) NOT NULL,
  `validation_method` enum('qr','phone','manual') NOT NULL,
  `validated_by` int(11),
  `notes` text,
  `status` enum('pending','completed','cancelled','refunded') DEFAULT 'completed',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_code` (`transaction_code`),
  KEY `fk_transactions_user` (`user_id`),
  KEY `fk_transactions_business` (`business_id`),
  KEY `fk_transactions_card` (`card_id`),
  KEY `fk_transactions_promotion` (`promotion_id`),
  KEY `fk_transactions_validator` (`validated_by`),
  KEY `idx_transactions_date` (`created_at`),
  CONSTRAINT `fk_transactions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_transactions_business` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`),
  CONSTRAINT `fk_transactions_card` FOREIGN KEY (`card_id`) REFERENCES `user_cards` (`id`),
  CONSTRAINT `fk_transactions_promotion` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`),
  CONSTRAINT `fk_transactions_validator` FOREIGN KEY (`validated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- User Favorites Table
-- ==========================================
CREATE TABLE `user_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `business_id` int(11) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_favorite` (`user_id`, `business_id`),
  KEY `fk_favorites_user` (`user_id`),
  KEY `fk_favorites_business` (`business_id`),
  CONSTRAINT `fk_favorites_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_favorites_business` FOREIGN KEY (`business_id`) REFERENCES `businesses` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Email Templates Table
-- ==========================================
CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `variables` json,
  `type` enum('welcome','verification','newsletter','promotion','notification') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- System Settings Table
-- ==========================================
CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text,
  `setting_type` enum('string','number','boolean','json') DEFAULT 'string',
  `description` text,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- Reports Views
-- ==========================================
CREATE VIEW `business_report` AS
SELECT 
    b.id,
    b.business_name,
    bc.name as category,
    COUNT(DISTINCT t.id) as total_transactions,
    SUM(t.discount_amount) as total_discounts_given,
    SUM(t.final_amount) as total_revenue,
    COUNT(DISTINCT t.user_id) as unique_customers,
    AVG(t.discount_amount) as avg_discount,
    b.created_at
FROM businesses b
LEFT JOIN business_categories bc ON b.category_id = bc.id
LEFT JOIN transactions t ON b.id = t.business_id
WHERE b.verification_status = 'verified'
GROUP BY b.id;

CREATE VIEW `user_transaction_summary` AS
SELECT 
    u.id,
    u.full_name,
    u.email,
    COUNT(t.id) as total_transactions,
    SUM(t.discount_amount) as total_savings,
    SUM(t.final_amount) as total_spent,
    ct.name as card_type,
    uc.used_amount,
    uc.card_number
FROM users u
LEFT JOIN user_cards uc ON u.id = uc.user_id
LEFT JOIN card_types ct ON uc.card_type_id = ct.id
LEFT JOIN transactions t ON u.id = t.user_id
WHERE u.role_id = 5
GROUP BY u.id, uc.id;

CREATE VIEW `daily_transaction_stats` AS
SELECT 
    DATE(created_at) as transaction_date,
    COUNT(*) as total_transactions,
    SUM(discount_amount) as total_discounts,
    SUM(final_amount) as total_revenue,
    COUNT(DISTINCT user_id) as unique_users,
    COUNT(DISTINCT business_id) as active_businesses
FROM transactions
WHERE status = 'completed'
GROUP BY DATE(created_at)
ORDER BY transaction_date DESC;

COMMIT;