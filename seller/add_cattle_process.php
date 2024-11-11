<?php
include('../db_connection.php');
include('seller_header.php');

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Check if the seller ID is set in the session
//     if (!isset($_SESSION['seller_id'])) {
//         echo "<script>alert('Error: You must be logged in as a seller to add a product.');</script>";
//         exit;
//     }

    // Fetch seller ID from the session
    $seller_id = $_SESSION['seller_id'];

    // Collecting form data
    $product_name = $_POST['product_name'];
    $product_type = $_POST['product_type'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Handle the doctor's report upload
    $doctor_report = $_FILES['doctor_report']['name'];
    $doctor_report_target = "uploads/" . basename($doctor_report);

    // Handle the product image upload
    $product_image = $_FILES['product_image']['name'];
    $product_image_target = "uploads/" . basename($product_image);

    // Check if the upload directory exists; if not, create it
    if (!is_dir("uploads/")) {
        mkdir("uploads/", 0755, true);
    }

    // Move the uploaded files
    $report_uploaded = move_uploaded_file($_FILES['doctor_report']['tmp_name'], $doctor_report_target);
    $image_uploaded = move_uploaded_file($_FILES['product_image']['tmp_name'], $product_image_target);

    if ($report_uploaded && $image_uploaded) {
        // Prepare SQL statement to insert into the database
        $sql = "INSERT INTO products (product_name, product_type, category, price, stock, seller_id, doctor_report, product_image) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisss", $product_name, $product_type, $category, $price, $stock, $seller_id, $doctor_report_target, $product_image_target);

        // Execute the statement and check for success
        if ($stmt->execute()) {
            echo "<script>
                    alert('Product added successfully!');
                    window.location.href = 'add_cattle_product.php';
                  </script>";
            exit(); // Ensure no further code is executed after redirection
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        

        $stmt->close();
    } else {
        echo "<script>alert('Error uploading files.');</script>";
    }

$conn->close();
?>
