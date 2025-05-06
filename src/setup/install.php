<?php
require_once __DIR__ . '/../config/database.php';

function setupDatabase() {
    global $conn;
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
    if ($conn->query($sql)) {
        echo "Database created successfully<br>";
    }

    // Select database
    $conn->select_db(DB_NAME);

    // Create students table
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        phone VARCHAR(15),
        course VARCHAR(50),
        address VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql)) {
        echo "Tables created successfully<br>";
        echo "<a href='/'>Go to homepage</a>";
    }
}

// Run setup
if (isset($_POST['install'])) {
    setupDatabase();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Install System</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>System Installation</h2>
            <form method="POST">
                <button type="submit" name="install" class="btn-primary">Install System</button>
            </form>
        </div>
    </div>
</body>
</html>
