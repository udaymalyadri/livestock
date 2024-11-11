<?php
include('../db_connection.php');
include('admin_header.php');

// Fetch user details based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Update user details in the database
    $sql_update = "UPDATE users SET name=?, contact=?, email=?, role=? WHERE id=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssssi", $name, $contact, $email, $role, $id);

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully');</script>";
        header("Location: manage_users.php"); // Redirect to manage users page after updating
        exit();
    } else {
        echo "<script>alert('Error updating user');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> <!-- Include Poppins font -->
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Set font to Poppins */
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333; /* Consistent text color */
            margin-bottom: 20px;
        }

        .signup-container {
            max-width: 400px; /* Set max width for the form */
            margin: 50px auto; /* Center the form */
            padding: 20px;
            background-color: #fff; /* White background for form */
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px; /* Space between label and input */
        }

        input[type="text"], input[type="email"], select {
            padding: 10px; /* Padding for inputs */
            margin-bottom: 15px; /* Space between inputs */
            border: 1px solid #ccc; /* Border style */
            border-radius: 5px; /* Rounded corners */
        }

        input[type="submit"] {
            padding: 10px;
            background-color: black; /* Black background for submit button */
            color: white; /* White text for button */
            border: none; /* No border */
            border-radius: 5px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
        }

        input[type="submit"]:hover {
            background-color: #4cae4c; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="signup-container"> <!-- Use a container to center and style the form -->
        <h2>Edit User</h2>
        <form method="POST" action="edit_user.php">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $user['name']; ?>" required>

            <label>Contact:</label>
            <input type="text" name="contact" value="<?php echo $user['contact']; ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

            <label>Role:</label>
            <select name="role" required>
                <option value="admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="seller" <?php if($user['role'] == 'seller') echo 'selected'; ?>>Seller</option>
                <option value="buyer" <?php if($user['role'] == 'user') echo 'selected'; ?>>user</option>
                <option value="doctor" <?php if($user['role'] == 'doctor') echo 'selected'; ?>>Doctor</option>
            </select>

            <input type="submit" value="Update User">
        </form>
    </div>
</body>
</html>
