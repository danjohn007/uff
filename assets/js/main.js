/**
 * Uff! Platform JavaScript
 * Main application functionality
 */

// Global configuration
const UffApp = {
    config: {
        apiUrl: '/api',
        version: '1.0.0',
        debug: true
    },
    
    init() {
        this.setupEventListeners();
        this.initSmoothScrolling();
        this.initAnimations();
        this.initTooltips();
        this.initValidation();
        console.log('Uff! App initialized');
    },
    
    // Event listeners
    setupEventListeners() {
        // Navigation active state
        this.updateNavigation();
        
        // Form submissions
        document.addEventListener('submit', this.handleFormSubmit.bind(this));
        
        // Window scroll events
        window.addEventListener('scroll', this.handleScroll.bind(this));
        
        // Resize events
        window.addEventListener('resize', this.handleResize.bind(this));
    },
    
    // Smooth scrolling for anchor links
    initSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    },
    
    // Initialize animations
    initAnimations() {
        // Intersection Observer for fade-in animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, { threshold: 0.1 });
        
        // Observe elements with animation classes
        document.querySelectorAll('.benefit-card, .pricing-card, .testimonial-card').forEach(el => {
            observer.observe(el);
        });
    },
    
    // Initialize Bootstrap tooltips
    initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    },
    
    // Form validation
    initValidation() {
        // Custom validation rules
        const forms = document.querySelectorAll('.needs-validation');
        forms.forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    },
    
    // Navigation updates
    updateNavigation() {
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
        
        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.pageYOffset >= sectionTop - 200) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    },
    
    // Handle form submissions
    handleFormSubmit(event) {
        const form = event.target;
        
        // Add loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            this.setButtonLoading(submitBtn, true);
        }
        
        // Remove loading state after delay (would be handled by actual form processing)
        setTimeout(() => {
            if (submitBtn) {
                this.setButtonLoading(submitBtn, false);
            }
        }, 2000);
    },
    
    // Handle scroll events
    handleScroll() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 100) {
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    },
    
    // Handle resize events
    handleResize() {
        // Update any responsive elements
        this.updateCarousel();
    },
    
    // Update carousel for mobile
    updateCarousel() {
        const carousel = document.querySelector('#businessCarousel');
        if (carousel && window.innerWidth < 768) {
            // Mobile-specific carousel updates
        }
    },
    
    // Utility: Set button loading state
    setButtonLoading(button, loading) {
        if (loading) {
            button.disabled = true;
            button.innerHTML = '<span class="loading-spinner me-2"></span>Procesando...';
        } else {
            button.disabled = false;
            button.innerHTML = button.getAttribute('data-original-text') || 'Enviar';
        }
    },
    
    // Show notifications
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 1050; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    },
    
    // AJAX helper
    async makeRequest(url, options = {}) {
        const defaultOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };
        
        const config = { ...defaultOptions, ...options };
        
        try {
            const response = await fetch(url, config);
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Request failed');
            }
            
            return data;
        } catch (error) {
            console.error('Request error:', error);
            this.showNotification('Error: ' + error.message, 'danger');
            throw error;
        }
    },
    
    // Format currency
    formatCurrency(amount) {
        return new Intl.NumberFormat('es-MX', {
            style: 'currency',
            currency: 'MXN'
        }).format(amount);
    },
    
    // Format date
    formatDate(date) {
        return new Intl.DateTimeFormat('es-MX', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    },
    
    // Validate email
    validateEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    },
    
    // Validate phone (international format)
    validatePhone(phone) {
        const regex = /^\+[1-9]\d{1,14}$/;
        return regex.test(phone);
    },
    
    // Generate QR code URL
    generateQRCode(data, size = 200) {
        return `https://api.qrserver.com/v1/create-qr-code/?size=${size}x${size}&data=${encodeURIComponent(data)}`;
    }
};

// Card Management
const CardManager = {
    generateCardNumber(userId, cardTypeId) {
        const prefix = 'UFF';
        const type = String(cardTypeId).padStart(4, '0');
        const user = String(userId).padStart(6, '0');
        return prefix + type + user;
    },
    
    generateQRCode(cardNumber) {
        return 'QR' + cardNumber.substr(3);
    },
    
    displayCard(cardData) {
        const cardHtml = `
            <div class="digital-card shadow-lg">
                <div class="card-header text-white p-3" style="background: ${cardData.color}">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Uff! Card</span>
                        <span class="badge bg-light text-dark">${cardData.type_name}</span>
                    </div>
                </div>
                <div class="card-body text-center p-4">
                    <div class="avatar-placeholder mb-3">
                        <img src="${cardData.avatar || '/assets/images/default-avatar.png'}" 
                             alt="Avatar" class="rounded-circle" width="60" height="60">
                    </div>
                    <h5 class="fw-bold">${cardData.user_name}</h5>
                    <p class="text-muted">${cardData.card_number}</p>
                    <div class="qr-placeholder mb-3">
                        <img src="${UffApp.generateQRCode(cardData.qr_code)}" 
                             alt="QR Code" width="80" height="80">
                    </div>
                    <small class="text-muted">Válida hasta ${UffApp.formatDate(cardData.expiry_date)}</small>
                </div>
            </div>
        `;
        return cardHtml;
    }
};

// Map functionality
const MapManager = {
    map: null,
    markers: [],
    
    initMap(elementId, center = { lat: 19.4326, lng: -99.1332 }) {
        this.map = new google.maps.Map(document.getElementById(elementId), {
            zoom: 13,
            center: center,
            styles: [
                {
                    featureType: 'poi',
                    elementType: 'labels',
                    stylers: [{ visibility: 'off' }]
                }
            ]
        });
        return this.map;
    },
    
    addBusinessMarker(business) {
        const marker = new google.maps.Marker({
            position: { lat: parseFloat(business.latitude), lng: parseFloat(business.longitude) },
            map: this.map,
            title: business.business_name,
            icon: {
                url: '/assets/images/business-marker.png',
                scaledSize: new google.maps.Size(40, 40)
            }
        });
        
        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div class="p-2">
                    <h6 class="fw-bold">${business.business_name}</h6>
                    <p class="small text-muted mb-1">${business.address}</p>
                    <p class="small mb-0">${business.benefits_offered}</p>
                </div>
            `
        });
        
        marker.addListener('click', () => {
            infoWindow.open(this.map, marker);
        });
        
        this.markers.push(marker);
        return marker;
    },
    
    clearMarkers() {
        this.markers.forEach(marker => marker.setMap(null));
        this.markers = [];
    }
};

// Dashboard functionality
const Dashboard = {
    charts: {},
    
    initCharts() {
        this.initTransactionChart();
        this.initSavingsChart();
        this.initBusinessChart();
    },
    
    initTransactionChart() {
        const ctx = document.getElementById('transactionChart');
        if (!ctx) return;
        
        this.charts.transactions = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Transacciones',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    },
    
    initSavingsChart() {
        const ctx = document.getElementById('savingsChart');
        if (!ctx) return;
        
        this.charts.savings = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Usado', 'Disponible'],
                datasets: [{
                    data: [30, 70],
                    backgroundColor: ['#dc3545', '#28a745']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    },
    
    initBusinessChart() {
        const ctx = document.getElementById('businessChart');
        if (!ctx) return;
        
        this.charts.business = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Restaurantes', 'Moda', 'Fitness', 'Belleza', 'Tech'],
                datasets: [{
                    label: 'Transacciones',
                    data: [65, 45, 30, 25, 20],
                    backgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
};

// Initialize app when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    UffApp.init();
    
    // Initialize dashboard if on dashboard page
    if (document.querySelector('.dashboard-content')) {
        Dashboard.initCharts();
    }
    
    // Initialize map if on map page
    if (document.getElementById('businessMap')) {
        // Note: Google Maps API would need to be loaded
        // MapManager.initMap('businessMap');
    }
});

// Export for use in other files
window.UffApp = UffApp;
window.CardManager = CardManager;
window.MapManager = MapManager;
window.Dashboard = Dashboard;