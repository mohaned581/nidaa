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
        // Handle document upload
        $document_path = null;
        if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = realpath(__DIR__ . '/../../public') . '/uploads/documents/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $filename = time() . '_' . basename($_FILES['document']['name']);
            $target_file = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['document']['tmp_name'], $target_file)) {
                $document_path = 'uploads/documents/' . $filename;
            }
        }

        $sql = "INSERT INTO orders (user_id, age, phone, country, city, category, message, document_path, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$user_id, $age, $phone, $country, $city, $category, $message, $document_path])) {
            header("Location: index.php?page=user_dashboard&success=request_submitted");
            exit;
        } else {
            $error = "Failed to submit request.";
        }
    }
}
?>
