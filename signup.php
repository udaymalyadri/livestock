<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Change as per your MySQL username
$password = ""; // Change as per your MySQL password
$dbname = "livestock"; // Database name

// Start the session
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Secure password hashing
    $role = $_POST['role']; // Get the role from the form

    // Insert into database
    $sql = "INSERT INTO users (name, contact, email, password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $contact, $email, $password, $role);

    if ($stmt->execute()) {
        // Get the last inserted ID
        $user_id = $stmt->insert_id;

        // Set session variable
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $user_name; // Store name in session


        // Display success alert message and redirect to the login page
        echo "<script>
                alert('User signup successful! You will be redirected to the login page.');
                window.location.href = 'login.html';
              </script>";
        exit(); // Ensure that no further code is executed after redirection
    } else {
        // Display error message if signup fails
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
