# Uff! Platform
## Plataforma de Comercios con Acceso Privilegiado

Una solución digital Freemium que conecta usuarios registrados con comercios locales ofreciendo descuentos y promociones exclusivas.

## 🚀 Características Principales

- **Sistema Multi-Rol**: 5 tipos de usuarios (SuperAdmin, Gestor, Capturista, Comercio, Usuario)
- **Tarjetas Digitales**: Con códigos QR únicos y 4 niveles de membresía
- **Geolocalización**: Integración con Google Maps para encontrar comercios cercanos
- **Pagos Integrados**: Procesamiento con PayPal para planes premium
- **Analytics Completos**: Reportes y métricas detalladas para todos los roles
- **Sistema de Promociones**: Gestión completa de ofertas y descuentos

## 🛠️ Tecnologías

- **Backend**: PHP 8.2 puro (sin framework)
- **Base de Datos**: MySQL 5.7/8.0 con claves foráneas y vistas
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Gráficas**: Chart.js
- **Mapas**: Google Maps API
- **Pagos**: PayPal API

## 📦 Instalación Rápida

1. **Clonar el repositorio**:
```bash
git clone https://github.com/danjohn007/uff.git
cd uff
```

2. **Configurar base de datos**:
```bash
mysql -u root -p < sql/schema.sql
mysql -u root -p < sql/sample_data.sql
```

3. **Configurar aplicación**:
   - Editar `config/database.php` con tus credenciales de MySQL
   - Configurar APIs en `config/config.php`

4. **Configurar servidor web** con DocumentRoot apuntando al directorio del proyecto

## 🔑 Usuarios de Prueba

| Rol | Email | Contraseña |
|-----|-------|------------|
| **Super Admin** | admin@uff-platform.com | password123 |
| **Gestor** | maria.gestor@uff-platform.com | password123 |
| **Capturista** | ana.capturista@uff-platform.com | password123 |
| **Comercio** | roberto@tacoselrey.com | password123 |
| **Usuario** | alejandra.morales@gmail.com | password123 |

## 📁 Estructura del Proyecto

```
uff/
├── config/          # Configuración de la aplicación
├── classes/         # Clases utilitarias (Auth, etc.)
├── models/          # Modelos de datos
├── controllers/     # Controladores
├── views/           # Vistas por rol
├── assets/          # CSS, JS, imágenes
├── uploads/         # Archivos subidos
├── sql/            # Scripts de base de datos
├── user/           # Dashboard de usuarios
├── admin/          # Panel de administración
├── business/       # Dashboard de comercios
└── [role]/         # Dashboards específicos por rol
```

## 🎯 Funcionalidades por Rol

### SuperAdmin
- ✅ Acceso completo a todos los módulos
- ✅ Gestión de roles y permisos
- ✅ Reportes financieros globales
- ✅ Configuración del sistema

### Gestor/Métricas
- ✅ Estadísticas regionales
- ✅ Reportes de conversión
- ✅ Análisis de datos
- ✅ Exportación de reportes

### Capturista
- ✅ Registro de usuarios físicos
- ✅ Validación de tarjetas
- ✅ Herramientas de consulta

### Comercio/Empresa
- ✅ Dashboard de beneficios
- ✅ Gestión de promociones
- ✅ Validación de clientes (QR/teléfono)
- ✅ Analytics de negocio

### Usuario Final
- ✅ Acceso a promociones
- ✅ Historial de transacciones
- ✅ Tarjeta digital con QR
- ✅ Sistema de favoritos

## 💳 Sistema de Tarjetas

| Tipo | Precio | Límite Mensual | Beneficios |
|------|--------|----------------|------------|
| **Gratis** | $0 | $5,000 MXN | Acceso básico |
| **Plata** | $199/año | $10,000 MXN | Tarjeta física + prioridad |
| **Oro** | $399/año | $20,000 MXN | Eventos exclusivos |
| **Diamante** | $799/año | $50,000 MXN | Servicio concierge |

## 🗺️ Características Avanzadas

- **Geolocalización**: Encuentra comercios cercanos
- **QR Validation**: Validación de transacciones por código QR
- **Email Automation**: Sistema de boletines y notificaciones
- **Responsive Design**: Optimizado para móviles
- **Security**: Headers de seguridad, validación CSRF, encriptación

## 📊 Base de Datos

El sistema incluye:
- **12 tablas principales** con relaciones definidas
- **3 vistas especializadas** para reportes
- **Datos de ejemplo** con +100 registros
- **Índices optimizados** para consultas rápidas

## 🔧 Configuración de APIs

### Google Maps
```php
define('GOOGLE_MAPS_API_KEY', 'tu-google-maps-key');
```

### PayPal
```php
define('PAYPAL_CLIENT_ID', 'tu-paypal-client-id');
define('PAYPAL_CLIENT_SECRET', 'tu-paypal-secret');
```

### SMTP (Email)
```php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USERNAME', 'tu-email@gmail.com');
define('SMTP_PASSWORD', 'tu-password-app');
```

## 📈 Reportes y Analytics

- **Dashboard en tiempo real** con métricas clave
- **Gráficas interactivas** con Chart.js
- **Exportación** en formatos CSV, PDF, XLS
- **Filtros avanzados** por fecha, comercio, usuario
- **Mapa de calor** de redenciones geográficas

## 🔒 Seguridad

- Autenticación con **password hashing**
- Protección **CSRF** en formularios
- **Headers de seguridad** configurados
- **Validación** estricta de entrada de datos
- **Logs de seguridad** para auditoría

## 📱 Responsive Design

- **Bootstrap 5** para diseño adaptable
- **Mobile-first** approach
- **Touch-friendly** interfaces
- **Progressive enhancement**

## 🔄 Instalación Completa

Ver archivo [`INSTALL.md`](INSTALL.md) para instrucciones detalladas de instalación, configuración de servidor web, y solución de problemas.

## 🤝 Contribución

1. Fork del proyecto
2. Crear rama para feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit de cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crear Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver archivo `LICENSE` para más detalles.

## 💬 Soporte

- **Email**: soporte@uff-platform.com
- **Issues**: [GitHub Issues](https://github.com/danjohn007/uff/issues)
- **Wiki**: [Documentación](https://github.com/danjohn007/uff/wiki)

---

⭐ **¡Dale una estrella al proyecto si te fue útil!**
