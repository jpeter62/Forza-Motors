<?php
// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();

// Redirect to the index page if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: http://localhost/forzamotors/index.php");
    exit();
}

// Initialize variables to hold error messages and success message
$error = "";
$login_message = "";

// Database connection parameters
$servername = "localhost";
$username_db = "root";
$password_db = "";
$database = "forzamotors";

// Establish a database connection
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']); // Check if 'Remember me' is checked

    $stmt = $conn->prepare("SELECT * FROM users_data WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) { // Assuming the database column is 'password'
            // Store user data in session
            $userid= $row['userid'];
            $_SESSION['userid'] = $userid;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];

            // Set cookies if 'Remember me' is checked
            if ($remember_me) {
                setcookie("userid", $row['id'], time() + (86400 * 30), "/"); // 30 days expiration
                setcookie("username", $row['username'], time() + (86400 * 30), "/");
            }

            // Set an appropriate success message based on role and redirect to the respective page
            if ($row['role'] == 2) {
                $login_message = "User login successful.";
                header("Location: http://localhost/forzamotors/index.php"); // Redirect to home page
            } elseif ($row['role'] == 1) {
                $login_message = "Admin login successful.";
                header("Location: http://localhost/github/forzamotors/adminpanel.php"); // Redirect to admin panel
            }
            exit(); // Stop further execution after redirection
        } else {
            // Invalid password
            $error = "Invalid password";
        }
    } else {
        // User not found
        $error = "Invalid username";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">

    <title>Login Page</title>
</head>
<body>
    <div class="login">
        <img src="assets/img/login-bg.png" alt="login image" class="login__img">

        <form action="" method="POST" class="login__form">
            <h1 class="login__title">Login</h1>

            <?php
            if (!empty($error)) {
                echo "<p class='login__error'>$error</p>";
            }
            if (!empty($login_message)) {
                echo "<p class='login__message'>$login_message</p>";
            }
            ?>

            <div class="login__content">
                <div class="login__box">
                    <i class="ri-user-3-line login__icon"></i>
                    <div class="login__box-input">
                        <input type="text" required class="login__input" name="username" placeholder="Username">
                        <label for="login-email" class="login__label">Username</label>
                    </div>
                </div>

                <div class="login__box">
                    <i class="ri-lock-2-line login__icon"></i>
                    <div class="login__box-input">
                        <input type="password" required class="login__input" name="password" placeholder="Password">
                        <label for="login-pass" class="login__label">Password</label>
                        <i class="ri-eye-off-line login__eye" id="login-eye"></i>
                    </div>
                </div>
            </div>

            <div class="login__check">
                <div class="login__check-group">
                    <input type="checkbox" class="login__check-input" id="login-check" name="remember_me">
                    <label for="login-check" class="login__check-label">Remember me</label>
                </div>

                <a href="#" class="login__forgot">Forgot Password?</a>
            </div>

            <button type="submit" class="login__button">Login</button>

            <p class="login__register">
                Don't have an account? <a href="register.php">Register</a>
            </p>
        </form>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
