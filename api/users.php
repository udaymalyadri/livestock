<?php
header("Content-Type: application/json");
include('../db_connection.php');

// Get all users
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $users = array();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
}

// Create a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    
    $sql = "INSERT INTO users (name, contact, email, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $contact, $email, $role);

    if ($stmt->execute()) {
        echo json_encode(["message" => "User created successfully"]);
    } else {
        echo json_encode(["error" => "Failed to create user"]);
    }
}

// Update a user
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT); // Get PUT data
    $id = $_PUT['id'];
    $name = $_PUT['name'];
    $contact = $_PUT['contact'];
    $email = $_PUT['email'];
    $role = $_PUT['role'];

    $sql = "UPDATE users SET name=?, contact=?, email=?, role=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $contact, $email, $role, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "User updated successfully"]);
    } else {
        echo json_encode(["error" => "Failed to update user"]);
    }
}

// Delete a user
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE); // Get DELETE data
    $id = $_DELETE['id'];
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "User deleted successfully"]);
    } else {
        echo json_encode(["error" => "Failed to delete user"]);
    }
}

$conn->close();
?>
