<?php
// Include the database connection
include('db_connection.php');

// Query to fetch all categories from the database
$sql = "SELECT id, name, image FROM categories";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Home Page</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <style>
        /* Basic styles for the category card layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 15px;
            text-align: center;
            transition: transform 0.3s;
        }

        .card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .card h2 {
            font-size: 1.5em;
            color: #333;
            margin: 10px 0;
        }

        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .card a:hover {
            background-color: #0056b3;
        }

        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; color: #333;">Our Categories</h1>
    <div class="container">

        <?php
        // Check if any categories are returned from the database
        if ($result->num_rows > 0) {
            // Loop through each category and display it in a card
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="category_images/' . htmlspecialchars($row['image']) . '" alt="Category Image">'; // Adjust image path as necessary
                echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
                echo '<a href="products.php?category_id=' . urlencode($row['id']) . '">View Products</a>';
                echo '</div>';
            }
        } else {
            echo "<p style='text-align: center;'>No categories available at the moment.</p>";
        }

        $conn->close(); // Close database connection
        ?>

    </div>
</body>
</html>
