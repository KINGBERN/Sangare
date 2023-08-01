<?php
require_once 'a.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && (isset($_POST['generatedCode']) || isset($_POST['surname']))) {
    // Handle the AJAX request to check if the email and generated code or surname exist and match
    // Retrieve the email, generated code, and surname from the request
    $email = $_POST['email'];
    $generatedCode = $_POST['generatedCode'] ?? '';
    $surname = $_POST['surname'] ?? '';

    // Perform the necessary validation and database check
    // Example: using MySQLi extension
    $mysqli = new mysqli($servername, $username, $password, $dbname);
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Check if the email and generated code or surname exist and match in the database
    $query = "SELECT COUNT(*) AS count FROM users WHERE email = ? AND (generatedcode = ? OR surname = ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sss", $email, $generatedCode, $surname);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];

    // Return the result as JSON
    $response = array("isValid" => $count > 0);
    echo json_encode($response);

    $stmt->close();
    $mysqli->close();
    exit; // Add this line to stop executing the remaining HTML code
}
?>