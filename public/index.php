<?php
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/includes/functions.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $success = addStudent($conn, $_POST);
        $message = $success ? "Student added successfully!" : "Error adding student";
    }
    if (isset($_POST['delete'])) {
        $success = deleteStudent($conn, $_POST['id']);
        $message = $success ? "Student deleted successfully!" : "Error deleting student";
    }
}

$students = getAllStudents($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="nav-brand">SMS</a>
            <ul class="nav-menu">
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="#add-student">Add Student</a></li>
                <li><a href="#student-list">View Students</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <header class="page-header">
            <h1>Student Management System</h1>
            <?php if ($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
        </header>

        <section id="add-student" class="card">
            <h2>Add New Student</h2>
            <form method="POST" class="student-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter full name" required>
                    
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter email" required>
                    
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter phone number">
                    
                    <label for="course">Course</label>
                    <input type="text" id="course" name="course" placeholder="Enter course name">
                    
                    <label for="address">Address</label>
                    <textarea id="address" name="address" placeholder="Enter address"></textarea>
                    
                    <button type="submit" name="add" class="btn-primary">Add Student</button>
                </div>
            </form>
        </section>

        <section id="student-list" class="card">
            <h2>Student List</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($students) > 0): ?>
                            <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                <td><?php echo htmlspecialchars($student['course']); ?></td>
                                <td><?php echo htmlspecialchars($student['address']); ?></td>
                                <td class="actions">
                                    <form method="POST" class="inline-form">
                                        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                                        <button type="submit" name="delete" class="btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this student?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="no-records">No students found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Student Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
