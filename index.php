<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'src/config/database.php';
require_once 'src/includes/functions.php';
$students = getAllStudents($conn);
$studentCount = count($students);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RGU - Student Management</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="dark-theme">
    <div class="app-container">
        <header class="app-header">
            <div class="brand">
                <h1>Royal Global University</h1>
            </div>
        </header>

        <main class="app-main">
            <div class="welcome-section">
                <h2>Student Management Dashboard</h2>
                <p>Welcome to the student management system</p>
            </div>

            <div class="stats-container">
                <div class="stat-card primary">
                    <span class="material-icons">school</span>
                    <div class="stat-info">
                        <h3>Total Students</h3>
                        <p class="stat-number"><?php echo $studentCount ?? 0; ?></p>
                    </div>
                </div>
                <div class="stat-card secondary">
                    <span class="material-icons">groups</span>
                    <div class="stat-info">
                        <h3>Faculty Members</h3>
                        <p class="stat-number">45</p>
                    </div>
                </div>
            </div>

            <div class="action-container">
                <a href="pages/add_student.php" class="action-card">
                    <div class="action-icon">
                        <span class="material-icons">person_add</span>
                    </div>
                    <div class="action-info">
                        <h3>Add New Student</h3>
                        <p>Register a new student in the system</p>
                    </div>
                </a>
                <a href="pages/view_students.php" class="action-card">
                    <div class="action-icon">
                        <span class="material-icons">list_alt</span>
                    </div>
                    <div class="action-info">
                        <h3>View Students</h3>
                        <p>Manage and view all student records</p>
                    </div>
                </a>
            </div>

            <section class="about-section">
                <h2>About RGU</h2>
                <p>Royal Global University is a premier educational institution in Northeast India, offering diverse programs in engineering, management, law, and liberal arts.</p>
            </section>
        </main>

        <footer class="app-footer">
            <p>&copy; <?php echo date('Y'); ?> Royal Global University</p>
        </footer>
    </div>
</body>
</html>