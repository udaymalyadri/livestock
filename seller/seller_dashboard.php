<?php
session_start(); // Start session

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
    <link rel="stylesheet" href="../css/style.css"> <!-- Link to main CSS if needed -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Basic styling */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #ffffff;
            padding: 25px;
            position: relative;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logo {
            position: absolute;
            left: 20px;
            top: 10px;
            width: 100px;
            height: auto;
        }

        main {
            padding: 40px 20px;
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #000;
            margin-bottom: 30px;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border: 2px solid #000;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 30px 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 15px;
            color: #666;
            margin-bottom: 20px;
        }

        .card a {
            color: #000;
            font-weight: bold;
            text-decoration: none;
            font-size: 15px;
        }

        .card a:hover {
            color: #4cae4c;
        }

        .icon {
            font-size: 35px;
            color: #000;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<header>
    <img src="../landingpage/images/logo.png" alt="Logo" class="logo">
    <nav>
        <a href="seller_dashboard.php">Dashboard</a>
        <a href="add_dairy_product.php">Add Dairy Product</a>
        <a href="add_cattle_product.php">Add Cattle</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main>
    <h2>Welcome, <?php echo htmlspecialchars($seller_name); ?>!</h2>
    <div class="dashboard-container">
        <div class="card">
            <i class="fas fa-box icon"></i>
            <h2>Manage Products</h2>
            <p>View and edit your existing products.</p>
            <a href="manage_products.php" class="btn btn-dark">Go to Manage Products</a>
        </div>

        <div class="card">
            <i class="fas fa-cheese icon"></i>
            <h2>Add Dairy Product</h2>
            <p>Add new dairy products to your inventory.</p>
            <a href="add_dairy_product.php" class="btn btn-dark">Go to Add Dairy Product</a>
        </div>

        <div class="card">
            <i class="fas fa-home icon"></i>
            <h2>Add Cattle Product</h2>
            <p>Add new cattle listings to your inventory.</p>
            <a href="add_cattle_product.php" class="btn btn-dark">Go to Add Cattle Product</a>
        </div>

        <div class="card">
            <i class="fas fa-chart-line icon"></i>
            <h2>View Sales</h2>
            <p>Check your sales performance and analytics.</p>
            <a href="sales_overview.php" class="btn btn-dark">Go to Sales Overview</a>
        </div>
    </div>
</main>

</body>
</html>
