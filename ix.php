<?php
// Establish database connection
require_once 'a.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $helpInput = $_POST["helpInput"];
    $email = $_POST["email"];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO help (help_input, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $helpInput, $email);
    $stmt->execute();

    // Close statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect back to home.html
    header("Location: home.html");
    exit();
}
?>


