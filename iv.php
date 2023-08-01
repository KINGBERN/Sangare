<?php
require_once 'a.php';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $cartItems = $_POST["cart_items"];
    $total = $_POST["total"];
    // Prepare and execute the SQL query
    $sql = "INSERT INTO item (cart_items, total) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $cartItems, $total);
    if ($stmt->execute()) {
        echo "Continue";
    } else {
        echo "Error: " . $stmt->error;
    }
}
$conn->close();
?>