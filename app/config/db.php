<?php
// app/config/db.php

$host = '127.0.0.1';
$db   = 'aid_platform';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // 1. Connect without Database selected (to create it if needed)
    $dsn_no_db = "mysql:host=$host;charset=$charset";
    $pdo = new PDO($dsn_no_db, $user, $pass, $options);
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db`");
    
    // 2. Connect WITH Database selected
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (\PDOException $e) {
    // Show error message
    die("Database Connection Error: " . $e->getMessage());
}
?>
