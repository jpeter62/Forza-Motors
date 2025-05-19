<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forza motors";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $collection_point = $_POST['collection_point'];
    $pickup_date = $_POST['pickup_date'];
    $dropoff_date = $_POST['dropoff_date'];

    // Prepare and execute the SQL query to check car availability
    $sql = "SELECT c.name, c.image, c.transmission, c.year 
            FROM availability a
            JOIN cars c ON a.car_id = c.car_id
            WHERE a.location_id = ? 
              AND a.available_from <= ? 
              AND a.available_to >= ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }

    // Bind the parameters
    $stmt->bind_param("iss", $collection_point, $pickup_date, $dropoff_date);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if any cars are available
    if ($result->num_rows > 0) {
        echo "<h3>Available Cars:</h3>";
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "' style='width:150px; height:auto;'/><br>";
            echo "Name: " . $row['name'] . "<br>";
            echo "Transmission: " . $row['transmission'] . "<br>";
            echo "Year: " . $row['year'] . "<br>";
            echo "</div><br>";
        }
    } else {
        echo "<h3>No cars available</h3>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!-- HTML Form -->
<form method="post" action="">
    <label for="collection_point">Collection Point:</label>
    <select name="collection_point" id="collection_point" required>
        <option value="1">Kuttikanam</option>
        <option value="2">Peermade</option>
        <option value="3">Elappara</option>
    </select><br>

    <label for="pickup_date">Pick-up Date:</label>
    <input type="date" name="pickup_date" id="pickup_date" required><br>

    <label for="dropoff_date">Drop-off Date:</label>
    <input type="date" name="dropoff_date" id="dropoff_date" required><br>

    <button type="submit">Search</button>
</form>
