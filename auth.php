<?php
// Only start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include_once 'db.php';

// Function to authenticate user
function authenticateUser($username, $password)
{
    global $conn;

    // Sanitize input
    $username = mysqli_real_escape_string($conn, $username);

    // Query to fetch user details
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct
            return $user;
        }
    }

    // Username or password is incorrect
    return false;
}

// Function to prevent brute force attacks
function preventBruteForce($username)
{
    // Maximum login attempts before account deletion
    $maxAttempts = 15;
    // Base delay duration in seconds (e.g., 10 seconds)
    $baseDelayDuration = 10;
    // Delay increase on every 5 attempts (e.g., 10 seconds)
    $delayIncrease = 10;

    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    // Increase login attempts
    $_SESSION['login_attempts']++;

    // Calculate delay duration
    $delayDuration = $baseDelayDuration + floor(($_SESSION['login_attempts'] - 1) / 5) * $delayIncrease;

    // Check if maximum attempts reached
    if ($_SESSION['login_attempts'] >= $maxAttempts) {
        // Delete account
        $success = deleteAccount($username);

        if ($success) {
            // Redirect to a page indicating account deletion
            header('Location: account_deleted.php');
            exit();
        } else {
            // Redirect to an error page indicating deletion failure
            header('Location: deletion_failed.php');
            exit();
        }
    }

    // Display alert message if one attempt left
    if ($_SESSION['login_attempts'] == $maxAttempts - 1) {
        echo '<script>alert("You have one more attempt left before your account is deleted.");</script>';
    }
    // Display alert message for attempts left
    elseif ($_SESSION['login_attempts'] < $maxAttempts - 1) {
        $attemptsLeft = $maxAttempts - $_SESSION['login_attempts'];
        echo "<script>alert('You have {$attemptsLeft} attempts left before your account is deleted.');</script>";
    }

    // Apply delay after 5 attempts
    if ($_SESSION['login_attempts'] >= 5) {
        // Add a delay before allowing further login attempts
        sleep($delayDuration);
    }

    // Reset login attempts if the account is not deleted
    if ($_SESSION['login_attempts'] >= $maxAttempts) {
        $_SESSION['login_attempts'] = 0;
    }
}

// Function to delete account
function deleteAccount($username)
{
    global $conn;

    // Sanitize input
    $username = mysqli_real_escape_string($conn, $username);

    // Validate input
    if (empty($username)) {
        return false; // Invalid input
    }

    // Execute SQL query to delete the account
    $query = "DELETE FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);

    if ($stmt->execute()) {
        // Account deleted successfully
        return true;
    } else {
        // Error occurred while deleting account
        return false;
    }
}

// Function to redirect to login page if user is not authenticated
function redirectToLogin()
{
    header('Location: login.php');
    exit();
}

// Check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Logout user
function logout()
{
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header('Location: login.php');
    exit();
}
