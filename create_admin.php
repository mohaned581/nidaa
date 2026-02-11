<?php
require_once 'app/config/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'admin';

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        if ($stmt->fetch()) {
            $message = "<div style='color:red'>User with this email or username already exists.</div>";
        } else {
            $sql = "INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$name, $username, $email, $hashed_password, $role])) {
                $message = "<div style='color:green'>Admin account <b>$username</b> created successfully!</div>";
            } else {
                $message = "<div style='color:red'>Failed to create admin account.</div>";
            }
        }
    } catch (PDOException $e) {
        $message = "<div style='color:red'>Error: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Admin User</title>
    <style>
        body { font-family: sans-serif; padding: 2rem; max-width: 500px; margin: 0 auto; background: #f4f4f4; }
        .form-container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        input { width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 0.75rem; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        button:hover { background: #c82333; }
        a { display: block; text-align: center; margin-top: 1rem; color: #666; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 style="text-align: center;">Create New Admin</h2>
        
        <?php echo $message; ?>

        <form method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Create Admin Account</button>
        </form>
        
        <a href="public/index.php">Back to Home</a>
    </div>
</body>
</html>
