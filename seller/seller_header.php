<?php
// Start the session
session_start();

// Check if the seller is logged in
if (!isset($_SESSION['seller_id'])) {
    header("Location: ../login.html"); // Redirect to login if not logged in
    exit();
}

// Get the seller's name from the session
$seller_name = $_SESSION['seller_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="style.css"> <!-- Link your CSS file here -->
    <style>
        /* Styling for the header */
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
            <a href="seller_dashboard.php">Dashboard</a>
            <a href="add_dairy_product.php">Add Dairy Product</a>
            <a href="add_cattle_product.php">Add Cattle</a>
            <a href="manage_products.php">Manage Products</a>
            <a href="logout.php">Logout</a>
        </nav>
        <img src="../landingpage/images/logo.png" alt="Logo" class="logo">
    </header>
</body>
</html>
