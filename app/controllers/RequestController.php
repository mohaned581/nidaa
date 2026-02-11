<?php
// app/controllers/RequestController.php

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php?page=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $category = $_POST['category'];
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    if (empty($age) || empty($country) || empty($category)) {
        $error = "Please fill in all required fields.";
    } else {
        $sql = "INSERT INTO orders (user_id, age, phone, country, city, category, message, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$user_id, $age, $phone, $country, $city, $category, $message])) {
            header("Location: index.php?page=user_dashboard&success=request_submitted");
            exit;
        } else {
            $error = "Failed to submit request.";
        }
    }
}
?>
