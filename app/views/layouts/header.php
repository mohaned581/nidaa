<!-- app/views/layouts/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Humanitarian Aid Platform</title>
    <link rel="stylesheet" href="/myproject/new%20web/public/css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php?page=home" class="logo">AidConnect</a>
            <div class="nav-links">
                <a href="index.php?page=home">Home</a>
                <a href="index.php?page=programs">Programs</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Logged In Links -->
                    <?php if ($_SESSION['role'] == 'user'): ?>
                        <a href="index.php?page=submit_request">Request Aid</a>
                        <a href="index.php?page=contact_admin">Contact Admin</a>
                        <a href="index.php?page=user_dashboard">Dashboard</a>
                    <?php elseif ($_SESSION['role'] == 'donor'): ?>
                        <a href="index.php?page=donate">Donate Now</a>
                        <a href="index.php?page=donor_dashboard">Dashboard</a>
                    <?php elseif ($_SESSION['role'] == 'admin'): ?>
                        <a href="index.php?page=admin_dashboard">Admin Panel</a>
                    <?php endif; ?>
                    
                    <a href="index.php?page=logout" class="btn btn-secondary">Logout</a>
                <?php else: ?>
                    <!-- Guest Links -->
                    <div class="auth-buttons" style="display:inline;">
                        <a href="index.php?page=login" class="btn btn-secondary">Login</a>
                        <a href="index.php?page=register" class="btn btn-primary">Register</a>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>
