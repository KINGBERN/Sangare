<?php
require_once 'a.php';

// Create a connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize user input
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize the input
    $email = sanitize($_POST["email"]);
    $surname = sanitize($_POST["surname"]);

    // Check if the email and surname exist in the database
    $query = "SELECT generatedcode FROM users WHERE email = '$email' AND surname = '$surname'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        // Retrieve the code from the database
        $row = mysqli_fetch_assoc($result);
        $generatedcode = $row["generatedcode"];
        echo $generatedcode;
    } else {
        // Email and surname combination not found
        echo "not_found";
    }
} else {
    // Invalid request method
    echo "invalid_request";
}

// Close the connection
mysqli_close($connection);
?>
