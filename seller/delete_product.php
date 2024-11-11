<?php
include('../db_connection.php');

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch seller ID from the session
$seller_id = $_SESSION['seller_id'];

// Fetch product ID from the URL query string
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if the product belongs to the seller
$sql = "SELECT * FROM products WHERE id = ? AND seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();
$product_result = $stmt->get_result();

// If product not found or doesn't belong to seller, redirect
if ($product_result->num_rows === 0) {
    echo "<script>alert('Product not found or you are not authorized to delete this product.');</script>";
    echo "<script>window.location.href = 'manage_products.php';</script>";
    exit;
}

// Proceed to delete the product
$delete_sql = "DELETE FROM products WHERE id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $product_id);

if ($delete_stmt->execute()) {
    echo "<script>alert('Product deleted successfully!');</script>";
} else {
    echo "<script>alert('Error deleting product: " . $delete_stmt->error . "');</script>";
}

echo "<script>window.location.href = 'manage_products.php';</script>";

$delete_stmt->close();
$stmt->close();
$conn->close();
?>
