<?php
session_start();

// Assume you have a function to check user credentials
if (check_user_credentials($_POST['username'], $_POST['password'])) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = get_user_id($_POST['username']); // Store user ID or any relevant info
    header("Location: booking.php"); // Redirect to booking page after login
    exit();
} else {
    echo "Invalid credentials.";
}
?>
