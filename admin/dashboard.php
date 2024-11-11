<?php
// Include the common header, which includes the database connection
include('admin_header.php');

// Ensure the database connection is active before proceeding
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch the count of users, categories, and products
$user_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$category_count = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];
$product_count = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count']; // Fetch product count

// Fetch admin's name from the database using the session ID
$admin_id = $_SESSION['user_id']; // This should match the key set during login
$sql = "SELECT name FROM users WHERE id = ?";
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="path_to_css/admin_dashboard.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Include Font Awesome -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> <!-- Include Poppins font -->
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Set font to Poppins */
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 10px auto;
            padding: 10px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 30px; /* Space between welcome message and dashboard cards */
            font-size: 24px;
            color: white; /* Set text color to white for contrast */
            background-image: url('../landingpage/images/BANNER2.jpg'); /* Background image */
            background-size: cover; /* Cover the entire area */
            background-position: center; /* Center the background image */
            padding: 100px; /* Add some padding */
        }

        .dashboard-cards {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 20px;
            margin: 20px;
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card h2 {
            font-size: 2em;
            margin: 10px 0;
            color: #2c3e50;
        }

        .card p {
            font-size: 1.2em;
            color: #7f8c8d;
        }

        .card a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #000; /* Change background color to black */
            color: white; /* Change text color to white */
            text-decoration: none;
            border-radius: 5px;
        }

        .card a:hover {
            background-color: #333; /* Slightly lighter black on hover */
        }

        .icon {
            font-size: 3em; /* Adjust icon size */
            margin-bottom: 10px; /* Space between icon and text */
            color: black; /* Change icon color to black */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-message">
            <h2>Welcome, <?php echo htmlspecialchars($admin_name); ?>!</h2>
        </div>
        <h1>Admin Dashboard</h1>
        <div class="dashboard-cards">

            <!-- Users Card -->
            <div class="card">
                <i class="fas fa-users icon"></i> <!-- Users icon -->
                <h2><?php echo $user_count; ?></h2>
                <p>Total Users</p>
                <a href="manage_users.php">Manage Users</a>
            </div>

            <!-- Categories Card -->
            <div class="card">
                <i class="fas fa-tags icon"></i> <!-- Categories icon -->
                <h2><?php echo $category_count; ?></h2>
                <p>Total Categories</p>
                <a href="manage_categories.php">Manage Categories</a>
            </div>

            <!-- Products Card -->
            <div class="card">
                <i class="fas fa-box icon"></i> <!-- Products icon -->
                <h2><?php echo $product_count; ?></h2>
                <p>Total Products</p>
                <a href="manage_products.php">Manage Products</a>
            </div>

        </div>
    </div>
</body>
</html>

<?php
$stmt->close(); // Close the statement
$conn->close(); // Close the database connection at the end of the file
?>
