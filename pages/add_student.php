<?php
require_once '../src/config/database.php';
require_once '../src/includes/functions.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = addStudent($conn, $_POST);
    $message = $success ? "Student added successfully!" : "Error adding student";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student - RGU</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="dark-theme">
    <div class="app-container">
        <header class="app-header">
            <div class="brand">
                <h1>Add New Student</h1>
            </div>
            <a href="../index.php" class="back-link">
                <span class="material-icons">arrow_back</span>
                Dashboard
            </a>
        </header>

        <main class="app-main">
            <div class="form-wrapper">
                <?php if ($message): ?>
                    <div class="message"><?php echo $message; ?></div>
                <?php endif; ?>
                <form method="POST" class="student-form">
                    <div class="input-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="input-group">
                        <label for="course">Course</label>
                        <input type="text" id="course" name="course" required>
                    </div>

                    <button type="submit" name="add" class="submit-btn">Add Student</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
