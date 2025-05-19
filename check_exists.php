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

$type = $_POST['type'];
$value = $_POST['value'];

if ($type == "email") {
    $sql = "SELECT * FROM users_data WHERE email='$value'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "taken";
    } else {
        echo "available";
    }
} elseif ($type == "phone") {
    $sql = "SELECT * FROM users_data WHERE phoneno='$value'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "taken";
    } else {
        echo "available";
    }
} elseif ($type == "username") {
    $sql = "SELECT * FROM users_data WHERE username='$value'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "taken";
    } else {
        echo "available";
    }
}

$conn->close();
?>
