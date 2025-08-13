<?php
require_once '../config/config.php';

// Require authentication and user role
Auth::requireAuth();
Auth::requireRole(ROLE_USUARIO);

$user = Auth::getUser();
$userModel = new User();
$card = $userModel->getUserCard(Auth::getUserId());
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Dashboard - Uff! Platform</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#inicio">
                <i class="fas fa-star text-warning me-2"></i>Uff! Platform
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="promotions.php">
                            <i class="fas fa-tags me-1"></i>Promociones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="history.php">
                            <i class="fas fa-history me-1"></i>Historial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="map.php">
                            <i class="fas fa-map-marker-alt me-1"></i>Mapa
                        </a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($user['full_name']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user-edit me-2"></i>Mi Perfil
                            </a></li>
                            <li><a class="dropdown-item" href="settings.php">
                                <i class="fas fa-cog me-2"></i>Configuración
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Welcome Section -->
                <div class="dashboard-card mb-4">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="mb-2">¡Hola, <?php echo explode(' ', $user['full_name'])[0]; ?>!</h2>
                                <p class="text-muted mb-3">Bienvenido a tu dashboard personal. Aquí puedes ver tu progreso de ahorros y descubrir nuevas promociones.</p>
                                <div class="d-flex gap-2">
                                    <a href="promotions.php" class="btn btn-primary">
                                        <i class="fas fa-search me-2"></i>Explorar Ofertas
                                    </a>
                                    <a href="map.php" class="btn btn-outline-primary">
                                        <i class="fas fa-map-marker-alt me-2"></i>Encontrar Comercios
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="welcome-icon">
                                    <i class="fas fa-gift fa-4x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-piggy-bank fa-2x"></i>
                            </div>
                            <h4 class="mb-1">$<?php echo number_format($card['used_amount'] ?? 0, 2); ?></h4>
                            <p class="mb-0">Total Ahorrado</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card text-center" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-credit-card fa-2x"></i>
                            </div>
                            <h4 class="mb-1">$<?php echo number_format(($card['discount_limit'] ?? 5000) - ($card['used_amount'] ?? 0), 2); ?></h4>
                            <p class="mb-0">Disponible</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card text-center" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-shopping-bag fa-2x"></i>
                            </div>
                            <h4 class="mb-1">12</h4>
                            <p class="mb-0">Transacciones</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card text-center" style="background: linear-gradient(135deg, #e83e8c 0%, #6f42c1 100%);">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-heart fa-2x"></i>
                            </div>
                            <h4 class="mb-1">5</h4>
                            <p class="mb-0">Favoritos</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="dashboard-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2"></i>Transacciones Recientes
                        </h5>
                        <a href="history.php" class="btn btn-sm btn-outline-primary">Ver Todas</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Comercio</th>
                                        <th>Descuento</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10 Ago 2024</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-utensils text-danger me-2"></i>
                                                Tacos El Rey
                                            </div>
                                        </td>
                                        <td class="text-success">-$50.00</td>
                                        <td>$200.00</td>
                                        <td><span class="badge bg-success">Completada</span></td>
                                    </tr>
                                    <tr>
                                        <td>09 Ago 2024</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-tshirt text-info me-2"></i>
                                                Moda Carmen
                                            </div>
                                        </td>
                                        <td class="text-success">-$120.00</td>
                                        <td>$680.00</td>
                                        <td><span class="badge bg-success">Completada</span></td>
                                    </tr>
                                    <tr>
                                        <td>08 Ago 2024</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-dumbbell text-success me-2"></i>
                                                Fitness Zone
                                            </div>
                                        </td>
                                        <td class="text-success">-$360.00</td>
                                        <td>$840.00</td>
                                        <td><span class="badge bg-success">Completada</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Savings Chart -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2"></i>Progreso de Ahorros
                        </h5>
                    </div>
                    <div class="card-body">
                        <canvas id="savingsChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Digital Card -->
                <div class="dashboard-card mb-4">
                    <div class="card-header text-center">
                        <h5 class="mb-0">Mi Tarjeta Digital</h5>
                    </div>
                    <div class="card-body text-center">
                        <?php if ($card): ?>
                            <div class="digital-card mx-auto" style="max-width: 280px;">
                                <div class="card-header text-white p-3" style="background: <?php echo $card['color']; ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">Uff! Card</span>
                                        <span class="badge bg-light text-dark"><?php echo strtoupper($card['card_type_name']); ?></span>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="avatar-placeholder mb-2">
                                        <i class="fas fa-user fa-2x text-muted"></i>
                                    </div>
                                    <h6 class="fw-bold"><?php echo htmlspecialchars($user['full_name']); ?></h6>
                                    <p class="text-muted small"><?php echo $card['card_number']; ?></p>
                                    <div class="qr-placeholder mb-2">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=<?php echo urlencode($card['qr_code']); ?>" 
                                             alt="QR Code" width="60" height="60">
                                    </div>
                                    <small class="text-muted">Válida hasta <?php echo date('M Y', strtotime($card['expiry_date'])); ?></small>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" 
                                         role="progressbar" 
                                         style="width: <?php echo (($card['used_amount'] / $card['discount_limit']) * 100); ?>%">
                                    </div>
                                </div>
                                <small class="text-muted">
                                    Usado: $<?php echo number_format($card['used_amount'], 2); ?> / $<?php echo number_format($card['discount_limit'], 2); ?>
                                </small>
                            </div>
                            
                            <div class="mt-3">
                                <a href="upgrade.php" class="btn btn-warning btn-sm">
                                    <i class="fas fa-arrow-up me-1"></i>Mejorar Plan
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                                <p>No tienes una tarjeta activa</p>
                                <a href="get-card.php" class="btn btn-primary">Obtener Tarjeta</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="dashboard-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="scan-qr.php" class="btn btn-primary">
                                <i class="fas fa-qrcode me-2"></i>Escanear QR
                            </a>
                            <a href="promotions.php" class="btn btn-outline-primary">
                                <i class="fas fa-percent me-2"></i>Ver Promociones
                            </a>
                            <a href="favorites.php" class="btn btn-outline-primary">
                                <i class="fas fa-heart me-2"></i>Mis Favoritos
                            </a>
                            <a href="support.php" class="btn btn-outline-secondary">
                                <i class="fas fa-life-ring me-2"></i>Soporte
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Featured Promotions -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-fire me-2"></i>Promociones Destacadas
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-utensils text-danger me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Tacos El Rey</h6>
                                        <small class="text-muted">20% de descuento</small>
                                    </div>
                                    <span class="badge bg-danger">HOT</span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-spa text-primary me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Belleza VIP</h6>
                                        <small class="text-muted">35% en paquetes</small>
                                    </div>
                                    <span class="badge bg-primary">NEW</span>
                                </div>
                            </div>
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-dumbbell text-success me-3"></i>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Fitness Zone</h6>
                                        <small class="text-muted">30% mensualidad</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="promotions.php" class="text-decoration-none small">
                                Ver todas las promociones <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../assets/js/main.js"></script>
    
    <script>
        // Initialize savings chart
        const ctx = document.getElementById('savingsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'],
                datasets: [{
                    label: 'Ahorros Acumulados',
                    data: [0, 150, 300, 420, 650, 850, 1100, <?php echo $card['used_amount'] ?? 0; ?>],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>