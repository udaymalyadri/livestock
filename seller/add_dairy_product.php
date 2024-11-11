<?php
include('../db_connection.php');
include('seller_header.php');

// Fetch the seller ID from the session
$seller_id = $_SESSION['seller_id'];

// Fetch seller details from the sellers table
$seller_sql = "SELECT * FROM sellers WHERE seller_id = ?";
$stmt = $conn->prepare($seller_sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$seller_result = $stmt->get_result();
$seller = $seller_result->fetch_assoc();

// Fetch categories for Dairy Products
$sql = "SELECT * FROM categories WHERE product_type = 'Dairy Product'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Dairy Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 50%;
            margin: 50px auto;
            padding: 30px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #000;
            font-size: 24px;
            margin-bottom: 30px;
        }

        label {
            font-size: 15px;
            font-weight: 500;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            font-weight: 500;
        }

        input[type="submit"]:hover {
            background-color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Dairy Product</h2>
        <form action="add_dairy_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_type" value="Dairy Product">
            <input type="hidden" name="seller_id" value="<?php echo htmlspecialchars($seller_id); ?>"> <!-- Hidden field for seller_id -->
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" id="product_name" required>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" id="category" required>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo htmlspecialchars($row['name']); ?>">
                            <?php echo htmlspecialchars($row['name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" name="stock" id="stock" required>
            </div>
            <div class="form-group">
                <label for="product_image">Upload Image:</label>
                <input type="file" name="product_image" id="product_image" accept="image/*" required>
            </div>
            <input type="submit" value="Add Dairy Product">
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
