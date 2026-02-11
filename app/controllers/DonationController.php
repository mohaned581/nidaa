<?php
// app/controllers/DonationController.php

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header("Location: index.php?page=login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $category = $_POST['category'];
    $message = $_POST['message'];
    $donor_id = $_SESSION['user_id'];
    
    // Mock Payment Processing
    // In a real app, this would interact with Stripe/PayPal API
    $payment_success = true; // Simulating success

    if ($payment_success) {
        if (empty($amount) || empty($category)) {
             $error = "Amount and Category are required.";
        } else {
             $sql = "INSERT INTO donations (donor_id, amount, category, message) VALUES (?, ?, ?, ?)";
             $stmt = $pdo->prepare($sql);
             
             if ($stmt->execute([$donor_id, $amount, $category, $message])) {
                 header("Location: index.php?page=donor_dashboard&success=donation_made");
                 exit;
             } else {
                 $error = "Failed to record donation.";
             }
        }
    } else {
        $error = "Payment failed.";
    }
}
?>
