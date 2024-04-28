<?php
// Include database connection
include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];

    // Perform validation (e.g., check if fields are not empty)

    // Insert product into database
    $query = "INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sdi", $productName, $productPrice, $productQuantity);

    if ($stmt->execute()) {
        // Product added successfully
        header("Location: manage_products.php"); // Redirect back to manage products page
        exit();
    } else {
        // Error occurred while adding product
        echo "Error: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to manage products page if accessed directly
    header("Location: manage_products.php");
    exit();
}
