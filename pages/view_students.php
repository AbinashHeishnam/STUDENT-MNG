<?php
require_once '../src/config/database.php';
require_once '../src/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['student_id'];
    $success = deleteStudent($conn, $id);
    if ($success) {
        header("Location: view_students.php");
        exit;
    }
}

$students = getAllStudents($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students - RGU</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="dark-theme">
    <div class="app-container">
        <header class="app-header">
            <div class="header-left">
                <h1 class="page-title">Student Records</h1>
            </div>
            <a href="../index.php" class="back-link">
                <span class="material-icons">home</span>
                Dashboard
            </a>
        </header>

        <main class="app-main">
            <div class="view-container">
                <div class="table-actions">
                    <div class="search-box">
                        <i class="material-icons search-icon">search</i>
                        <input type="text" id="searchInput" 
                               class="search-input" 
                               placeholder="Search by name, email or course..."
                               oninput="filterStudents(this.value)">
                    </div>
                </div>

                <div class="students-list">
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $student): ?>
                            <div class="student-row" 
                                 data-searchable="<?php echo strtolower(htmlspecialchars($student['name'] ?? '') . ' ' . 
                                                                   htmlspecialchars($student['email'] ?? '') . ' ' . 
                                                                   htmlspecialchars($student['course'] ?? '')); ?>">
                                <div class="student-info">
                                    <div class="student-avatar">
                                        <i class="material-icons">person</i>
                                    </div>
                                    <div class="student-details">
                                        <span class="student-name"><?php echo htmlspecialchars($student['name'] ?? ''); ?></span>
                                        <span class="detail-divider">|</span>
                                        <span class="student-email"><?php echo htmlspecialchars($student['email'] ?? ''); ?></span>
                                        <span class="detail-divider">|</span>
                                        <span class="course-tag"><?php echo htmlspecialchars($student['course'] ?? 'No Course'); ?></span>
                                    </div>
                                </div>
                                <div class="student-actions">
                                    <form method="POST">
                                        <input type="hidden" name="student_id" value="<?php echo (int)($student['id'] ?? 0); ?>">
                                        <button type="submit" name="delete" class="action-btn delete">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-records">
                            <span class="material-icons">sentiment_dissatisfied</span>
                            <p>No students found</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        function filterStudents(query) {
            query = query.toLowerCase();
            const rows = document.querySelectorAll('.student-row');
            
            rows.forEach(row => {
                const searchText = row.getAttribute('data-searchable');
                row.style.display = searchText.includes(query) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
