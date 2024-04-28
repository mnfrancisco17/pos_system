<?php
// Include database connection
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
    // Retrieve product ID from form data
    $productId = $_POST['productId'];

    // Delete product from database
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);

    if ($stmt->execute()) {
        // Product deleted successfully
        header("Location: manage_products.php"); // Redirect back to manage products page
        exit();
    } else {
        // Error occurred while deleting product
        echo "Error: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to manage products page if accessed directly or productId is not set
    header("Location: manage_products.php");
    exit();
}
