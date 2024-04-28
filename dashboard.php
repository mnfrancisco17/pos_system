<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
include_once 'auth.php';
if (!isLoggedIn()) {
    redirectToLogin();
}

// Include database connection
include_once 'db.php';

// Fetch user information
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="row">
        <div class="col">
            <h2 class="mt-5">Dashboard</h2>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Welcome, <?php echo $user['username']; ?>!</h5>
                    <p class="card-text">You are logged in to the POS System.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>