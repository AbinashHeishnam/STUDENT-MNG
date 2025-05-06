<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Update require paths
require_once 'src/config/database.php';
require_once 'src/includes/functions.php';

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
    if (isset($_POST['edit'])) {
        $result = editStudent($conn, $_POST);
        $message = isset($result['success']) && $result['success'] 
            ? "Student updated successfully!" 
            : "Error: " . (isset($result['message']) ? $result['message'] : "Unknown error");
    }
}

// Get student for editing if ID is provided
$editingStudent = null;
if (isset($_GET['edit'])) {
    $editingStudent = getStudentById($conn, $_GET['edit']);
}

$students = getAllStudents($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container nav-container">
            <a href="index.php" class="nav-brand">ROYAL GLOBAL UNIVERSITY</a>
            <ul class="nav-menu">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">Dashboard</a>
                    <ul class="dropdown-menu">
                        <li><a href="#add-student">Add Student</a></li>
                        <li><a href="#student-list">View Students</a></li>
                    </ul>
                </li>
                <li>
                    <button id="theme-toggle" class="theme-toggle" aria-label="Toggle theme">
                        <svg class="sun-icon" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.65 0-3 1.35-3 3s1.35 3 3 3 3-1.35 3-3-1.35-3-3-3z"/>
                            <path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42m12.72-12.72l1.42-1.42"/>
                        </svg>
                        <svg class="moon-icon" viewBox="0 0 24 24" width="24" height="24">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 A7 7 0 0 0 21 12.79z"/>
                        </svg>
                    </button>
                </li>
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
            <h2><?php echo $editingStudent ? 'Edit Student' : 'Add New Student'; ?></h2>
            <form method="POST" class="student-form">
                <?php if ($editingStudent): ?>
                    <input type="hidden" name="id" value="<?php echo $editingStudent['id']; ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo $editingStudent ? htmlspecialchars($editingStudent['name']) : ''; ?>" placeholder="Enter full name" required>
                    
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?php echo $editingStudent ? htmlspecialchars($editingStudent['email']) : ''; ?>" placeholder="Enter email" required>
                    
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $editingStudent ? htmlspecialchars($editingStudent['phone']) : ''; ?>" placeholder="Enter phone number">
                    
                    <label for="course">Course</label>
                    <input type="text" id="course" name="course" value="<?php echo $editingStudent ? htmlspecialchars($editingStudent['course']) : ''; ?>" placeholder="Enter course name">
                    
                    <label for="address">Address</label>
                    <textarea id="address" name="address" placeholder="Enter address"><?php echo $editingStudent ? htmlspecialchars($editingStudent['address']) : ''; ?></textarea>
                    
                    <button type="submit" name="<?php echo $editingStudent ? 'edit' : 'add'; ?>" class="btn-primary">
                        <?php echo $editingStudent ? 'Update Student' : 'Add Student'; ?>
                    </button>
                </div>
            </form>
        </section>

        <section id="student-list" class="card">
            <h2>Student List</h2>
            <!-- Add search functionality -->
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Search students..." onkeyup="searchStudents()">
            </div>
            
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
                                    <a href="?edit=<?php echo $student['id']; ?>" class="btn-secondary">Edit</a>
                                    <form method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
                                        <button type="submit" name="delete" class="btn-danger">Delete</button>
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

    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background: var(--card);
            min-width: 160px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            border-radius: 4px;
            padding: 0.5rem 0;
            z-index: 1000;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu li {
            list-style: none;
        }

        .dropdown-menu a {
            display: block;
            padding: 0.5rem 1rem;
            color: var(--text);
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .dropdown-menu a:hover {
            background-color: var(--border);
        }

        .dropdown-toggle::after {
            content: '▼';
            font-size: 0.7em;
            margin-left: 0.5em;
            vertical-align: middle;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('theme-toggle');
            const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
            
            function setTheme(theme) {
                document.body.className = theme;
                localStorage.setItem('theme', theme);
            }

            // Load saved theme or use system preference
            const savedTheme = localStorage.getItem('theme') || (prefersDarkScheme.matches ? 'dark-theme' : 'light-theme');
            setTheme(savedTheme);

            themeToggle.addEventListener('click', () => {
                const currentTheme = document.body.className;
                const newTheme = currentTheme === 'dark-theme' ? 'light-theme' : 'dark-theme';
                setTheme(newTheme);
            });
});
    </script>
</body>
</html>