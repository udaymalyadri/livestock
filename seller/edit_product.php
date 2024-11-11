<?php
include('../db_connection.php');
include('seller_header.php');

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch seller ID from the session
$seller_id = $_SESSION['seller_id'];

// Fetch product ID from the URL query string
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if the product belongs to the seller and fetch product details
$sql = "SELECT * FROM products WHERE id = ? AND seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $product_id, $seller_id);
$stmt->execute();
$product_result = $stmt->get_result();

// If product not found or doesn't belong to seller, redirect
if ($product_result->num_rows === 0) {
    echo "<script>alert('Product not found or you are not authorized to edit this product.');</script>";
    echo "<script>window.location.href = 'manage_products.php';</script>";
    exit;
}

$product = $product_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .form-container {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin: 15px 0 5px;
        }
        input[type="text"], input[type="number"], input[type="submit"], select, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Product</h2>
        
        <form action="edit_product_process.php" method="POST" enctype="multipart/form-data">
            <!-- Hidden fields for product ID and seller ID -->
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
            <input type="hidden" name="seller_id" value="<?php echo htmlspecialchars($seller_id); ?>">

            <!-- Product Name -->
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            </div>

            <!-- Product Type -->
            <div class="form-group">
                <label for="product_type">Product Type:</label>
                <select name="product_type" id="product_type" required>
                    <option value="Dairy" <?php if ($product['product_type'] === 'Dairy') echo 'selected'; ?>>Dairy</option>
                    <option value="Cattle" <?php if ($product['product_type'] === 'Cattle') echo 'selected'; ?>>Cattle</option>
                </select>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>

            <!-- Stock -->
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" name="stock" id="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
            </div>

            <!-- Upload Image (Optional) -->
            <div class="form-group">
                <label for="product_image">Upload New Image (Optional):</label>
                <input type="file" name="product_image" id="product_image" accept="image/*">
                <p>Current Image: <img src="<?php echo htmlspecialchars($product['product_image']); ?>" width="100" alt="Current Product Image"></p>
            </div>

            <input type="submit" value="Update Product">
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
