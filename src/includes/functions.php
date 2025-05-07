<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getAllStudents($conn) {
    try {
        // Replace ping() with a simple query test
        if ($conn->query('SELECT 1')) {
            $sql = "SELECT * FROM students ORDER BY created_at DESC";
            $result = $conn->query($sql);
            
            if (!$result) {
                throw new Exception($conn->error);
            }
            
            $students = [];
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
            
            // Debug info
            error_log("Found " . count($students) . " students");
            return $students;
        } else {
            throw new Exception("Database connection lost");
        }
    } catch (Exception $e) {
        error_log("Error in getAllStudents: " . $e->getMessage());
        return [];
    }
}

function addStudent($conn, $data) {
    try {
        // Prepare variables for binding
        $name = trim($data['name']);
        $email = trim($data['email']);
        $course = trim($data['course']);

        // Check for email uniqueness
        $checkEmail = $conn->prepare("SELECT id FROM students WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        if ($checkEmail->get_result()->num_rows > 0) {
            throw new Exception("Email already exists");
        }

        // Add new student
        $stmt = $conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        
        // Bind parameters
        $stmt->bind_param("sss", $name, $email, $course);
        
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    } catch (Exception $e) {
        error_log("Error in addStudent: " . $e->getMessage());
        return false;
    }
}

function deleteStudent($conn, $id) {
    try {
        $id = intval($id);
        
        // Validate ID
        if ($id <= 0) {
            throw new Exception("Invalid student ID");
        }
        
        $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        
        if (!$result) {
            throw new Exception("Failed to delete student");
        }
        
        $stmt->close();
        return true;
        
    } catch (Exception $e) {
        error_log("Delete error: " . $e->getMessage());
        return false;
    }
}

function deleteMultipleStudents($conn, $ids) {
    try {
        $ids = array_map('intval', $ids);
        $idList = implode(',', $ids);
        
        $sql = "DELETE FROM students WHERE id IN ($idList)";
        $result = $conn->query($sql);
        
        return ['success' => $result, 'message' => $result ? 'Students deleted successfully' : $conn->error];
    } catch (Exception $e) {
        error_log($e->getMessage());
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

function editStudent($conn, $data) {
    try {
        $id = intval($data['id']);
        $name = trim($data['name']);
        $email = trim($data['email']);
        $phone = trim($data['phone']);
        $course = trim($data['course']);
        $address = trim($data['address']);

        if (empty($id) || empty($name) || empty($email)) {
            return ['success' => false, 'message' => "Required fields are missing"];
        }

        // Check if email exists for another student
        $checkStmt = $conn->prepare("SELECT id FROM students WHERE email = ? AND id != ?");
        $checkStmt->bind_param("si", $email, $id);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            return ['success' => false, 'message' => "Email already exists for another student"];
        }

        // Update student data
        $stmt = $conn->prepare("UPDATE students SET name=?, email=?, phone=?, course=?, address=? WHERE id=?");
        if (!$stmt) {
            return ['success' => false, 'message' => $conn->error];
        }
        
        $stmt->bind_param("sssssi", $name, $email, $phone, $course, $address, $id);
        $success = $stmt->execute();
        
        return ['success' => $success, 'message' => $success ? 'Updated successfully' : $conn->error];
    } catch (Exception $e) {
        error_log($e->getMessage());
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

function getStudentById($conn, $id) {
    try {
        $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }
}

function searchStudents($conn, $search = '') {
    try {
        if (empty($search)) {
            return getAllStudents($conn);
        }

        $search = "%{$search}%";
        $stmt = $conn->prepare(
            "SELECT * FROM students 
             WHERE name LIKE ? 
             OR email LIKE ? 
             OR course LIKE ? 
             ORDER BY created_at DESC"
        );
        
        if (!$stmt) {
            throw new Exception($conn->error);
        }
        
        $stmt->bind_param("sss", $search, $search, $search);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $students = [];
        
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
        
        return $students;
        
    } catch (Exception $e) {
        error_log("Search error: " . $e->getMessage());
        return [];
    }
}
?>
