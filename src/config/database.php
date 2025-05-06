<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Remove session_start() from here since it's already in index.php

$host = 'localhost';
$user = 'root';     
$password = 'root';     
$dbname = 'my_database';

try {
    $conn = new mysqli($host, $user, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Test connection without using deprecated ping()
    if (!$conn->query('SELECT 1')) {
        throw new Exception("Database connection test failed");
    }

    // Select/Create database
    $conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
    $conn->select_db($dbname);

    // Create table with proper structure
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(15),
        course VARCHAR(50),
        address VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    if (!$conn->query($sql)) {
        throw new Exception("Error creating table: " . $conn->error);
    }

} catch (Exception $e) {
    die("<div style='color:red; padding:10px;'>" . $e->getMessage() . "</div>");
}
?>
