# Student Management System

A web-based student management system built with PHP, MySQL, and modern CSS. Features a responsive design with dark/light theme support.

## Features

- 🎯 CRUD Operations for Student Records
- 🌓 Dark/Light Theme Toggle
- 🔍 Real-time Student Search
- 📱 Responsive Design
- ✨ Modern UI with Animations
- 🔒 Data Validation & Security
- 📊 Clean Data Organization

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web Server (Apache/Nginx) or PHP's built-in server

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/student_management_project.git
cd student_management_project
```

2. Configure database:
   - Edit `/src/config/database.php`
   - Update credentials:
```php
$host = 'localhost';
$user = 'your_username';
$password = 'your_password';
$dbname = 'student_management';
```

3. Start the server:
```bash
php -S localhost:8000
```

4. Access the application:
   - Visit `http://localhost:8000` in your browser

## Project Structure

```
student_management_project/
├── assets/
│   └── css/
│       └── styles.css
├── src/
│   ├── config/
│   │   └── database.php
│   ├── includes/
│   │   └── functions.php
│   └── setup/
│       └── install.php
├── index.php
└── README.md
```

## Features in Detail

### Student Management
- Add new students with details:
  - Full Name
  - Email Address (unique)
  - Phone Number
  - Course
  - Address

### Data Validation
- Email uniqueness check
- Required field validation
- Input sanitization

### UI/UX Features
- Responsive design for all devices
- Dark/Light theme toggle
- Interactive form elements
- Smooth animations
- Real-time search functionality

### Security Features
- SQL injection prevention
- XSS protection
- Input validation
- Error handling

## API Functions

### Core Functions
- `addStudent($conn, $data)`: Add new student
- `getAllStudents($conn)`: Retrieve all students
- `editStudent($conn, $data)`: Update student details
- `deleteStudent($conn, $id)`: Remove student
- `getStudentById($conn, $id)`: Get single student

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Authors

- Your Name - *Initial work*

## Acknowledgments

- PHP Documentation
- MySQL Documentation
- Modern CSS Techniques
