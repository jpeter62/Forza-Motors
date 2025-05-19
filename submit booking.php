<?php
// Retrieve form data
$car_id = $_POST['car_id'];
$collection_point_name = $_POST['collection_point'];
$return_point_name = $_POST['return_point'];
$pickup_date = $_POST['pickup_date'];
$dropoff_date = $_POST['dropoff_date'];
$customer_name = $_POST['customer_name'];
$customer_email = $_POST['customer_email'];
$customer_phone = $_POST['customer_phone'];

// Set return point as default collection point for future bookings
session_start();
$_SESSION['default_collection_point'] = $return_point_name;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forzamotors";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the loc_id for collection_point and return_point
$collection_point_id = null;
$return_point_id = null;

$sql = "SELECT loc_id FROM locations WHERE name = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing query: " . $conn->error);
}

// Fetch collection_point loc_id
$stmt->bind_param("s", $collection_point_name);
$stmt->execute();
$stmt->bind_result($collection_point_id);
$stmt->fetch();

// Reset statement and fetch return_point loc_id
$stmt->reset();
$stmt->bind_param("s", $return_point_name);
$stmt->execute();
$stmt->bind_result($return_point_id);
$stmt->fetch();

$stmt->close();

if ($collection_point_id === null || $return_point_id === null) {
    die("Error: Invalid collection or return point.");
}

// Fetch car details (name and image) from the database
$sql = "SELECT name, image FROM cars WHERE car_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing query: " . $conn->error);
}
$stmt->bind_param("i", $car_id);
$stmt->execute();
$stmt->bind_result($car_name, $car_image);
$stmt->fetch();
$stmt->close();

// Insert booking into the bookings table using loc_ids
$sql = "INSERT INTO bookings (car_id, location_id, pickup_date, dropoff_date, customer_name, customer_contact, customer_email) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing query: " . $conn->error);
}
$stmt->bind_param("iisssss", $car_id, $collection_point_id, $pickup_date, $dropoff_date, $customer_name, $customer_phone, $customer_email);
$stmt->execute();
$stmt->close();

// Update the availability status to 'booked'
$sql = "UPDATE availability 
        SET status = 'booked'
        WHERE car_id = ? 
          AND location_id = ? 
          AND available_from <= ? 
          AND available_to >= ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing query: " . $conn->error);
}
$stmt->bind_param("iiss", $car_id, $collection_point_id, $pickup_date, $dropoff_date);
$stmt->execute();
$stmt->close();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        .success-box {
            margin: 50px auto;
            padding: 20px;
            border: 2px solid green;
            border-radius: 10px;
            background-color: #f0fff0;
            text-align: center;
            max-width: 500px;
            font-family: Arial, sans-serif;
        }
        .success-box h2 {
            color: green;
        }
        .car-image {
            width: 100%;
            max-width: 300px;
            height: auto;
            margin: 20px auto;
        }
        .car-name {
            font-weight: bold;
            font-size: 1.2em;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <h2>Booking Successful!</h2>
        <img src="<?php echo htmlspecialchars($car_image); ?>" alt="Car Image" class="car-image">
        <p class="car-name"><?php echo htmlspecialchars($car_name); ?></p>
        <p>Thank you, <?php echo htmlspecialchars($customer_name); ?>, for booking with us.</p>
        <p>Collection Point: <?php echo htmlspecialchars($collection_point_name); ?></p>
        <p>Return Point: <?php echo htmlspecialchars($return_point_name); ?></p>
        <p>Pick-up Date: <?php echo htmlspecialchars($pickup_date); ?></p>
        <p>Drop-off Date: <?php echo htmlspecialchars($dropoff_date); ?></p>
    </div>
</body>
</html>
