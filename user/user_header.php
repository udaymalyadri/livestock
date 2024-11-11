<?php
// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html"); // Redirect to login if not logged in
    exit();
}

// Get the user's name from the session, or set a default value if not set
// Removed the welcome name usage
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet"> <!-- Use Poppins font -->
    <style>
        /* Styling for the body */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

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
            text-align:center;
        
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
        <nav>
            <a href="home.php">Home</a>
            <a href="view_products.php">View Products</a>
            <a href="order_history.php">Order History</a>
            <a href="cart.php">Cart</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
        <img src="../landingpage/images/logo.png" alt="Logo" class="logo">
    </header>
</body>
</html>
