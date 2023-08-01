<?php
require_once 'a.php';
// Establishing connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);
// Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $firstname = $_POST["firstname"];
    $othernames = $_POST["othernames"];
    $email = $_POST["email"];
    $countryCode = $_POST["country_code"];
    $phone = $_POST["phone"];
    $home = $_POST["home"];
    $town = $_POST["town"];
    $county = $_POST["county"];
    $country = $_POST["country"];
    // Store form data in the database
    $sql = "INSERT INTO polo (firstname, othernames, email, country_code, phone, home, town, county, country)
            VALUES ('$firstname', '$othernames', '$email', '$countryCode', '$phone', '$home', '$town', '$county', '$country')";

    if ($conn->query($sql) === TRUE) {
        echo "Continue";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Close the database connection
$conn->close();
?>
