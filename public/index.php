<?php
// public/index.php
session_start();

// Basic Router
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Path definitions
define('APP_ROOT', __DIR__ . '/../app');

// Include DB
require_once APP_ROOT . '/config/db.php';

// Header
require_once APP_ROOT . '/views/layouts/header.php';

// Routes
switch ($page) {
    case 'home':
        require_once APP_ROOT . '/views/home.php';
        break;
    case 'register':
        require_once APP_ROOT . '/controllers/AuthController.php';
        // Logic to show register form is likely inside controller or just include view directly if simple
        require_once APP_ROOT . '/views/auth/register.php';
        break;
    case 'login':
        require_once APP_ROOT . '/controllers/AuthController.php';
        require_once APP_ROOT . '/views/auth/login.php';
        break;
    case 'logout':
        require_once APP_ROOT . '/controllers/AuthController.php';
        // logout logic
        break;
        
    // User Routes
    case 'user_dashboard':
        // Auth check needed
        require_once APP_ROOT . '/views/user/dashboard.php';
        break;
    case 'submit_request':
        require_once APP_ROOT . '/views/user/request_aid.php';
        break;

    // Donor Routes
    case 'donor_dashboard':
        require_once APP_ROOT . '/views/donor/dashboard.php';
        break;
    case 'donate':
         require_once APP_ROOT . '/views/donor/donate.php';
         break;

    // Admin Routes
    case 'admin_dashboard':
        require_once APP_ROOT . '/views/admin/dashboard.php';
        break;
        
    default:
        echo "<h1>404 Not Found</h1>";
        break;
}

// Footer
require_once APP_ROOT . '/views/layouts/footer.php';
?>
