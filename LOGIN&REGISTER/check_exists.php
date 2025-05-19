<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "forzamotors";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$type = $_POST['type'];
$value = $_POST['value'];

if ($type == "email") {
    $sql = "SELECT * FROM users_data WHERE email = ?";
} else if ($type == "phone") {
    $sql = "SELECT * FROM users_data WHERE phoneno = ?";
} else if ($type == "username") {
    $sql = "SELECT * FROM users_data WHERE username = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $value);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "taken";
} else {
    echo "available";
}

$stmt->close();
$conn->close();
?>
