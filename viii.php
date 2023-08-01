<?php
require_once 'a.php';
// Get the form data
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $usernames = $_POST["usernames"];
  $review = $_POST["review"];
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Prepare and execute SQL statement to insert data into the database
  $sql = "INSERT INTO reviews (usernames, review) VALUES ('$usernames', '$review')";
  if ($conn->query($sql) === true) {
    // Data inserted successfully
    echo "Review submitted successfully!";
  } else {
    // Error inserting data
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  // Close the connection
  $conn->close();
}
?>
