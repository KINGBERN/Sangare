<?php
require_once 'a.php';

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the email and password (add your validation logic here)
    if (validateEmail($email) && validatePassword($password)) {
        // Check if the email exists in the database
        $userExists = checkEmailExists($conn, $email);

        if ($userExists) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Update the hashed password for the user in the database
            $success = updatePassword($conn, $email, $hashedPassword);

            if ($success) {
                // Password changed successfully
                $response = array('success' => true);
                echo json_encode($response);
                exit;
            }
        }
    }
}

// If the password change failed or the request method is not POST, return an error response
$response = array('success' => false);
echo json_encode($response);

// Functions for email and password validation, checking email existence, and updating the password in the database
function validateEmail($email) {
    // Use PHP's built-in filter_var function with FILTER_VALIDATE_EMAIL to validate the email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function validatePassword($password) {
    // Password must be at least 8 characters long and contain at least one number and one special character
    if (strlen($password) >= 8 && preg_match('/[0-9]/', $password) && preg_match('/[^A-Za-z0-9]/', $password)) {
        return true;
    } else {
        return false;
    }
}

function checkEmailExists($conn, $email) {
    // Prepare and execute a query to check if the email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a row is found, the email exists
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function updatePassword($conn, $email, $password) {
    // Prepare and execute a query to update the password for the user
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $password, $email);
    $stmt->execute();

    // If the query was successful, return true
    if ($stmt->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}

// Close the database connection
$conn->close();
?>
