<?php
session_start(); // Start the session

// Check if the admin is logged in
// if (!isset($_SESSION['id'])) {
//     header("Location: ../login.html"); // Redirect to login if not logged in
//     exit();
// }

// Include the common database connection file
include('../db_connection.php');

// Fetch admin's name from the database using the session ID
$admin_id = $_SESSION['user_id']; // This should match the key set during login

$sql = "SELECT name FROM users WHERE id = ?"; // Ensure 'users' is the correct table for admins
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    $admin_name = $admin['name'];
} else {
    $admin_name = "Admin"; // Default name if not found
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Header</title>
    <style>
        /* Header styles */
        header {
            background-color: #ffffff; /* Set header color to white */
            padding: 25px;
            position: relative;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow for better visibility */
        }

        .header-container {
            text-align: center;
        }

        nav {
            margin-top: 10px;
        }

        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* Logo positioning */
        .logo {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px; /* Adjust the size of the logo as needed */
            height: auto;
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="manage_users.php">Manage Users</a>
                <a href="manage_products.php">Manage Products</a>
                <a href="manage_categories.php">Manage Categories</a>
                <a href="logout.php">Logout</a>
            </nav>
            <img src="../landingpage/images/logo.png" alt="Logo" class="logo"> <!-- Corrected image path -->
        </div>
    </header>
</body>
</html>

<?php
$stmt->close(); // Close the statement
?>
