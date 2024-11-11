<?php
include('../db_connection.php');
include('admin_header.php');

// Handle form submission for adding a new category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $product_type = $_POST['product_type'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target = "../uploads/" . basename($image);
        
        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Insert into the categories table with product_type
            $sql_insert = "INSERT INTO categories (name, product_type, image) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("sss", $name, $product_type, $image);
            
            if ($stmt->execute()) {
                echo "<script>alert('Category added successfully');</script>";
                header("Location: manage_categories.php");
                exit();
            } else {
                echo "<script>alert('Error adding category');</script>";
            }
        } else {
            echo "<script>alert('Error uploading image');</script>";
        }
    } else {
        echo "<script>alert('No image uploaded');</script>";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Set font to Poppins */
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .form-container {
            width: 300px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            margin-bottom: 5px;
            display: block;
        }
        input[type="text"], input[type="file"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Category</h2>
        <form method="POST" action="add_category.php" enctype="multipart/form-data">
            <label>Category Name:</label>
            <input type="text" name="name" required>

            <label>Select Product Type:</label>
            <select name="product_type" required>
                <option value="Dairy Product">Dairy Product</option>
                <option value="Cattle">Cattle</option>
            </select>

            <label>Upload Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <input type="submit" value="Add Category">
        </form>
    </div>
</body>
</html>
