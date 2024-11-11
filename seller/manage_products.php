<?php
include('../db_connection.php');
include('seller_header.php');

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fetch seller ID from the session
$seller_id = $_SESSION['seller_id'];

// Fetch products for the logged-in seller
$sql = "SELECT * FROM products WHERE seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $seller_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .manage-products-container {
            width: 90%;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #000;
            font-weight: 500;
            font-size: 24px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #000;
            color: white;
            font-weight: 500;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2; /* Light gray for even rows */
        }

        .actions a {
            display: inline-block;
            padding: 8px 12px;
            color: white;
            border-radius: 5px;
            margin-right: 5px;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .actions a.edit {
            background-color: #4cae4c;
        }

        .actions a.delete {
            background-color: #dc3545;
        }

        .actions a.edit:hover {
            background-color: #388e3c;
        }

        .actions a.delete:hover {
            background-color: #c9302c;
        }

        .product-image {
            width: 50px;
            height: auto;
            border-radius: 5px;
        }

        .view-report {
            color: #007bff;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s;
        }

        .view-report:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="manage-products-container">
        <h1>Manage Your Products</h1>
        
        <!-- Display the products in a table -->
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Doctor Report</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are products to display
                if ($result->num_rows > 0) {
                    while ($product = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($product['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['product_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['product_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['category']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['price']) . "</td>";
                        echo "<td>" . htmlspecialchars($product['stock']) . "</td>";
                        
                        // Display the doctor report link if available
                        if ($product['doctor_report']) {
                            echo "<td><a href='" . htmlspecialchars($product['doctor_report']) . "' target='_blank' class='view-report'>View Report</a></td>";
                        } else {
                            echo "<td>No Report</td>";
                        }
                        
                        // Display the product image
                        if ($product['product_image']) {
                            echo "<td><img src='" . htmlspecialchars($product['product_image']) . "' alt='Product Image' class='product-image'></td>";
                        } else {
                            echo "<td>No Image</td>";
                        }
                        
                        // Actions for Edit/Delete
                        echo "<td class='actions'>";
                        echo "<a href='edit_product.php?id=" . $product['id'] . "' class='edit'>Edit</a>";
                        echo "<a href='delete_product.php?id=" . $product['id'] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>";
                        echo "</td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No products found. Add some products.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
