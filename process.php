<?php
// Start session
session_start();

// Include database connection
include_once 'db.php';

// Check if user is not logged in, redirect to login page
include_once 'auth.php';
if (!isLoggedIn()) {
    redirectToLogin();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate product data
    $product = $_POST['product'];
    $quantity = intval($_POST['quantity']);

    if ($quantity <= 0) {
        // Invalid quantity
        $_SESSION['error'] = 'Quantity must be a positive integer.';
        header('Location: index.php');
        exit();
    }

    // Insert product into database (assuming there's a 'products' table)
    $query = "INSERT INTO products (name, quantity) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $product, $quantity);

    if ($stmt->execute()) {
        // Product added successfully
        $_SESSION['success'] = 'Product added to cart.';
        header('Location: index.php');
        exit();
    } else {
        // Error occurred while adding product
        $_SESSION['error'] = 'Failed to add product to cart. Please try again.';
        header('Location: index.php');
        exit();
    }
} else {
    // Redirect to index page if form is not submitted
    header('Location: index.php');
    exit();
}
