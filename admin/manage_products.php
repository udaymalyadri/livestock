<?php
include('../db_connection.php');
include('admin_header.php');

// Fetch all products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Handle deletion of a product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $sql_delete = "DELETE FROM products WHERE id=?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    echo "<script>alert('Product deleted successfully');</script>";
    header("Location: manage_products.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> <!-- Include Poppins font -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
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
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: black;
            color: white;
        }
        tr:nth-child(odd) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }

        button {
            background-color: #d9534f;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #c9302c;
        }
        .edit-button {
            background-color: #5bc0de;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .edit-button:hover {
            background-color: #31b0d5;
        }
    </style>
</head>
<body>
    <h2>Manage Products</h2>
    <div class="table-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Product Type</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Doctor's Report</th>
                <th>Actions</th>
            </tr>
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo $row['product_type']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['stock']; ?></td>
                        <td>
                            <?php if ($row['doctor_report']) { ?>
                                <a href="../uploads/<?php echo $row['doctor_report']; ?>" target="_blank">View Report</a>
                            <?php } else {
                                echo "N/A";
                            } ?>
                        </td>
                        <td>
                            <form method="POST" action="manage_products.php" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } 
            } else {
                echo "<tr><td colspan='8'>No products found.</td></tr>";
            } ?>
        </table>
    </div>
</body>
</html>
