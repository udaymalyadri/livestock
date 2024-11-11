<?php
include('../db_connection.php');
include('admin_header.php');

// Fetch category details based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM categories WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
}

// Handle form submission for updating category details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $product_type = $_POST['product_type']; // New product type
    $imagePath = $category['image']; // Default to the existing image path

    // Handle new image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = $_FILES['image']['name'];
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imagePath = '../uploads/' . basename($imageName); // Path to save the uploaded image

        // Move uploaded file to the desired location
        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            echo "<script>alert('Error uploading image');</script>";
        }
    }

    // Update category details in the database
    $sql_update = "UPDATE categories SET name=?, product_type=?, image=? WHERE id=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssi", $name, $product_type, $imagePath, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Category updated successfully');</script>";
        header("Location: manage_categories.php"); // Redirect back after updating
        exit();
    } else {
        echo "<script>alert('Error updating category');</script>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Set font to Poppins */
            background-color: #f4f4f4; /* Light grey background */
            margin: 0;
            padding: 00px; /* Added padding for body */
            color: #000; /* Black text */
        }
        header {
            background-color: white; /* Black header */
            color: white; /* White text */
            padding: 25px;
            text-align: center;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .form-container {
            width: 300px; /* Set a fixed width for the form container */
            margin: auto; /* Center the container */
            padding: 20px;
            background-color: #fff; /* White background for the form */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            margin-bottom: 5px;
            display: block;
            color: #000; /* Black label text */
        }
        input[type="text"], input[type="file"], select {
            width: 100%;
            padding: 10px; /* Padding for input fields */
            margin-bottom: 15px; /* Space below each input */
            border: 1px solid #ccc; /* Grey border */
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: black; /* Black submit button */
            color: white; /* White text */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%; /* Full width for the button */
        }
        input[type="submit"]:hover {
            background-color: #333; /* Darker grey on hover */
        }
    </style>
</head>
<body>
        <h2>Edit Category</h2>
    <div class="form-container">
        <form method="POST" action="edit_category.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
            <label>Category Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>

            <label>Select Product Type:</label>
            <select name="product_type" required>
                <option value="Dairy Product" <?php echo $category['product_type'] === 'Dairy Product' ? 'selected' : ''; ?>>Dairy Product</option>
                <option value="Cattle" <?php echo $category['product_type'] === 'Cattle' ? 'selected' : ''; ?>>Cattle</option>
                <!-- Add more product types here as needed -->
            </select>

            <label>Upload New Image (optional):</label>
            <input type="file" name="image" accept="image/*">

            <input type="submit" value="Update Category">
        </form>
    </div>
</body>
</html>
