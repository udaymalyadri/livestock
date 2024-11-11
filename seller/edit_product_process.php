<?php
include('../db_connection.php');

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $product_id = intval($_POST['product_id']);
    $seller_id = intval($_POST['seller_id']);
    $product_name = $_POST['product_name'];
    $product_type = $_POST['product_type'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Handle image upload if provided
    $product_image = '';
    if (!empty($_FILES['product_image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
        
        // Check if the upload directory exists, if not create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $product_image = $target_file; // Use the new image path
        } else {
            echo "<script>alert('Error uploading the file.');</script>";
            echo "<script>window.location.href = 'edit_product.php?id=$product_id';</script>";
            exit;
        }
    }

    // Prepare SQL statement to update the product details
    if ($product_image) {
        $sql = "UPDATE products SET product_name = ?, product_type = ?, category = ?, price = ?, stock = ?, product_image = ? WHERE id = ? AND seller_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdissi", $product_name, $product_type, $category, $price, $stock, $product_image, $product_id, $seller_id);
    } else {
        // If no new image, exclude it from the update
        $sql = "UPDATE products SET product_name = ?, product_type = ?, category = ?, price = ?, stock = ? WHERE id = ? AND seller_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdiss", $product_name, $product_type, $category, $price, $stock, $product_id, $seller_id);
    }

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully!');</script>";
        echo "<script>window.location.href = 'manage_products.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
        echo "<script>window.location.href = 'edit_product.php?id=$product_id';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
