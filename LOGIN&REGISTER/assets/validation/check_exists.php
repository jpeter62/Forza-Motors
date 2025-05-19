<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "forza motors";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM users_data WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Email already taken";
    } else {
        echo "Email available";
    }
}

if (isset($_POST['phone'])) {
    $phone = $_POST['phone'];
    $sql = "SELECT * FROM users_data WHERE phoneno='$phone'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Phone number already taken";
    } else {
        echo "Phone number available";
    }
}

$conn->close();
?>
