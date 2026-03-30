<?php
// app/controllers/AuthController.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role']; // user or donor

        // Basic validation
        if (empty($name) || empty($username) || empty($email) || empty($password) || empty($role)) {
            $error = "All fields are required.";
        } else {
            // Check if user exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $stmt->execute([$email, $username]);
            if ($stmt->fetch()) {
                $error = "User already exists.";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert user
                $sql = "INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute([$name, $username, $email, $hashed_password, $role])) {
                    // Redirect to login
                    header("Location: index.php?page=login&success=registered");
                    exit;
                } else {
                    $error = "Registration failed.";
                }
            }
        }
    } elseif ($action === 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];
// check if credintials are correct
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: index.php?page=admin_dashboard");
            } elseif ($user['role'] === 'donor') {
                header("Location: index.php?page=donor_dashboard");
            } else {
                header("Location: index.php?page=user_dashboard");
            }
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}

// Handle Logout via GET
if (isset($_GET['page']) && $_GET['page'] === 'logout') {
    session_destroy();
    header("Location: index.php?page=home");
    exit;
}
?>
