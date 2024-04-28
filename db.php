<?php
// Database configuration
$dbHost = 'localhost'; // Change this if your MySQL server is hosted elsewhere
$dbUsername = 'root'; // Your MySQL username
$dbPassword = ''; // Your MySQL password
$dbName = 'protected'; // Your database name

// Establish database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

