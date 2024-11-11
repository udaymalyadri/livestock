<?php
include('../db_connection.php');
include('admin_header.php');

// Fetch all categories from the database
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM categories WHERE id=?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    echo "<script>alert('Category deleted successfully');</script>";
    header("Location: manage_categories.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> <!-- Include Poppins font -->
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Set font to Poppins */
            background-color: #f4f4f4;
            margin: 0;
            padding: 0; /* Added padding for body */
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .table-container {
            width: 90%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
            margin-top: 20px;
        }
    
        th, td {
            padding: 8px; /* Reduced padding for columns */
            text-align: center;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color:black; /* Keep the header color consistent */
            color: white;
        }
        tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        
        button {
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px; /* Rounded corners */
            width: 100px; /* Fixed width for uniform button size */
        }
        .delete-button {
            background-color: #d9534f; /* Red color for delete button */
        }
        .delete-button:hover {
            background-color: #c9302c; /* Darker shade on hover */
        }
        .edit-button {
            background-color: black; /* Green color for Add Category button */
            color: white;
            text-decoration: none; /* Remove underline from the link */
            display: inline-block; /* Make it behave like a button */
            padding: 1px 20px; /* Add padding to the button */
            border-radius: 5px; /* Rounded corners */
        }
        .edit-button:hover {
            background-color: #333; /* Darker shade on hover */
        }
        .add-category-button {
            background-color: #5cb85c; /* Green color for Add Category button */
            color: white;
            text-decoration: none; /* Remove underline from the link */
            display: inline-block; /* Make it behave like a button */
            padding: 10px 20px; /* Add padding to the button */
        }
        .add-category-button:hover {
            background-color: #4cae4f; /* Darker green on hover */
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover; /* Maintain aspect ratio */
            border-radius: 5px; /* Optional: rounded image corners */
        }
        .action-buttons {
            justify-content: space-evenly; /* Space out buttons evenly */
            width: 30%; /* Ensure full width */
        }
    </style>
</head>
<body>
    <h2>Manage Categories</h2>
    <div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Product Type</th> <!-- New column for Product Type -->
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['product_type']); ?></td> <!-- Displaying Product Type -->
                    <td><img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>"></td>
                    <td class="action-buttons">
                        <a href="edit_category.php?id=<?php echo $row['id']; ?>" class="edit-button">Edit</a>
                        <form method="POST" action="manage_categories.php" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } 
        } else {
            echo "<tr><td colspan='5'>No categories found.</td></tr>";
        } ?>
    </table>
    </div>

    <br>
    <div style="text-align: center;">
        <a href="add_category.php" class="add-category-button">Add Category</a>
    </div>
    <br>
    <br>
</body>
</html>
