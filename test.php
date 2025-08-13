<?php
/**
 * Basic Test Suite for Uff! Platform
 * Run this file to verify the installation is working correctly
 */

// Start output buffering to capture any errors
ob_start();
$errors = [];
$success = [];

echo "<h1>Uff! Platform - Installation Test</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; }
    .error { color: red; }
    .info { color: blue; }
    pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
</style>";

// Test 1: PHP Version
echo "<h2>1. PHP Version Check</h2>";
if (version_compare(PHP_VERSION, '8.2.0', '>=')) {
    echo "<p class='success'>✓ PHP Version: " . PHP_VERSION . " (Required: 8.2+)</p>";
    $success[] = "PHP Version OK";
} else {
    echo "<p class='error'>✗ PHP Version: " . PHP_VERSION . " (Required: 8.2+)</p>";
    $errors[] = "PHP version too old";
}

// Test 2: Required Extensions
echo "<h2>2. PHP Extensions Check</h2>";
$requiredExtensions = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'curl'];
foreach ($requiredExtensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<p class='success'>✓ Extension: $ext</p>";
    } else {
        echo "<p class='error'>✗ Extension: $ext (Missing)</p>";
        $errors[] = "Missing extension: $ext";
    }
}

// Test 3: Configuration Files
echo "<h2>3. Configuration Files Check</h2>";
$configFiles = [
    'config/config.php' => 'Main configuration',
    'config/database.php' => 'Database configuration'
];

foreach ($configFiles as $file => $description) {
    if (file_exists($file)) {
        echo "<p class='success'>✓ $description: $file</p>";
    } else {
        echo "<p class='error'>✗ $description: $file (Missing)</p>";
        $errors[] = "Missing file: $file";
    }
}

// Test 4: Directory Permissions
echo "<h2>4. Directory Permissions Check</h2>";
$directories = [
    'uploads' => 'Upload directory',
    'assets' => 'Assets directory',
    'sql' => 'SQL directory'
];

foreach ($directories as $dir => $description) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "<p class='success'>✓ $description: $dir (Writable)</p>";
        } else {
            echo "<p class='error'>✗ $description: $dir (Not writable)</p>";
            $errors[] = "Directory not writable: $dir";
        }
    } else {
        echo "<p class='error'>✗ $description: $dir (Missing)</p>";
        $errors[] = "Missing directory: $dir";
    }
}

// Test 5: Class Loading
echo "<h2>5. Class Loading Test</h2>";
try {
    if (file_exists('config/config.php')) {
        require_once 'config/config.php';
        echo "<p class='success'>✓ Configuration loaded successfully</p>";
        $success[] = "Configuration loading OK";
        
        // Test database connection (if config exists)
        if (class_exists('Database')) {
            try {
                $db = Database::getInstance();
                $conn = $db->getConnection();
                echo "<p class='success'>✓ Database connection successful</p>";
                $success[] = "Database connection OK";
                
                // Test sample data
                $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
                $result = $stmt->fetch();
                echo "<p class='info'>ℹ Users in database: " . $result['count'] . "</p>";
                
                $stmt = $conn->query("SELECT COUNT(*) as count FROM businesses");
                $result = $stmt->fetch();
                echo "<p class='info'>ℹ Businesses in database: " . $result['count'] . "</p>";
                
            } catch (Exception $e) {
                echo "<p class='error'>✗ Database connection failed: " . $e->getMessage() . "</p>";
                $errors[] = "Database connection failed";
            }
        }
        
        // Test Auth class
        if (class_exists('Auth')) {
            echo "<p class='success'>✓ Auth class loaded successfully</p>";
            $success[] = "Auth class loading OK";
        } else {
            echo "<p class='error'>✗ Auth class not found</p>";
            $errors[] = "Auth class missing";
        }
        
        // Test User model
        if (class_exists('User')) {
            echo "<p class='success'>✓ User model loaded successfully</p>";
            $success[] = "User model loading OK";
        } else {
            echo "<p class='error'>✗ User model not found</p>";
            $errors[] = "User model missing";
        }
        
    } else {
        echo "<p class='error'>✗ Configuration file not found</p>";
        $errors[] = "Configuration file missing";
    }
} catch (Exception $e) {
    echo "<p class='error'>✗ Class loading failed: " . $e->getMessage() . "</p>";
    $errors[] = "Class loading failed";
}

// Test 6: File Structure
echo "<h2>6. File Structure Check</h2>";
$importantFiles = [
    'index.html' => 'Landing page',
    'login.php' => 'Login page',
    'register.php' => 'Registration page',
    'logout.php' => 'Logout script',
    'user/dashboard.php' => 'User dashboard',
    'assets/css/style.css' => 'Main stylesheet',
    'assets/js/main.js' => 'Main JavaScript',
    'sql/schema.sql' => 'Database schema',
    'sql/sample_data.sql' => 'Sample data',
    '.htaccess' => 'Apache configuration'
];

foreach ($importantFiles as $file => $description) {
    if (file_exists($file)) {
        echo "<p class='success'>✓ $description: $file</p>";
    } else {
        echo "<p class='error'>✗ $description: $file (Missing)</p>";
        $errors[] = "Missing file: $file";
    }
}

// Test 7: URLs Test
echo "<h2>7. URL Accessibility Test</h2>";
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
echo "<p class='info'>Base URL: $baseUrl</p>";

$testUrls = [
    '' => 'Landing page',
    'login' => 'Login page',
    'register' => 'Registration page'
];

foreach ($testUrls as $path => $description) {
    $url = $baseUrl . '/' . $path;
    echo "<p class='info'>• <a href='$url' target='_blank'>$description</a>: $url</p>";
}

// Summary
echo "<h2>8. Installation Summary</h2>";

if (empty($errors)) {
    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 5px;'>";
    echo "<h3>✓ Installation Successful!</h3>";
    echo "<p>All tests passed. Your Uff! Platform installation is ready to use.</p>";
    echo "<p><strong>Next steps:</strong></p>";
    echo "<ul>";
    echo "<li>Visit the <a href='index.html'>landing page</a> to see the platform</li>";
    echo "<li>Try logging in with the demo credentials at <a href='login.php'>login page</a></li>";
    echo "<li>Configure your APIs (Google Maps, PayPal, SMTP) in config/config.php</li>";
    echo "<li>Review the <a href='INSTALL.md'>installation guide</a> for production setup</li>";
    echo "</ul>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<h3>✗ Installation Issues Found</h3>";
    echo "<p>The following issues need to be resolved:</p>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
    echo "<p>Please refer to the <a href='INSTALL.md'>installation guide</a> for solutions.</p>";
    echo "</div>";
}

echo "<h3>Test Results:</h3>";
echo "<p>✓ Successful tests: " . count($success) . "</p>";
echo "<p>✗ Failed tests: " . count($errors) . "</p>";

// Show error log if there were any PHP errors
$output = ob_get_clean();
echo $output;

if (!empty($errors)) {
    echo "<h3>Troubleshooting Tips:</h3>";
    echo "<pre>";
    echo "1. Make sure PHP 8.2+ is installed and running\n";
    echo "2. Install missing PHP extensions using your package manager\n";
    echo "3. Set proper directory permissions: chmod 755 for directories, 644 for files\n";
    echo "4. Make uploads directory writable: chmod 777 uploads/\n";
    echo "5. Import the database schema and sample data\n";
    echo "6. Configure database credentials in config/database.php\n";
    echo "7. Set up your web server to point to this directory\n";
    echo "</pre>";
}

echo "<hr>";
echo "<p><small>Test completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>