<?php
// Start the session to retrieve the user ID
session_start();

// Assuming user ID is stored in session as 'user_id'
if (!isset($_SESSION['userid'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['userid'];

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'forzamotors');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bookings and car details for the logged-in user
$sql = "SELECT b.pickup_date, b.dropoff_date, b.total_price, c.name, c.image 
        FROM bookings b 
        JOIN cars c ON b.car_id = c.car_id 
        WHERE b.userid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .booking-card {
            display: flex;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }
        .booking-card img {
            max-width: 200px;
            margin-right: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .booking-details {
            flex: 1;
        }
        .booking-details h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }
        .booking-details p {
            margin: 5px 0;
            font-size: 16px;
            color: #555;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>My Bookings</h1>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="booking-card">
                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <div class="booking-details">
                    <h2><?php echo $row['name']; ?></h2>
                    <p><strong>Pickup Date:</strong> <?php echo $row['pickup_date']; ?></p>
                    <p><strong>Dropoff Date:</strong> <?php echo $row['dropoff_date']; ?></p>
                    <p><strong>Total Price:</strong> ₹<?php echo $row['total_price']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No bookings found.</p>
    <?php endif; ?>

    <?php
    $stmt->close();
    $conn->close();
    ?>
</div>

</body>
</html>
