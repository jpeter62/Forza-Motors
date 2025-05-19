<?php
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

// Get search criteria from the form submission
$collection_point = $_GET['collection_point'];
$return_point = $_GET['return_point'];
$pickup_date = $_GET['pickup_date'];
$dropoff_date = $_GET['dropoff_date'];

// Fetch cars based on search criteria
$sql = "SELECT * FROM cars WHERE collection_point='$collection_point' AND return_point='$return_point'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo '<div class="car-item">';
        echo '<img src="images/' . $row["image"] . '" alt="' . $row["car_name"] . '">';
        echo '<div class="car-info">';
        echo '<h3>' . $row["car_name"] . '</h3>';
        echo '<p>Transmission: ' . $row["transmission"] . '</p>';
        echo '<p>Year: ' . $row["year"] . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No cars available for the selected criteria.";
}

$conn->close();
?>
