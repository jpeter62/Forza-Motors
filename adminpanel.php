<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "forzamotors"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions only if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Add Car
    if (isset($_POST['add_car'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $image = $conn->real_escape_string($_POST['image']);
        $transmission = $conn->real_escape_string($_POST['transmission']);
        $year = $conn->real_escape_string($_POST['year']);

        $sql = "INSERT INTO cars (name, image, transmission, year) VALUES ('$name', '$image', '$transmission', '$year')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>New car added successfully</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // Handle Update Car
    elseif (isset($_POST['update_car'])) {
        $car_id = $conn->real_escape_string($_POST['car_id']);
        $name = $conn->real_escape_string($_POST['name']);
        $image = $conn->real_escape_string($_POST['image']);
        $transmission = $conn->real_escape_string($_POST['transmission']);
        $year = $conn->real_escape_string($_POST['year']);

        $sql = "UPDATE cars SET name='$name', image='$image', transmission='$transmission', year='$year' WHERE car_id='$car_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Car updated successfully</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // Handle Delete Car
    elseif (isset($_POST['delete_car'])) {
        $car_id = $conn->real_escape_string($_POST['car_id']);

        $sql = "DELETE FROM cars WHERE car_id='$car_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Car deleted successfully</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // Handle Add Booking
    elseif (isset($_POST['add_booking'])) {
        $car_id = $conn->real_escape_string($_POST['car_id']);
        $location_id = $conn->real_escape_string($_POST['location_id']);
        $pickup_date = $conn->real_escape_string($_POST['pickup_date']);
        $dropoff_date = $conn->real_escape_string($_POST['dropoff_date']);
        $customer_name = $conn->real_escape_string($_POST['customer_name']);
        $customer_contact = $conn->real_escape_string($_POST['customer_contact']);
        $customer_email = $conn->real_escape_string($_POST['customer_email']);

        $sql = "INSERT INTO bookings (car_id, location_id, pickup_date, dropoff_date, customer_name, customer_contact, customer_email) 
                VALUES ('$car_id', '$location_id', '$pickup_date', '$dropoff_date', '$customer_name', '$customer_contact', '$customer_email')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>New booking added successfully</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // Handle Update Booking
    elseif (isset($_POST['update_booking'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $car_id = $conn->real_escape_string($_POST['car_id']);
        $location_id = $conn->real_escape_string($_POST['location_id']);
        $pickup_date = $conn->real_escape_string($_POST['pickup_date']);
        $dropoff_date = $conn->real_escape_string($_POST['dropoff_date']);
        $customer_name = $conn->real_escape_string($_POST['customer_name']);
        $customer_contact = $conn->real_escape_string($_POST['customer_contact']);
        $customer_email = $conn->real_escape_string($_POST['customer_email']);

        $sql = "UPDATE bookings SET car_id='$car_id', location_id='$location_id', pickup_date='$pickup_date', dropoff_date='$dropoff_date', customer_name='$customer_name', customer_contact='$customer_contact', customer_email='$customer_email' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Booking updated successfully</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // Handle Delete Booking
    elseif (isset($_POST['delete_booking'])) {
        $id = $conn->real_escape_string($_POST['id']);

        $sql = "DELETE FROM bookings WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Booking deleted successfully</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // Handle Add Availability
    elseif (isset($_POST['add_availability'])) {
        $car_id = $conn->real_escape_string($_POST['car_id']);
        $location_id = $conn->real_escape_string($_POST['location_id']);
        $available_from = $conn->real_escape_string($_POST['available_from']);
        $available_to = $conn->real_escape_string($_POST['available_to']);
        $status = $conn->real_escape_string($_POST['status']);

        $sql = "INSERT INTO availability (car_id, location_id, available_from, available_to, status) 
                VALUES ('$car_id', '$location_id', '$available_from', '$available_to', '$status')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>New availability record added successfully</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // Handle Update Availability
    elseif (isset($_POST['update_availability'])) {
        $id = $conn->real_escape_string($_POST['id']);
        $car_id = $conn->real_escape_string($_POST['car_id']);
        $location_id = $conn->real_escape_string($_POST['location_id']);
        $available_from = $conn->real_escape_string($_POST['available_from']);
        $available_to = $conn->real_escape_string($_POST['available_to']);
        $status = $conn->real_escape_string($_POST['status']);

        $sql = "UPDATE availability SET car_id='$car_id', location_id='$location_id', available_from='$available_from', available_to='$available_to', status='$status' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Availability record updated successfully</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // Handle Delete Availability
    elseif (isset($_POST['delete_availability'])) {
        $id = $conn->real_escape_string($_POST['id']);

        $sql = "DELETE FROM availability WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Availability record deleted successfully</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }
}

// Fetch data
$cars_sql = "SELECT * FROM cars";
$cars_result = $conn->query($cars_sql);

$bookings_sql = "SELECT * FROM bookings";
$bookings_result = $conn->query($bookings_sql);

$availability_sql = "SELECT * FROM availability";
$availability_result = $conn->query($availability_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #000; /* Fallback color */
            color: #fff; /* White text color */
            background-image: url('../images/FORZA MOTORS-3.png'); /* Background image URL */
            background-repeat: no-repeat; /* Prevent repeating the image */
            background-size: auto; /* Adjust size to fit image dimensions */
            background-position: top center; /* Position image at the top center */
            background-attachment: fixed; /* Ensure the background image does not scroll with the content */
        }

        h1, h2 {
            color: #fff; /* White color for headings */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #333; /* Dark grey background for tables */
            color: #fff; /* White text color for table data */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #444; /* Darker border color */
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50; /* Green background for table headers */
            color: white;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .form-container {
            margin-bottom: 20px;
        }

        .form-container form {
            background-color: #222; /* Darker grey background for forms */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container input[type="text"], .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #555; /* Darker background for inputs */
            color: #fff; /* White text color for inputs */
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50; /* Green background for submit button */
            border: none;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: flex-end;
        }

        ul li {
            margin-left: 20px;
        }

        ul li a {
            color: #fff; /* White text color for links */
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            transition: background-color 0.3s, color 0.3s;
        }

        ul li a:hover,
        ul li a:focus {
            background-color: #4CAF50; /* Green background on hover/focus */
            color: #fff; /* White text color on hover/focus */
        }
    </style>
</head>
<body>
    <!-- Navigation Menu -->
    <nav class="navbar">
        <div class="container">
            <ul>
                <li><a href="http://localhost/github/carvilla-v1.0/index.php">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="ctact.html">Contact</a></li>
                <li><a href="http://localhost/github/carvilla-v1.0/LOGIN&REGISTER/index.php">Register/Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Forza Motors</h1>

        <!-- Add Car Form -->
        <div class="form-container">
            <h2>Add New Car</h2>
            <form method="post" action="">
                <input type="text" name="name" placeholder="Car Name" required>
                <input type="text" name="image" placeholder="Image URL" required>
                <input type="text" name="transmission" placeholder="Transmission Type" required>
                <input type="text" name="year" placeholder="Year" required>
                <input type="submit" name="add_car" value="Add Car">
            </form>
        </div>

        <!-- Update Car Form -->
        <div class="form-container">
            <h2>Update Car</h2>
            <form method="post" action="">
                <input type="text" name="car_id" placeholder="Car ID" required>
                <input type="text" name="name" placeholder="Car Name">
                <input type="text" name="image" placeholder="Image URL">
                <input type="text" name="transmission" placeholder="Transmission Type">
                <input type="text" name="year" placeholder="Year">
                <input type="submit" name="update_car" value="Update Car">
            </form>
        </div>

        <!-- Delete Car Form -->
        <div class="form-container">
            <h2>Delete Car</h2>
            <form method="post" action="">
                <input type="text" name="car_id" placeholder="Car ID" required>
                <input type="submit" name="delete_car" value="Delete Car">
            </form>
        </div>

        <!-- Add Booking Form -->
        <div class="form-container">
            <h2>Add New Booking</h2>
            <form method="post" action="">
                <input type="text" name="car_id" placeholder="Car ID" required>
                <input type="text" name="location_id" placeholder="Location ID" required>
                <input type="text" name="pickup_date" placeholder="Pickup Date (YYYY-MM-DD)" required>
                <input type="text" name="dropoff_date" placeholder="Dropoff Date (YYYY-MM-DD)" required>
                <input type="text" name="customer_name" placeholder="Customer Name" required>
                <input type="text" name="customer_contact" placeholder="Customer Contact" required>
                <input type="text" name="customer_email" placeholder="Customer Email" required>
                <input type="submit" name="add_booking" value="Add Booking">
            </form>
        </div>

        <!-- Update Booking Form -->
        <div class="form-container">
            <h2>Update Booking</h2>
            <form method="post" action="">
                <input type="text" name="id" placeholder="Booking ID" required>
                <input type="text" name="car_id" placeholder="Car ID">
                <input type="text" name="location_id" placeholder="Location ID">
                <input type="text" name="pickup_date" placeholder="Pickup Date (YYYY-MM-DD)">
                <input type="text" name="dropoff_date" placeholder="Dropoff Date (YYYY-MM-DD)">
                <input type="text" name="customer_name" placeholder="Customer Name">
                <input type="text" name="customer_contact" placeholder="Customer Contact">
                <input type="text" name="customer_email" placeholder="Customer Email">
                <input type="submit" name="update_booking" value="Update Booking">
            </form>
        </div>

        <!-- Delete Booking Form -->
        <div class="form-container">
            <h2>Delete Booking</h2>
            <form method="post" action="">
                <input type="text" name="id" placeholder="Booking ID" required>
                <input type="submit" name="delete_booking" value="Delete Booking">
            </form>
        </div>

        <!-- Add Availability Form -->
        <div class="form-container">
            <h2>Add New Availability</h2>
            <form method="post" action="">
                <input type="text" name="car_id" placeholder="Car ID" required>
                <input type="text" name="location_id" placeholder="Location ID" required>
                <input type="text" name="available_from" placeholder="Available From (YYYY-MM-DD)" required>
                <input type="text" name="available_to" placeholder="Available To (YYYY-MM-DD)" required>
                <input type="text" name="status" placeholder="Status" required>
                <input type="submit" name="add_availability" value="Add Availability">
            </form>
        </div>

        <!-- Update Availability Form -->
        <div class="form-container">
            <h2>Update Availability</h2>
            <form method="post" action="">
                <input type="text" name="id" placeholder="Availability ID" required>
                <input type="text" name="car_id" placeholder="Car ID">
                <input type="text" name="location_id" placeholder="Location ID">
                <input type="text" name="available_from" placeholder="Available From (YYYY-MM-DD)">
                <input type="text" name="available_to" placeholder="Available To (YYYY-MM-DD)">
                <input type="text" name="status" placeholder="Status">
                <input type="submit" name="update_availability" value="Update Availability">
            </form>
        </div>

        <!-- Delete Availability Form -->
        <div class="form-container">
            <h2>Delete Availability</h2>
            <form method="post" action="">
                <input type="text" name="id" placeholder="Availability ID" required>
                <input type="submit" name="delete_availability" value="Delete Availability">
            </form>
        </div>

        <!-- Display Cars -->
        <h2>Cars</h2>
        <table>
            <tr>
                <th>Car ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Transmission</th>
                <th>Year</th>
            </tr>
            <?php
            if ($cars_result->num_rows > 0) {
                while($row = $cars_result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['car_id']}</td>
                            <td>{$row['name']}</td>
                            <td><img src='{$row['image']}' alt='{$row['name']}'></td>
                            <td>{$row['transmission']}</td>
                            <td>{$row['year']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No cars found</td></tr>";
            }
            ?>
        </table>

        <!-- Display Bookings -->
        <h2>Bookings</h2>
        <table>
            <tr>
                <th>Booking ID</th>
                <th>Car ID</th>
                <th>Location ID</th>
                <th>Pickup Date</th>
                <th>Dropoff Date</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Customer Email</th>
            </tr>
            <?php
            if ($bookings_result->num_rows > 0) {
                while($row = $bookings_result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['car_id']}</td>
                            <td>{$row['location_id']}</td>
                            <td>{$row['pickup_date']}</td>
                            <td>{$row['dropoff_date']}</td>
                            <td>{$row['customer_name']}</td>
                            <td>{$row['customer_contact']}</td>
                            <td>{$row['customer_email']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No bookings found</td></tr>";
            }
            ?>
        </table>

        <!-- Display Availability -->
        <h2>Availability</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Car ID</th>
                <th>Location ID</th>
                <th>Available From</th>
                <th>Available To</th>
                <th>Status</th>
            </tr>
            <?php
            if ($availability_result->num_rows > 0) {
                while($row = $availability_result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['car_id']}</td>
                            <td>{$row['location_id']}</td>
                            <td>{$row['available_from']}</td>
                            <td>{$row['available_to']}</td>
                            <td>{$row['status']}</td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No availability records found</td></tr>";
            }
            ?>
        </table>
    </div>

    <?php
    // Handle form submissions for bookings and availability
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Add new booking
        if (isset($_POST['add_booking'])) {
            $car_id = $conn->real_escape_string($_POST['car_id']);
            $location_id = $conn->real_escape_string($_POST['location_id']);
            $pickup_date = $conn->real_escape_string($_POST['pickup_date']);
            $dropoff_date = $conn->real_escape_string($_POST['dropoff_date']);
            $customer_name = $conn->real_escape_string($_POST['customer_name']);
            $customer_contact = $conn->real_escape_string($_POST['customer_contact']);
            $customer_email = $conn->real_escape_string($_POST['customer_email']);

            $sql = "INSERT INTO bookings (car_id, location_id, pickup_date, dropoff_date, customer_name, customer_contact, customer_email)
                    VALUES ('$car_id', '$location_id', '$pickup_date', '$dropoff_date', '$customer_name', '$customer_contact', '$customer_email')";
            if ($conn->query($sql) === TRUE) {
                echo "<p>New booking added successfully</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        // Update booking
        elseif (isset($_POST['update_booking'])) {
            $id = $conn->real_escape_string($_POST['id']);
            $car_id = $conn->real_escape_string($_POST['car_id']);
            $location_id = $conn->real_escape_string($_POST['location_id']);
            $pickup_date = $conn->real_escape_string($_POST['pickup_date']);
            $dropoff_date = $conn->real_escape_string($_POST['dropoff_date']);
            $customer_name = $conn->real_escape_string($_POST['customer_name']);
            $customer_contact = $conn->real_escape_string($_POST['customer_contact']);
            $customer_email = $conn->real_escape_string($_POST['customer_email']);

            $sql = "UPDATE bookings SET car_id='$car_id', location_id='$location_id', pickup_date='$pickup_date', dropoff_date='$dropoff_date', customer_name='$customer_name', customer_contact='$customer_contact', customer_email='$customer_email'
                    WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Booking updated successfully</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        // Delete booking
        elseif (isset($_POST['delete_booking'])) {
            $id = $conn->real_escape_string($_POST['id']);

            $sql = "DELETE FROM bookings WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Booking deleted successfully</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        // Add new availability
        elseif (isset($_POST['add_availability'])) {
            $car_id = $conn->real_escape_string($_POST['car_id']);
            $location_id = $conn->real_escape_string($_POST['location_id']);
            $available_from = $conn->real_escape_string($_POST['available_from']);
            $available_to = $conn->real_escape_string($_POST['available_to']);
            $status = $conn->real_escape_string($_POST['status']);

            $sql = "INSERT INTO availability (car_id, location_id, available_from, available_to, status)
                    VALUES ('$car_id', '$location_id', '$available_from', '$available_to', '$status')";
            if ($conn->query($sql) === TRUE) {
                echo "<p>New availability added successfully</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        // Update availability
        elseif (isset($_POST['update_availability'])) {
            $id = $conn->real_escape_string($_POST['id']);
            $car_id = $conn->real_escape_string($_POST['car_id']);
            $location_id = $conn->real_escape_string($_POST['location_id']);
            $available_from = $conn->real_escape_string($_POST['available_from']);
            $available_to = $conn->real_escape_string($_POST['available_to']);
            $status = $conn->real_escape_string($_POST['status']);

            $sql = "UPDATE availability SET car_id='$car_id', location_id='$location_id', available_from='$available_from', available_to='$available_to', status='$status'
                    WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Availability updated successfully</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }

        // Delete availability
        elseif (isset($_POST['delete_availability'])) {
            $id = $conn->real_escape_string($_POST['id']);

            $sql = "DELETE FROM availability WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "<p>Availability deleted successfully</p>";
            } else {
                echo "<p>Error: " . $conn->error . "</p>";
            }
        }
    }

    // Close connection
    $conn->close();
    ?>
</body>
</html>