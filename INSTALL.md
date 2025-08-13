# Uff! Platform - Instalación y Configuración

## Descripción

Uff! Platform es una plataforma web Freemium que conecta usuarios registrados con comercios locales ofreciendo descuentos y promociones exclusivas. El sistema incluye múltiples niveles de acceso, tarjetas digitales, sistema de pagos y funcionalidades avanzadas de reportes.

## Requisitos del Sistema

### Servidor Web
- **PHP**: 8.2 o superior
- **MySQL**: 5.7 o 8.0+
- **Apache/Nginx**: Con mod_rewrite habilitado
- **Memoria**: Mínimo 256MB (recomendado 512MB)
- **Espacio**: Mínimo 500MB

### Extensiones PHP Requeridas
```bash
php-pdo
php-pdo-mysql
php-json
php-mbstring
php-curl
php-gd
php-zip
php-xml
```

### APIs Externas (Configurables)
- **Google Maps API**: Para geolocalización
- **PayPal API**: Para procesamiento de pagos
- **SMTP Server**: Para envío de emails

## Instalación

### 1. Descargar y Extraer
```bash
# Clonar el repositorio
git clone https://github.com/danjohn007/uff.git
cd uff

# O descargar y extraer ZIP
wget https://github.com/danjohn007/uff/archive/main.zip
unzip main.zip
mv uff-main /var/www/html/uff
```

### 2. Configurar Permisos
```bash
# Navegar al directorio de instalación
cd /var/www/html/uff

# Configurar permisos
chmod 755 -R .
chmod 777 uploads/
chmod 666 config/database.php
```

### 3. Crear Base de Datos
```bash
# Conectar a MySQL
mysql -u root -p

# Crear base de datos
CREATE DATABASE uff_platform CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Crear usuario (opcional)
CREATE USER 'uff_user'@'localhost' IDENTIFIED BY 'password_seguro';
GRANT ALL PRIVILEGES ON uff_platform.* TO 'uff_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. Importar Schema y Datos
```bash
# Importar estructura de base de datos
mysql -u root -p uff_platform < sql/schema.sql

# Importar datos de ejemplo
mysql -u root -p uff_platform < sql/sample_data.sql
```

### 5. Configurar Aplicación

#### Editar configuración de base de datos
```php
// config/database.php
private $host = 'localhost';
private $database = 'uff_platform';
private $username = 'uff_user';
private $password = 'password_seguro';
```

#### Configurar variables de entorno
```php
// config/config.php

// URL de la aplicación
define('APP_URL', 'http://tu-dominio.com/uff');

// Configuración SMTP
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USERNAME', 'tu-email@gmail.com');
define('SMTP_PASSWORD', 'tu-password-app');

// PayPal
define('PAYPAL_CLIENT_ID', 'tu-paypal-client-id');
define('PAYPAL_CLIENT_SECRET', 'tu-paypal-secret');

// Google Maps
define('GOOGLE_MAPS_API_KEY', 'tu-google-maps-key');

// Seguridad (CAMBIAR EN PRODUCCIÓN)
define('JWT_SECRET', 'tu-clave-secreta-jwt');
define('ENCRYPTION_KEY', 'tu-clave-encriptacion');
```

### 6. Configurar Servidor Web

#### Apache (.htaccess)
```apache
RewriteEngine On
RewriteBase /uff/

# Redireccionar HTTP a HTTPS (producción)
# RewriteCond %{HTTPS} off
# RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Pretty URLs
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^/]+)/?$ $1.php [L,QSA]

# Proteger archivos de configuración
<Files "config/*.php">
    Order Allow,Deny
    Deny from all
</Files>

# Configurar caché para assets
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
</IfModule>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name tu-dominio.com;
    root /var/www/html/uff;
    index index.php index.html;

    location / {
        try_files $uri $uri/ @rewrite;
    }

    location @rewrite {
        rewrite ^/([^/]+)/?$ /$1.php last;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location /config/ {
        deny all;
    }

    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

## Configuración de APIs Externas

### Google Maps API
1. Ir a [Google Cloud Console](https://console.cloud.google.com/)
2. Crear un nuevo proyecto o seleccionar uno existente
3. Habilitar Google Maps JavaScript API
4. Crear credenciales (API Key)
5. Configurar restricciones de dominio
6. Actualizar `GOOGLE_MAPS_API_KEY` en config.php

### PayPal API
1. Ir a [PayPal Developer](https://developer.paypal.com/)
2. Crear una aplicación
3. Obtener Client ID y Client Secret
4. Configurar webhook endpoints
5. Actualizar configuración PayPal en config.php

### SMTP Configuration
Para Gmail:
1. Habilitar autenticación de 2 factores
2. Generar contraseña de aplicación
3. Usar la contraseña de aplicación en SMTP_PASSWORD

## Usuarios por Defecto

El sistema incluye usuarios de ejemplo para cada rol:

### Super Administrador
- **Email**: admin@uff-platform.com
- **Password**: password123
- **Permisos**: Acceso completo al sistema

### Gestor
- **Email**: maria.gestor@uff-platform.com
- **Password**: password123
- **Permisos**: Gestión regional y métricas

### Capturista
- **Email**: ana.capturista@uff-platform.com
- **Password**: password123
- **Permisos**: Registro de usuarios y validación

### Comercio
- **Email**: roberto@tacoselrey.com
- **Password**: password123
- **Permisos**: Gestión de promociones y analytics

### Usuario Final
- **Email**: alejandra.morales@gmail.com
- **Password**: password123
- **Permisos**: Acceso a beneficios y historial

## Estructura del Proyecto

```
uff/
├── config/
│   ├── config.php          # Configuración general
│   └── database.php        # Configuración de base de datos
├── classes/
│   └── Auth.php            # Sistema de autenticación
├── models/
│   ├── User.php            # Modelo de usuarios
│   ├── Business.php        # Modelo de comercios
│   ├── Card.php            # Modelo de tarjetas
│   └── Transaction.php     # Modelo de transacciones
├── controllers/
│   ├── UserController.php  # Controlador de usuarios
│   └── DashboardController.php # Controlador de dashboards
├── views/
│   ├── admin/              # Vistas de administrador
│   ├── business/           # Vistas de comercios
│   ├── user/               # Vistas de usuarios
│   └── shared/             # Vistas compartidas
├── public/
│   └── assets/
│       ├── css/            # Estilos CSS
│       ├── js/             # JavaScript
│       └── images/         # Imágenes
├── uploads/                # Archivos subidos
├── sql/
│   ├── schema.sql          # Estructura de base de datos
│   └── sample_data.sql     # Datos de ejemplo
├── index.html              # Página principal
├── login.php               # Página de login
├── register.php            # Página de registro
└── README.md               # Este archivo
```

## Funcionalidades Principales

### 1. Sistema de Usuarios
- **5 Roles**: SuperAdmin, Gestor, Capturista, Comercio, Usuario
- **Autenticación**: Login/logout con sesiones seguras
- **Registro**: Formularios validados con verificación de email
- **Perfiles**: Gestión de información personal

### 2. Tarjetas Digitales
- **4 Tipos**: Gratis, Plata, Oro, Diamante
- **Generación**: Automática con QR codes únicos
- **Límites**: Configurables por tipo de tarjeta
- **Física**: Opción de solicitar tarjeta física

### 3. Sistema de Comercios
- **Registro**: Formulario complejo con verificación manual
- **Categorías**: 10+ categorías predefinidas
- **Geolocalización**: Integración con Google Maps
- **Promociones**: Sistema completo de ofertas

### 4. Transacciones
- **Validación**: QR, teléfono o código manual
- **Historial**: Completo con filtros y búsqueda
- **Reportes**: Analytics para todos los roles
- **Exportación**: CSV, PDF, XLS

### 5. Pagos
- **PayPal**: Integración para planes premium
- **Tarjetas**: Procesamiento seguro
- **Subscripciones**: Renovación automática

## Mantenimiento

### Backups
```bash
# Backup de base de datos
mysqldump -u root -p uff_platform > backup_$(date +%Y%m%d_%H%M%S).sql

# Backup de archivos
tar -czf uff_backup_$(date +%Y%m%d_%H%M%S).tar.gz /var/www/html/uff
```

### Logs
```bash
# Ver logs de errores PHP
tail -f /var/log/apache2/error.log

# Ver logs de acceso
tail -f /var/log/apache2/access.log
```

### Actualizaciones
```bash
# Actualizar código
git pull origin main

# Ejecutar migraciones de BD si las hay
mysql -u root -p uff_platform < sql/migrations/migration_YYYYMMDD.sql
```

## Solución de Problemas

### Error de Conexión a Base de Datos
1. Verificar credenciales en `config/database.php`
2. Confirmar que MySQL está ejecutándose
3. Verificar permisos de usuario de BD

### Problemas de Permisos
```bash
# Reconfigurar permisos
chmod 755 -R /var/www/html/uff
chmod 777 /var/www/html/uff/uploads/
```

### Error 500
1. Revisar logs de PHP
2. Verificar configuración de Apache/Nginx
3. Confirmar que todas las extensiones PHP están instaladas

### Problemas con APIs
1. Verificar claves de API en config.php
2. Confirmar conectividad a internet
3. Revisar límites de uso de APIs

## Seguridad

### Recomendaciones de Producción
1. **Cambiar claves secretas** en config.php
2. **Habilitar HTTPS** obligatorio
3. **Configurar firewall** para limitar acceso
4. **Actualizaciones regulares** de PHP y MySQL
5. **Backups automáticos** diarios
6. **Monitoring** de logs de seguridad

### Headers de Seguridad
```apache
# .htaccess adicional para producción
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
Header always set Strict-Transport-Security "max-age=63072000; includeSubDomains; preload"
```

## Soporte

Para soporte técnico y consultas:
- **Email**: soporte@uff-platform.com
- **Documentación**: [Wiki del Proyecto](https://github.com/danjohn007/uff/wiki)
- **Issues**: [GitHub Issues](https://github.com/danjohn007/uff/issues)

## Licencia

Este proyecto está bajo la Licencia MIT. Ver archivo LICENSE para más detalles.