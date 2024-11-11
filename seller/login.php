<?php
// Start session
session_start();

// Include the database connection
include('../db_connection.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = "seller"; // Set role as 'seller' directly

    // Query to check if the seller exists in the sellers table
    $sql = "SELECT * FROM sellers WHERE email = ? AND role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $role);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the seller data
        $seller = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $seller['password'])) {
            // Set session variables
            $_SESSION['seller_id'] = $seller['seller_id']; // Store seller ID in session
            $_SESSION['seller_name'] = $seller['name']; // Store seller's name in session
            $_SESSION['role'] = $seller['role']; // Store seller's role in session

            // Redirect to seller dashboard
            header("Location: seller_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('Seller not found or invalid role.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
