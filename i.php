<?php
require_once 'a.php';
// Connect to the database
$con = mysqli_connect($servername, $username, $password, $dbname);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
// Check if the login form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Fetch the user's information from the database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    // Check if the user exists and if the password is correct
    if ($row && password_verify($password, $row['password'])) {
        // The user's information is valid, send success response
        header('Content-Type: application/json');
        echo json_encode(array('result' => 'success'));
    } else {
        // The user's information is invalid, send error response
        echo json_encode(array('result' => 'error'));
    }
}
// Close the database connection
mysqli_close($con);
?>

