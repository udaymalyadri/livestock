<?php
include('../db_connection.php');
include('seller_header.php');

// Check if the seller is logged in
if (!isset($_SESSION['seller_id'])) {
    echo "Error: You must be logged in as a seller to add a product.";
    exit;
}

// Fetch categories for Cattle
$sql = "SELECT * FROM categories WHERE product_type = 'Cattle'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cattle Product</title>
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
            margin-bottom: 30px;
            font-size: 24px;
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
        <h2>Add Cattle Product</h2>
        <form action="add_cattle_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_type" value="Cattle">
            <input type="hidden" name="seller_id" value="<?php echo $_SESSION['seller_id']; ?>">

            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" id="product_name" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" id="category" required>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['name']; ?>">
                            <?php echo $row['name']; ?>
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
                <label for="doctor_report">Doctor's Report (PDF):</label>
                <input type="file" name="doctor_report" id="doctor_report" accept=".pdf" required>
            </div>

            <div class="form-group">
                <label for="product_image">Upload Image:</label>
                <input type="file" name="product_image" id="product_image" accept="image/*" required>
            </div>

            <input type="submit" value="Add Cattle Product">
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
