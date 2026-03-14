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
    case 'contact_admin':
        require_once APP_ROOT . '/views/user/contact.php';
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
    case 'admin_posts':
        require_once APP_ROOT . '/views/admin/posts.php';
        break;
    case 'admin_documents':
        require_once APP_ROOT . '/views/admin/documents.php';
        break;
    case 'admin_messages':
        require_once APP_ROOT . '/views/admin/messages.php';
        break;
    case 'admin_reports':
        require_once APP_ROOT . '/views/admin/reports.php';
        break;
        
    // Public/Programs View
    case 'programs':
        require_once APP_ROOT . '/views/programs.php';
        break;

    default:
        echo "<h1>404 Not Found</h1>";
        break;
}

// Footer
require_once APP_ROOT . '/views/layouts/footer.php';
?>
