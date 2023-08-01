<?php
// Database configuration
require_once 'a.php';
// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to hash the password using bcrypt
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Function to validate and sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to check if a username or email already exists
function userExists($conn, $username, $email) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $username = sanitizeInput($_POST["username"]);
    $email = sanitizeInput($_POST["email"]);
    $generatedCode = sanitizeInput($_POST["generatedcode"]);
    $surname = sanitizeInput($_POST["surname"]);
    $password = sanitizeInput($_POST["password"]);

    // Check if username or email already exists
    if (userExists($conn, $username, $email)) {
        // Redirect back to the registration page with an error message
        header("Location: register.html?error=exists");
        exit();
    }

    // Hash the password
    $hashedPassword = hashPassword($password);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, generatedcode, surname, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $generatedCode, $surname, $hashedPassword);

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful
        header("Location: home.html");
        exit();
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
