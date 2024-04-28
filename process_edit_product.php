<?php
// Include database connection
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
    // Retrieve form data
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];

    // Perform validation (e.g., check if fields are not empty)

    // Update product in database
    $query = "UPDATE products SET name=?, price=?, quantity=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdi", $productName, $productPrice, $productQuantity, $productId);

    if ($stmt->execute()) {
        // Product updated successfully
        header("Location: manage_products.php"); // Redirect back to manage products page
        exit();
    } else {
        // Error occurred while updating product
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
