<?php
header("Content-Type: application/json");
include('../db_connection.php');

// Get all categories
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);

    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    echo json_encode($categories);
}

// Create a new category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $imagePath = '../uploads/' . basename($_FILES['image']['name']);
    
    // Move uploaded file
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $sql = "INSERT INTO categories (name, image) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $name, $imagePath);
        
        if ($stmt->execute()) {
            echo json_encode(["message" => "Category created successfully"]);
        } else {
            echo json_encode(["error" => "Failed to create category"]);
        }
    } else {
        echo json_encode(["error" => "Failed to upload image"]);
    }
}

// Update a category
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT); // Get PUT data
    $id = $_PUT['id'];
    $name = $_PUT['name'];
    $imagePath = $imagePath = '../uploads/' . basename($_FILES['image']['name']);

    // Check if a new image is uploaded
    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $sql = "UPDATE categories SET name=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $imagePath, $id);
    } else {
        $sql = "UPDATE categories SET name=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $name, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["message" => "Category updated successfully"]);
    } else {
        echo json_encode(["error" => "Failed to update category"]);
    }
}

// Delete a category
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE); // Get DELETE data
    $id = $_DELETE['id'];
    $sql = "DELETE FROM categories WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Category deleted successfully"]);
    } else {
        echo json_encode(["error" => "Failed to delete category"]);
    }
}

$conn->close();
?>
