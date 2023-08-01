<?php
require_once 'a.php';

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstname = $_POST["firstname"];
    $othernames = $_POST["othernames"];
    $email = $_POST["email"];
    $country_code = $_POST["country_code"];
    $phone = $_POST["phone"];
    $pickup_date = $_POST["pickup-date"];
    $pickup_time = $_POST["pickup-time"];
    $pickup_location = $_POST["pickup-location"];
    
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO kiko (firstname, othernames, email, country_code, phone, pickup_date, pickup_time, pickup_location) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $firstname, $othernames, $email, $country_code, $phone, $pickup_date, $pickup_time, $pickup_location);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Data stored successfully
        $stmt->close();
        $conn->close();
        header("Location: thankyou.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();
?>
