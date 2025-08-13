-- Sample data for Uff! Platform
-- This file inserts extensive sample data for testing and demonstration

USE `uff_platform`;

-- Insert User Roles
INSERT INTO `user_roles` (`id`, `name`, `description`, `permissions`) VALUES
(1, 'SuperAdmin', 'Super Administrator with full access', JSON_OBJECT('all', true)),
(2, 'Gestor', 'Manager with regional access and metrics', JSON_OBJECT('view_reports', true, 'manage_region', true, 'export_data', true)),
(3, 'Capturista', 'Data entry specialist for user registration', JSON_OBJECT('register_users', true, 'validate_cards', true, 'basic_query', true)),
(4, 'Comercio', 'Business owner with promotion management', JSON_OBJECT('manage_promotions', true, 'view_analytics', true, 'validate_transactions', true)),
(5, 'Usuario', 'End user with basic access', JSON_OBJECT('view_promotions', true, 'manage_profile', true, 'view_history', true));

-- Insert Sample Users
INSERT INTO `users` (`full_name`, `email`, `phone`, `birth_date`, `password_hash`, `role_id`, `email_verified`, `status`) VALUES
-- Super Admin
('Carlos Rodríguez Admin', 'admin@uff-platform.com', '+525512345678', '1985-03-15', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, 1, 'active'),

-- Gestores
('María González Métricas', 'maria.gestor@uff-platform.com', '+525587654321', '1988-07-20', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 1, 'active'),
('Luis Hernández Regional', 'luis.gestor@uff-platform.com', '+525576543210', '1982-11-05', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, 1, 'active'),

-- Capturistas
('Ana Martínez Registro', 'ana.capturista@uff-platform.com', '+525565432109', '1990-02-28', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, 1, 'active'),
('Pedro Sánchez Validación', 'pedro.capturista@uff-platform.com', '+525554321098', '1987-09-12', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 3, 1, 'active'),

-- Business Owners
('Roberto López Restaurante', 'roberto@tacoselrey.com', '+525543210987', '1975-06-18', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4, 1, 'active'),
('Carmen Díaz Boutique', 'carmen@modacarmen.com', '+525532109876', '1980-12-03', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4, 1, 'active'),
('Miguel Ruiz Fitness', 'miguel@fitnesszone.com', '+525521098765', '1983-04-25', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4, 1, 'active'),
('Sandra Torres Belleza', 'sandra@bellezvip.com', '+525510987654', '1979-08-14', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4, 1, 'active'),
('Fernando Castro Tech', 'fernando@techstore.com', '+525509876543', '1986-01-30', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 4, 1, 'active'),

-- End Users
('Alejandra Morales Cliente', 'alejandra.morales@gmail.com', '+525598765432', '1992-05-12', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 1, 'active'),
('David Jiménez Usuario', 'david.jimenez@hotmail.com', '+525587654321', '1988-10-08', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 1, 'active'),
('Sofía Ramírez Compras', 'sofia.ramirez@yahoo.com', '+525576543210', '1995-03-22', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 1, 'active'),
('Jorge Vargas Cliente', 'jorge.vargas@gmail.com', '+525565432109', '1989-11-17', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 1, 'active'),
('Patricia Núñez Usuario', 'patricia.nunez@outlook.com', '+525554321098', '1991-07-04', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 1, 'active'),
('Ricardo Mendoza Compras', 'ricardo.mendoza@gmail.com', '+525543210987', '1987-12-25', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 1, 'active'),
('Valeria Ortega Cliente', 'valeria.ortega@hotmail.com', '+525532109876', '1993-08-13', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 1, 'active'),
('Andrés Herrera Usuario', 'andres.herrera@yahoo.com', '+525521098765', '1990-04-06', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 1, 'active'),
('Isabella Cruz Compras', 'isabella.cruz@gmail.com', '+525510987654', '1994-01-19', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 1, 'active'),
('Emilio Flores Cliente', 'emilio.flores@outlook.com', '+525509876543', '1986-09-28', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 5, 1, 'active');

-- Insert Business Categories
INSERT INTO `business_categories` (`name`, `description`, `icon`, `color`) VALUES
('Restaurantes', 'Establecimientos de comida y bebida', 'fa-utensils', '#FF6B6B'),
('Moda y Ropa', 'Tiendas de ropa, calzado y accesorios', 'fa-tshirt', '#4ECDC4'),
('Salud y Belleza', 'Spas, salones de belleza y centros de bienestar', 'fa-spa', '#45B7D1'),
('Deportes y Fitness', 'Gimnasios, deportes y actividades físicas', 'fa-dumbbell', '#96CEB4'),
('Tecnología', 'Tiendas de electrónicos y tecnología', 'fa-laptop', '#FFEAA7'),
('Entretenimiento', 'Cines, teatros y centros de diversión', 'fa-film', '#DDA0DD'),
('Hogar y Jardín', 'Artículos para el hogar y jardín', 'fa-home', '#98D8C8'),
('Automotriz', 'Servicios automotrices y refacciones', 'fa-car', '#F7DC6F'),
('Educación', 'Cursos, talleres y centros educativos', 'fa-graduation-cap', '#BB8FCE'),
('Servicios', 'Servicios profesionales diversos', 'fa-briefcase', '#85C1E9');

-- Insert Businesses
INSERT INTO `businesses` (`user_id`, `business_name`, `business_type`, `category_id`, `rfc`, `address`, `city`, `state`, `postal_code`, `latitude`, `longitude`, `legal_representative`, `representative_id`, `business_hours`, `description`, `benefits_offered`, `verification_status`) VALUES
-- Restaurants
(6, 'Tacos El Rey', 'Restaurante', 1, 'TELR850618ABC', 'Av. Insurgentes Sur 1234, Col. Del Valle', 'Ciudad de México', 'CDMX', '03100', 19.3910, -99.1620, 'Roberto López García', 'LOGR750618HDF123', JSON_OBJECT('lunes', '8:00-22:00', 'martes', '8:00-22:00', 'miercoles', '8:00-22:00', 'jueves', '8:00-22:00', 'viernes', '8:00-23:00', 'sabado', '9:00-23:00', 'domingo', '9:00-21:00'), 'Auténticos tacos mexicanos con ingredientes frescos y salsas artesanales', '20% de descuento en ordenes mayores a $200', 'verified'),

-- Fashion
(7, 'Moda Carmen Boutique', 'Boutique', 2, 'MCBR801203DEF', 'Av. Revolución 456, Col. San Ángel', 'Ciudad de México', 'CDMX', '01000', 19.3467, -99.1871, 'Carmen Díaz Rodríguez', 'DIRC801203MDF456', JSON_OBJECT('lunes', '10:00-20:00', 'martes', '10:00-20:00', 'miercoles', '10:00-20:00', 'jueves', '10:00-20:00', 'viernes', '10:00-21:00', 'sabado', '10:00-21:00', 'domingo', '11:00-18:00'), 'Boutique de moda femenina con las últimas tendencias y marcas exclusivas', '15% de descuento en toda la tienda + 25% en rebajas', 'verified'),

-- Fitness
(8, 'Fitness Zone Gym', 'Gimnasio', 4, 'FZGR830425GHI', 'Calle Reforma 789, Col. Juárez', 'Ciudad de México', 'CDMX', '06600', 19.4326, -99.1332, 'Miguel Ruiz Fernández', 'RUFM830425HDF789', JSON_OBJECT('lunes', '5:00-23:00', 'martes', '5:00-23:00', 'miercoles', '5:00-23:00', 'jueves', '5:00-23:00', 'viernes', '5:00-23:00', 'sabado', '6:00-22:00', 'domingo', '7:00-20:00'), 'Gimnasio completamente equipado con clases grupales y entrenadores personales', 'Mensualidad con 30% de descuento + clase gratis', 'verified'),

-- Beauty
(9, 'Belleza VIP Spa', 'Spa', 3, 'BVSR790814JKL', 'Av. Polanco 321, Col. Polanco', 'Ciudad de México', 'CDMX', '11550', 19.4326, -99.1895, 'Sandra Torres Morales', 'TOMS790814MDF321', JSON_OBJECT('lunes', '9:00-20:00', 'martes', '9:00-20:00', 'miercoles', '9:00-20:00', 'jueves', '9:00-20:00', 'viernes', '9:00-21:00', 'sabado', '9:00-21:00', 'domingo', '10:00-18:00'), 'Spa de lujo con tratamientos faciales, corporales y servicios de belleza integral', '20% en tratamientos faciales + 15% en paquetes', 'verified'),

-- Technology
(10, 'Tech Store México', 'Tienda Electrónicos', 5, 'TSMR860130MNO', 'Av. Universidad 567, Col. Narvarte', 'Ciudad de México', 'CDMX', '03020', 19.3950, -99.1530, 'Fernando Castro López', 'CALF860130HDF567', JSON_OBJECT('lunes', '10:00-19:00', 'martes', '10:00-19:00', 'miercoles', '10:00-19:00', 'jueves', '10:00-19:00', 'viernes', '10:00-20:00', 'sabado', '10:00-20:00', 'domingo', '11:00-17:00'), 'Tienda especializada en tecnología, computadoras, smartphones y accesorios', '10% en equipos + 20% en accesorios', 'verified');

-- Insert Card Types
INSERT INTO `card_types` (`name`, `price`, `discount_limit`, `color`, `benefits`, `is_physical`) VALUES
('Gratis', 0.00, 5000.00, '#95A5A6', JSON_OBJECT('description', 'Acceso básico a descuentos', 'monthly_limit', 5000), 0),
('Plata', 199.00, 10000.00, '#BDC3C7', JSON_OBJECT('description', 'Descuentos mejorados + beneficios adicionales', 'monthly_limit', 10000, 'priority_support', true), 1),
('Oro', 399.00, 20000.00, '#F1C40F', JSON_OBJECT('description', 'Descuentos premium + eventos exclusivos', 'monthly_limit', 20000, 'exclusive_events', true, 'priority_support', true), 1),
('Diamante', 799.00, 50000.00, '#E8F8F5', JSON_OBJECT('description', 'Máximo nivel de beneficios y descuentos ilimitados', 'monthly_limit', 50000, 'unlimited_access', true, 'exclusive_events', true, 'concierge_service', true), 1);

-- Insert User Cards
INSERT INTO `user_cards` (`user_id`, `card_type_id`, `card_number`, `qr_code`, `used_amount`, `payment_status`, `expiry_date`, `status`) VALUES
-- Free cards for end users
(10, 1, 'UFF0001000010', 'QR001000010', 850.00, 'completed', '2025-12-31', 'active'),
(11, 1, 'UFF0001000011', 'QR001000011', 1200.50, 'completed', '2025-12-31', 'active'),
(12, 2, 'UFF0002000012', 'QR002000012', 2300.75, 'completed', '2025-12-31', 'active'),
(13, 1, 'UFF0001000013', 'QR001000013', 450.25, 'completed', '2025-12-31', 'active'),
(14, 3, 'UFF0003000014', 'QR003000014', 5600.00, 'completed', '2025-12-31', 'active'),
(15, 1, 'UFF0001000015', 'QR001000015', 320.80, 'completed', '2025-12-31', 'active'),
(16, 2, 'UFF0002000016', 'QR002000016', 1800.45, 'completed', '2025-12-31', 'active'),
(17, 1, 'UFF0001000017', 'QR001000017', 670.30, 'completed', '2025-12-31', 'active'),
(18, 4, 'UFF0004000018', 'QR004000018', 12500.00, 'completed', '2025-12-31', 'active'),
(19, 1, 'UFF0001000019', 'QR001000019', 280.60, 'completed', '2025-12-31', 'active');

-- Insert Promotions
INSERT INTO `promotions` (`business_id`, `title`, `description`, `discount_type`, `discount_value`, `minimum_purchase`, `max_discount`, `valid_from`, `valid_until`, `usage_limit`, `applicable_card_types`, `terms_conditions`, `status`) VALUES
-- Tacos El Rey promotions
(1, '20% Descuento en Órdenes Mayores', 'Obtén 20% de descuento en órdenes superiores a $200', 'percentage', 20.00, 200.00, 100.00, '2024-01-01', '2024-12-31', 1000, JSON_ARRAY(1, 2, 3, 4), 'Válido de lunes a domingo. No acumulable con otras promociones.', 'active'),
(1, 'Combo Especial Tarjeta Oro', 'Combo especial con 30% de descuento para tarjetas Oro y Diamante', 'percentage', 30.00, 150.00, 150.00, '2024-01-01', '2024-12-31', 500, JSON_ARRAY(3, 4), 'Incluye 3 tacos + bebida + postre. Solo fines de semana.', 'active'),

-- Moda Carmen promotions
(2, '15% Toda la Tienda', 'Descuento del 15% en toda la mercancía de la tienda', 'percentage', 15.00, 100.00, 200.00, '2024-01-01', '2024-12-31', 2000, JSON_ARRAY(1, 2, 3, 4), 'No aplica en artículos ya rebajados. Válido cualquier día.', 'active'),
(2, '25% Descuento Rebajas', 'Descuento adicional del 25% en artículos ya rebajados', 'percentage', 25.00, 50.00, 300.00, '2024-01-01', '2024-06-30', 1500, JSON_ARRAY(2, 3, 4), 'Aplica solo en sección de rebajas. Mientras duren las existencias.', 'active'),

-- Fitness Zone promotions
(3, 'Mensualidad 30% Descuento', '30% de descuento en mensualidad + clase grupal gratis', 'percentage', 30.00, 800.00, 400.00, '2024-01-01', '2024-12-31', 100, JSON_ARRAY(1, 2, 3, 4), 'Válido para nuevos miembros. Incluye evaluación física gratuita.', 'active'),
(3, 'Personal Training VIP', '50% de descuento en sesiones de entrenamiento personal', 'percentage', 50.00, 500.00, 500.00, '2024-01-01', '2024-12-31', 200, JSON_ARRAY(3, 4), 'Solo para tarjetas Oro y Diamante. Máximo 2 sesiones por mes.', 'active'),

-- Belleza VIP promotions
(4, 'Tratamientos Faciales 20%', '20% de descuento en todos los tratamientos faciales', 'percentage', 20.00, 300.00, 200.00, '2024-01-01', '2024-12-31', 800, JSON_ARRAY(1, 2, 3, 4), 'Incluye limpieza facial + mascarilla. Con cita previa.', 'active'),
(4, 'Paquete Relajación Premium', '35% en paquetes de relajación completos', 'percentage', 35.00, 1000.00, 600.00, '2024-01-01', '2024-12-31', 300, JSON_ARRAY(3, 4), 'Incluye masaje + facial + manicure. Solo tarjetas premium.', 'active'),

-- Tech Store promotions
(5, 'Equipos Tecnológicos 10%', '10% de descuento en equipos de cómputo y smartphones', 'percentage', 10.00, 1000.00, 500.00, '2024-01-01', '2024-12-31', 1000, JSON_ARRAY(1, 2, 3, 4), 'Aplica en equipos nuevos. Garantía extendida incluida.', 'active'),
(5, 'Accesorios Premium 20%', '20% de descuento en accesorios y gadgets', 'percentage', 20.00, 200.00, 300.00, '2024-01-01', '2024-12-31', 1500, JSON_ARRAY(2, 3, 4), 'Amplia variedad de marcas. Válido cualquier día.', 'active');

-- Insert Sample Transactions
INSERT INTO `transactions` (`user_id`, `business_id`, `card_id`, `promotion_id`, `transaction_code`, `original_amount`, `discount_amount`, `final_amount`, `validation_method`, `validated_by`, `status`, `created_at`) VALUES
-- Recent transactions (last 30 days)
(10, 1, 1, 1, 'TXN001', 250.00, 50.00, 200.00, 'qr', 6, 'completed', '2024-08-10 14:30:00'),
(11, 2, 2, 3, 'TXN002', 800.00, 120.00, 680.00, 'phone', 7, 'completed', '2024-08-09 16:45:00'),
(12, 3, 3, 5, 'TXN003', 1200.00, 360.00, 840.00, 'qr', 8, 'completed', '2024-08-08 10:20:00'),
(13, 4, 4, 7, 'TXN004', 450.00, 90.00, 360.00, 'manual', 9, 'completed', '2024-08-07 11:15:00'),
(14, 5, 5, 9, 'TXN005', 1500.00, 150.00, 1350.00, 'qr', 10, 'completed', '2024-08-06 15:40:00'),
(15, 1, 6, 1, 'TXN006', 320.00, 64.00, 256.00, 'phone', 6, 'completed', '2024-08-05 19:25:00'),
(16, 2, 7, 4, 'TXN007', 150.00, 37.50, 112.50, 'qr', 7, 'completed', '2024-08-04 13:10:00'),
(17, 3, 8, 5, 'TXN008', 900.00, 270.00, 630.00, 'qr', 8, 'completed', '2024-08-03 09:35:00'),
(18, 4, 9, 8, 'TXN009', 1800.00, 630.00, 1170.00, 'manual', 9, 'completed', '2024-08-02 17:50:00'),
(19, 5, 10, 10, 'TXN010', 350.00, 70.00, 280.00, 'phone', 10, 'completed', '2024-08-01 12:20:00');

-- Insert more historical transactions (last 3 months)
INSERT INTO `transactions` (`user_id`, `business_id`, `card_id`, `promotion_id`, `transaction_code`, `original_amount`, `discount_amount`, `final_amount`, `validation_method`, `validated_by`, `status`, `created_at`) VALUES
-- July 2024
(10, 2, 1, 3, 'TXN011', 600.00, 90.00, 510.00, 'qr', 7, 'completed', '2024-07-28 14:15:00'),
(11, 3, 2, 5, 'TXN012', 1000.00, 300.00, 700.00, 'phone', 8, 'completed', '2024-07-25 16:30:00'),
(12, 4, 3, 7, 'TXN013', 380.00, 76.00, 304.00, 'qr', 9, 'completed', '2024-07-22 11:45:00'),
(13, 5, 4, 9, 'TXN014', 1200.00, 120.00, 1080.00, 'manual', 10, 'completed', '2024-07-19 15:20:00'),
(14, 1, 5, 2, 'TXN015', 180.00, 54.00, 126.00, 'qr', 6, 'completed', '2024-07-16 18:10:00'),

-- June 2024
(15, 2, 6, 4, 'TXN016', 250.00, 62.50, 187.50, 'phone', 7, 'completed', '2024-06-28 13:25:00'),
(16, 3, 7, 5, 'TXN017', 850.00, 255.00, 595.00, 'qr', 8, 'completed', '2024-06-25 10:40:00'),
(17, 4, 8, 7, 'TXN018', 420.00, 84.00, 336.00, 'manual', 9, 'completed', '2024-06-22 17:55:00'),
(18, 5, 9, 10, 'TXN019', 680.00, 136.00, 544.00, 'qr', 10, 'completed', '2024-06-19 14:30:00'),
(19, 1, 10, 1, 'TXN020', 290.00, 58.00, 232.00, 'phone', 6, 'completed', '2024-06-16 16:15:00');

-- Insert User Favorites
INSERT INTO `user_favorites` (`user_id`, `business_id`) VALUES
(10, 1), (10, 3), (10, 5),
(11, 1), (11, 2), (11, 4),
(12, 2), (12, 3), (12, 4),
(13, 1), (13, 4), (13, 5),
(14, 3), (14, 4), (14, 5),
(15, 1), (15, 2), (15, 3),
(16, 2), (16, 4), (16, 5),
(17, 1), (17, 3), (17, 4),
(18, 2), (18, 3), (18, 5),
(19, 1), (19, 4), (19, 5);

-- Insert Email Templates
INSERT INTO `email_templates` (`name`, `subject`, `body`, `variables`, `type`) VALUES
('welcome', 'Bienvenido a Uff! Platform', 
'<h1>¡Bienvenido {{name}}!</h1><p>Gracias por registrarte en Uff! Platform. Tu tarjeta digital ya está lista para usar.</p><p>Número de tarjeta: {{card_number}}</p><p>¡Comienza a ahorrar hoy mismo!</p>', 
JSON_OBJECT('name', 'string', 'card_number', 'string'), 'welcome'),

('verification', 'Verifica tu correo electrónico', 
'<h1>Verifica tu cuenta</h1><p>Hola {{name}},</p><p>Haz clic en el siguiente enlace para verificar tu cuenta:</p><p><a href="{{verification_link}}">Verificar mi cuenta</a></p>', 
JSON_OBJECT('name', 'string', 'verification_link', 'string'), 'verification'),

('newsletter', 'Boletín Semanal Uff!', 
'<h1>¡Nuevas ofertas esta semana!</h1><p>Descubre las mejores promociones de nuestros comercios afiliados:</p>{{promotions_list}}<p>¡No te las pierdas!</p>', 
JSON_OBJECT('promotions_list', 'html'), 'newsletter');

-- Insert System Settings
INSERT INTO `system_settings` (`setting_key`, `setting_value`, `setting_type`, `description`) VALUES
('site_name', 'Uff! Platform', 'string', 'Nombre del sitio web'),
('maintenance_mode', 'false', 'boolean', 'Modo de mantenimiento'),
('max_discount_percentage', '50', 'number', 'Porcentaje máximo de descuento permitido'),
('default_card_expiry_months', '12', 'number', 'Meses de validez por defecto para tarjetas'),
('newsletter_frequency', '7', 'number', 'Frecuencia del boletín en días'),
('google_maps_zoom', '13', 'number', 'Nivel de zoom por defecto en mapas'),
('paypal_enabled', 'true', 'boolean', 'PayPal habilitado para pagos'),
('email_verification_required', 'true', 'boolean', 'Verificación de email requerida'),
('physical_card_shipping_cost', '50', 'number', 'Costo de envío de tarjeta física en MXN'),
('business_verification_required', 'true', 'boolean', 'Verificación manual de comercios requerida');