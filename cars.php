<?php
// Database connection settings
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

// Query to fetch car details
$sql = "SELECT car_id, name, image, transmission, year FROM cars";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forza Motors - Available Cars</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.cars-container {
    display: flex;
    flex-wrap: wrap; /* Allow items to wrap to the next line */
    justify-content: center; /* Center the items in the container */
    gap: 20px; /* Add space between the grid items */
    max-width: 1200px; /* Set a maximum width for the grid */
    padding: 20px;
}

.car-card {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 20px;
    width: 300px;
    text-align: center;
    flex: 1 1 calc(33.333% - 40px); /* Responsive sizing for 3 items per row */
    box-sizing: border-box; /* Ensure padding and borders don't affect width */
}

.car-card img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.book-button {
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.book-button:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
    <h1>Available Cars</h1>
    <div class="cars-container">
        <?php
        if ($result->num_rows > 0) {
            // Output data for each car
            while($row = $result->fetch_assoc()) {
                echo '<div class="car-card">';
                echo '<h2>' . htmlspecialchars($row["name"]) . '</h2>';
                echo '<img src="' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["name"]) . '">';
                echo '<p>Transmission: ' . htmlspecialchars($row["transmission"]) . '</p>';
                echo '<p>Year: ' . htmlspecialchars($row["year"]) . '</p>';
                echo '<a href="book.php?car_id=' . htmlspecialchars($row["car_id"]) . '" class="book-button">Book Now</a>';
                echo '</div>';
            }
        } else {
            echo "<p>No cars available.</p>";
        }
        ?>
    </div>
</body>

</html>
