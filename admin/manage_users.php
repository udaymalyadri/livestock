<?php
include('../db_connection.php');
include('admin_header.php');

// Handle deletion of user or seller based on the `delete_id`
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $role = $_GET['role']; // Use this parameter to know if it's a user or seller

    if ($role === 'user') {
        $sql_delete = "DELETE FROM users WHERE id=?";
    } elseif ($role === 'seller') {
        $sql_delete = "DELETE FROM sellers WHERE seller_id=?";
    }

    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully');</script>";
        header("Location: manage_users.php"); // Redirect back after deletion
        exit();
    } else {
        echo "<script>alert('Error deleting record');</script>";
    }
}

// Fetch all users
$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);

// Fetch all sellers
$sql_sellers = "SELECT * FROM sellers";
$result_sellers = $conn->query($sql_sellers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users and Sellers</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #000;
            font-weight: 500;
            margin-bottom: 30px;
        }

        .manage-container {
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
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #000;
            color: white;
            font-weight: 500;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Button styles */
        .edit-btn, .delete-btn {
            padding: 8px 12px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
        }

        .edit-btn {
            background-color: #4cae4c;
        }

        .edit-btn:hover {
            background-color: #388e3c;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
<h2>Manage Users</h2>
    <div class="manage-container">
     
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>

            <!-- Display Users -->
            <?php while ($user = $result_users->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo isset($user['id']) ? htmlspecialchars($user['id']) : 'N/A'; ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['contact']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>User</td>
                    <td>
                        <a href="edit_user.php?id=<?php echo htmlspecialchars($user['id']); ?>" class="edit-btn">Edit</a>
                        <a href="?delete_id=<?php echo htmlspecialchars($user['id']); ?>&role=user" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Manage Sellers</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>

            <!-- Display Sellers -->
            <?php while ($seller = $result_sellers->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo isset($seller['seller_id']) ? htmlspecialchars($seller['seller_id']) : 'N/A'; ?></td>
                    <td><?php echo htmlspecialchars($seller['name']); ?></td>
                    <td><?php echo htmlspecialchars($seller['contact']); ?></td>
                    <td><?php echo htmlspecialchars($seller['email']); ?></td>
                    <td>Seller</td>
                    <td>
                        <a href="edit_seller.php?id=<?php echo htmlspecialchars($seller['seller_id']); ?>" class="edit-btn">Edit</a>
                        <a href="?delete_id=<?php echo htmlspecialchars($seller['seller_id']); ?>&role=seller" class="delete-btn" onclick="return confirm('Are you sure you want to delete this seller?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
