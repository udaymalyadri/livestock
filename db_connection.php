<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Change as per your MySQL username
$password = ""; // Change as per your MySQL password
$dbname = "livestock"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
