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
    $issueInput = $_POST["issueInput"];
    $reportEmail = $_POST["reportEmail"];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO report (issue_input, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $issueInput, $reportEmail);
    $stmt->execute();

    // Close statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect back to home.html
    header("Location: home.html");
    exit();
}
?>
