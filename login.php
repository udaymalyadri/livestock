<?php
// Start the session
session_start();

// Include the database connection
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists in the 'users' table
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Debugging: Output the role to the console
        echo "<script>console.log('User Role: " . $user['role'] . "');</script>";
        
        // Verify password (Assuming the password is stored as plain text in the DB)
        if ($password === $user['password']) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];  // Store the user ID in session
            $_SESSION['name'] = $user['name']; // Store seller's name in session

            $_SESSION['role'] = $user['role'];   // Store the role in session

            // Role-based redirection
            if ($user['role'] === 'admin') {
                header("Location: admin/dashboard.php");
            } elseif ($user['role'] === 'user') {
                header("Location: user/home.php");
            } else {
                // If the role is invalid, display an error message
                echo "<script>alert('Invalid role: " . $user['role'] . "');</script>";
            }
            exit(); // Stop further execution after redirection
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
