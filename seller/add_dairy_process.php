<?php
include('../db_connection.php');
include('seller_header.php');

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the seller ID is set in the session
// if (!isset($_SESSION['seller_id'])) {
//     echo "<script>alert('Error: You must be logged in as a seller to add a product.');</script>";
//     exit;
// }

// Fetch seller ID from the session
$seller_id = $_SESSION['seller_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if form data keys are set
    if (isset($_POST['product_name'], $_POST['product_type'], $_POST['category'], $_POST['price'], $_POST['stock'])) {
        // Collecting form data
        $product_name = $_POST['product_name'];
        $product_type = $_POST['product_type'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        // Handle image upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);

        // Check if the upload directory exists, if not create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            // Prepare SQL statement to insert into the database
            $sql = "INSERT INTO products (product_name, product_type, category, price, stock, seller_id, product_image) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssdiss", $product_name, $product_type, $category, $price, $stock, $seller_id, $target_file);

            // Execute the statement and check for success
            if ($stmt->execute()) {
                echo "<script>
                        alert('Product added successfully!');
                        window.location.href = 'add_dairy_product.php';
                      </script>";
                exit(); // Ensure no further code is executed after redirection
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
            
            
            $stmt->close();
        } else {
            echo "<script>alert('Error uploading the file.');</script>";
        }
    } else {
        echo "<script>alert('Please fill out all fields.');</script>";
    }
}

$conn->close();
?>
