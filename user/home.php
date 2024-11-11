<?php
// Start the session and include necessary files
session_start();
include('../db_connection.php');
include('user_header.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html"); // Redirect to login if not logged in
    exit();
}

// Get the user's name from the session, or set a default value if not set
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'User'; // Default to 'User' if name is not set

// Query to fetch all categories from the database
$sql = "SELECT id, name, image FROM categories ORDER BY product_type";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Cattle Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        h1, h2, h3 {
            margin: 0;
        }

        /* Hero Section */
        .hero {
            background-image: url('../landingpage/images/sheep_1.jpg');
            background-size: cover;
            background-position: center;
            text-align: center;
            padding: 120px 20px;
            color: #fff;
        }
        .hero h1 {
            font-size: 3.5em;
            margin-bottom: 15px;
        }
        .hero p {
            font-size: 1.3em;
            margin-bottom: 30px;
            max-width: 600px;
            margin: 0 auto;
        }
        .hero .hero-button {
            background-color: #0056b3;
            color: #fff;
            padding: 12px 30px;
            text-transform: uppercase;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .hero .hero-button:hover {
            background-color: #00408a;
        }

        /* Section Title */
        .section-title {
            font-size: 2.5em;
            text-align: center;
            margin: 50px 0 25px;
            color: #333;
        }
        
/* Features Section */
/* Features Section */
.features-section {
    align-self: center;
    margin-top: 50px;
    width: 100%;
    max-width: 1280px;
}

.features-container {
    display: flex;
    gap: 20px;
    justify-content:center; /* Distribute space evenly around the columns */
    flex-wrap: wrap;
}

.feature-column {
    width: 35%; /* Adjusts to take 40% of the container width */
    position: relative;
    overflow: hidden;
    aspect-ratio: 1 / 1; /* Set to 1:1 aspect ratio for square images */
    transition: transform 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-column:hover {
    transform: translateY(-5px); /* Add a hover effect */
}

.feature-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.6); /* Darken background for better text visibility */
    transition: filter 0.3s;
}

.feature-column:hover .feature-background {
    filter: brightness(0.8); /* Brighten on hover */
}

.feature-text {
    position: relative; /* Changed to relative for centered alignment */
    color: #fff;
    font-size: 1.8em;
    font-weight: bold;
    text-align: center;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%; /* Ensure it spans the full column height */
}

        /* Category Grid */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
        }
        .category-card {
            background-color: #fff;
            width: 220px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .category-card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }
        .category-card h3 {
            font-size: 1.2em;
            margin: 10px 0;
            color: #333;
        }
        .category-card:hover {
            transform: translateY(-5px);
        }

        /* About Us Section */
        .about-section {
            background-color: #f9f9f9;
            padding: 50px 20px;
            text-align: center;
            color: #333;
        }
        .about-section p {
            max-width: 800px;
            margin: 0 auto;
            font-size: 1.1em;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background-color: black;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome To Cattle Cart</h1>
        <p>Your trusted source for premium livestock and products, catering to every level of expertise.</p>
        <button class="hero-button">Explore Now</button>
    </div>
    <section class="features-section">
    <div class="features-container">
        <div class="feature-column">
            <div class="feature-item">
                <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/149fe2d4169214611d9f9be3301f028268fe5bbb7ddeaccb33bd95a9ade76ca6?placeholderIfAbsent=true&apiKey=a47a98ab7f604df0950bee1563369568" class="feature-background" alt="Explore Livestock background" />
                <p class="feature-text">Explore Livestock</p>
            </div>
        </div>
        <div class="feature-column">
            <div class="feature-item">
                <img loading="lazy" src="https://cdn.builder.io/api/v1/image/assets/TEMP/a4de9e70320dab17c348331384b933498142eca10518339cd5bb9bf9f3a6a195?placeholderIfAbsent=true&apiKey=a47a98ab7f604df0950bee1563369568" class="feature-background" alt="Explore Products background" />
                <p class="feature-text">Explore Products</p>
            </div>
        </div>
    </div>
</section>

    <!-- Shop by Categories Section -->
    <h2 class="section-title">Shop by Categories</h2>
    <div class="container">
        <?php
        // Display categories fetched from the database
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="category-card">';
                echo '<img src="../uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '</div>';
            }
        }
        ?>
    </div>
    <br>

    <!-- About Us Section -->
    <div class="about-section">
        <h2>About Us</h2>
        <p>At Cattle Cart, we are committed to connecting farmers, livestock owners, and enthusiasts with top-quality livestock and livestock products. Our platform ensures that every animal is ethically raised and carefully selected to meet the highest standards. Whether you’re looking to expand your farm or find quality livestock products, Cattle Cart is your trusted partner in sustainable agriculture.</p>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>© 2022 Cattle Cart. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

<?php
$conn->close(); // Close database connection
?>
