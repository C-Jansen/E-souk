<?php
// Environment detection
define('ENVIRONMENT', isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : 'development');

// Error reporting based on environment
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Define base paths
define('ROOT_PATH', dirname(__DIR__));
define('ASSETS_PATH', ROOT_PATH . '/public/assets');
define('UPLOADS_PATH', ROOT_PATH . '/public/uploads');
define('CONFIG_PATH', ROOT_PATH . '/config');

// Define application URLs with trailing slash handling
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$domainName = $_SERVER['HTTP_HOST'];
$basePath = '/E-souk-strack/';
define('ROOT_URL', $protocol . $domainName . $basePath);
define('ASSETS_URL', ROOT_URL . 'public/assets/');
define('UPLOADS_URL', ROOT_URL . 'public/uploads/');

// Security headers
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    // Set secure cookie parameters if in production
    if (ENVIRONMENT === 'production') {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.cookie_secure', 1);
        ini_set('session.use_only_cookies', 1);
    }
    session_start();
}

// Database connection - with lazy loading
function getDB() {
    static $db = null;
    if ($db === null) {
        require_once ROOT_PATH . '/core/connection.php';
        $db = Database::getInstance();
    }
    return $db;
}

// Get database connection only when needed
$db = getDB();
?>
