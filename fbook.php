<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/forzamotors/LOGIN&REGISTER/index.php");
    exit();
}

// Retrieve the final total price from the form submission
$final_total = isset($_POST['final_total']) ? htmlspecialchars($_POST['final_total']) : 0;

// Retrieve variables from the URL
$car_id = isset($_GET['car_id']) ? htmlspecialchars($_GET['car_id']) : '';
$collection_point = isset($_GET['collection_point']) ? htmlspecialchars($_GET['collection_point']) : '';
$return_point = isset($_GET['return_point']) ? htmlspecialchars($_GET['return_point']) : '';
$pickup_date = isset($_GET['pickup_date']) ? htmlspecialchars($_GET['pickup_date']) : '';
$dropoff_date = isset($_GET['dropoff_date']) ? htmlspecialchars($_GET['dropoff_date']) : '';

// Connect to the database
$connection = new mysqli("localhost", "root", "", "forzamotors");
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Retrieve car details based on car_id
$car = null;
if ($car_id) {
    $car_query = "SELECT name, image FROM cars WHERE car_id = ?";
    $stmt = $connection->prepare($car_query);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $car_result = $stmt->get_result();

    if ($car_result->num_rows > 0) {
        $car = $car_result->fetch_assoc();
    } else {
        echo "Car not found.";
    }
}

// Check if user ID is set in the session
$userid = null;
$user = null;
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
    $user_query = "SELECT firstname, lastname, email, phoneno FROM users_data WHERE userid = ?";
    $stmt = $connection->prepare($user_query);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User data not found.";
    }
} else {
    echo "User ID not found in session.";
}

// Initialize error message variable
$error_message = "";

// Retrieve loc_id from 'locations' table based on the collection_point name
$location_id = null;
if ($collection_point) {
    $location_query = "SELECT loc_id FROM locations WHERE name = ?";
    $stmt = $connection->prepare($location_query);
    $stmt->bind_param("s", $collection_point);
    $stmt->execute();
    $location_result = $stmt->get_result();

    if ($location_result->num_rows > 0) {
        $location_row = $location_result->fetch_assoc();
        $location_id = $location_row['loc_id'];
    } else {
        echo "Collection point not found in locations.";
    }
}

// Retrieve loc_id for return_point
$return_location_id = null;
if ($return_point) {
    $return_query = "SELECT loc_id FROM locations WHERE name = ?";
    $stmt = $connection->prepare($return_query);
    $stmt->bind_param("s", $return_point);
    $stmt->execute();
    $return_result = $stmt->get_result();

    if ($return_result->num_rows > 0) {
        $return_row = $return_result->fetch_assoc();
        $return_location_id = $return_row['loc_id'];
    } else {
        echo "Return point not found in locations.";
    }
}

// Check Card Expiry (cexp) from 'bank' table during form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_number = trim($_POST['cno'] ?? '');
    $card_expiry = trim($_POST['cexp'] ?? '');
    $cvv = trim($_POST['cvv'] ?? '');

    // Check if any fields are empty
    if (empty($card_number) || empty($card_expiry) || empty($cvv)) {
        $error_message = "Please fill in all required fields.";
    } else {
        // Verify the card details from the 'bank' table
        $bank_query = "SELECT bbal FROM bank WHERE cno = ? AND cexp = ? AND cvv = ?";
        $stmt = $connection->prepare($bank_query);
        $stmt->bind_param("sss", $card_number, $card_expiry, $cvv);
        $stmt->execute();
        $bank_result = $stmt->get_result();

        if ($bank_result->num_rows > 0) {
            // Existing logic for balance check and deduction
            $row = $bank_result->fetch_assoc();
            $balance = $row['bbal'];

            if ($balance >= $final_total) {
                // Deduct balance and confirm booking
                $new_balance = $balance - $final_total;
                $update_query = "UPDATE bank SET bbal = ? WHERE cno = ?";
                $update_stmt = $connection->prepare($update_query);
                $update_stmt->bind_param("is", $new_balance, $card_number);
                if (!$update_stmt->execute()) {
                    $error_message = "Error updating balance: " . $update_stmt->error;
                }

                // Begin transaction
                $connection->begin_transaction();
                try {
                    // Prepare user details for insertion into bookings
                    $customer_name = $user['firstname'] . " " . $user['lastname'];
                    $customer_contact = $user['phoneno'];
                    $customer_email = $user['email'];

                    // Add booking details to the booking table
                    $booking_query = "INSERT INTO bookings (userid, car_id, pickup_date, dropoff_date, location_id, total_price, customer_name, customer_contact, customer_email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $booking_stmt = $connection->prepare($booking_query);
                    $booking_stmt->bind_param("issssisss", $userid, $car_id, $pickup_date, $dropoff_date, $location_id, $final_total, $customer_name, $customer_contact, $customer_email);
                    if (!$booking_stmt->execute()) {
                        throw new Exception("Error inserting booking: " . $booking_stmt->error);
                    }

                    // Update availability table
                    $availability_query = "UPDATE availability SET status = 'booked', available_from = ?, available_to = ?, location_id = ? WHERE car_id = ?";
                    $availability_stmt = $connection->prepare($availability_query);
                    $availability_stmt->bind_param("ssii", $pickup_date, $dropoff_date, $return_location_id, $car_id);
                    if (!$availability_stmt->execute()) {
                        throw new Exception("Error updating availability: " . $availability_stmt->error);
                    }

                    // Commit transaction
                    $connection->commit();
                    echo "<script>alert('Booking confirmed! New balance: ₹" . $new_balance . "');</script>";
                } catch (Exception $e) {
                    $connection->rollback();
                    echo "<script>alert('Transaction failed: " . $e->getMessage() . "');</script>";
                }
            } else {
                echo "<script>alert('Insufficient balance.');</script>";
            }
        } else {
            echo "<script>alert('Invalid card details. Please check your card number, expiry date, or CVV.');</script>";
        }
    }
}

// Display error message if there is one
if (!empty($error_message)) {
    echo $error_message;
}

// Close the database connection
$connection->close();
?>



<!DOCTYPE html>
<html lang="en">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forza Motors - Available Cars</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet">
    <link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/linearicons.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/bootsnav.css">
    <link rel="stylesheet" href="assets/css/s.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <title>Forza Motors - Available Cars</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .navbar {
            background-color: black !important; /* Set the background color to black */
        }

        .navbar-nav > li > a {
            color: white !important; /* Set the text color to white */
        }

        .navbar-nav > li > a:hover {
            color: #ddd !important; /* Set a lighter color on hover for better visibility */
        }

        .navbar-brand {
            color: white!important; /* Set the brand text color to white */
        }

        .header-area {
            margin-bottom: 20px; /* Add space below the navigation bar */
        }

        .ccontainer {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: auto;
            padding: 90px;
        }

        .booking-form {
            flex: 1;
            margin-right: 20px;
    
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .vehicle-info {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .vehicle-title {
            font-size: 1.5em;
            margin: 0 0 10px;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-control {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        .btn {
            padding: 10px 20px;
            background-color: #000000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1em;
            margin-top: 10px;
            padding: 10px;
            display: inline-block;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body id="about-page">
    <!-- Navigation and other content here -->
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->
    <!--welcome-hero start -->
    <section id="home">
        <!-- top-area Start -->
        <div class="top-area">
            <div class="header-area">
                <!-- Start Navigation -->
                <nav class="navbar navbar-default bootsnav navbar-sticky navbar-scrollspy" data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">
                    <div class="container">
                        <!-- Start Header Navigation -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                                <i class="fa fa-bars"></i>
                            </button>
                            <a class="navbar-brand" href="index.html">FORZA MOTORS<span></span></a>
                        </div><!--/.navbar-header-->
                        <!-- End Header Navigation -->
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
                            <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                                <li><a href="http://localhost/forzamotors/index.php">Home</a></li>
                                <li class=""><a href="aboutf.html">about us</a></li>
				                <li class=""><a href="contact.html">contact</a></li>
                                <li><a href="http://localhost/forzamotors/LOGIN&REGISTER/index.php">Register/Login</a></li>
                            </ul><!--/.nav -->
                        </div><!-- /.navbar-collapse -->
                    </div><!--/.container-->
                </nav><!--/nav-->
                <!-- End Navigation -->
            </div><!--/.header-area-->
            <div class="clearfix"></div>
        </div><!-- /.top-area-->
      </section>
    </div> 
    <!-- Navigation End -->

    <div class="ccontainer">
        <div class="vehicle-info">
            <h2 class="vehicle-title"><?php echo $car ? $car['name'] : 'Car not found'; ?></h2>
            <?php if ($car) : ?>
                <img src="<?php echo $car['image']; ?>" alt="<?php echo $car['name']; ?>" style="width: 100%; height: auto;">
            <?php endif; ?>
            <div class="vehicle-info">
            
            <p>Pickup Location: <?php echo htmlspecialchars($collection_point); ?></p>
            <p>Return Location: <?php echo htmlspecialchars($return_point); ?></p>
            <p>Pickup Date: <?php echo htmlspecialchars($pickup_date); ?></p>
            <p>Dropoff Date: <?php echo htmlspecialchars($dropoff_date); ?></p>
            <p>Total Price: ₹<?php echo htmlspecialchars($final_total); ?></p>
        </div>
        </div>
        <div class="booking-form">
            <h2>Booking Form</h2>
            <form action="" method="POST">
            <h2>Driver Information</h2>
                <div class="form-group">
                    <label for="driverFirstName">First Name:</label>
                    <input type="text" id="driverFirstName" name="driverFirstName" class="form-control" value="<?php echo htmlspecialchars($user['firstname'] ?? ''); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="driverLastName">Last Name:</label>
                    <input type="text" id="driverLastName" name="driverLastName" class="form-control" value="<?php echo htmlspecialchars($user['lastname'] ?? ''); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="driverEmail">Email:</label>
                    <input type="email" id="driverEmail" name="driverEmail" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="driverPhoneNumber">Phone Number:</label>
                    <input type="tel" id="driverPhoneNumber" name="driverPhoneNumber" class="form-control" value="<?php echo htmlspecialchars($user['phoneno'] ?? ''); ?>" readonly>
                </div>
                <h2>Payment Information</h2>
                 <div class="form-group">
                    <label for="cno">Card Number:</label>
                    <input type="text" class="form-control" name="cno" required>
                </div>
               <div class="form-group">
    <label for="cexp">Expiry Date:</label>
    <input type="text" class="form-control" id="cexp" name="cexp" required placeholder="MM/YY" maxlength="5">
</div>

<script>
document.getElementById('cexp').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, ''); // Remove any non-digit characters
    if (value.length >= 3) {
        // Format as MM/YY if input has at least 3 characters
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
});

document.querySelector('form').addEventListener('submit', function (e) {
    const expiryInput = document.getElementById('cexp');
    expiryInput.value = expiryInput.value.replace('/', ''); // Remove '/' before submitting
});
</script>

                <div class="form-group">
                    <label for="cvv">CVV:</label>
                    <input type="text" class="form-control" name="cvv" required>
                </div>
                <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                <button type="submit" class="btn">Confirm Booking</button>
                <button type="button" class="btn" onclick="window.location.href='http://localhost/forzamotors/index.php';">Cancel</button>

            </form>
        </div>
        <div id="bookingModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Booking Successful!</h2>
        <p>Your booking details:</p>
        <p>Car: <?php echo $car ? htmlspecialchars($car['name']) : 'Car not found'; ?></p>
        <p>Pickup Location: <?php echo htmlspecialchars($collection_point); ?></p>
        <p>Return Location: <?php echo htmlspecialchars($return_point); ?></p>
        <p>Pickup Date: <?php echo htmlspecialchars($pickup_date); ?></p>
        <p>Dropoff Date: <?php echo htmlspecialchars($dropoff_date); ?></p>
        <p>Total Price: ₹<?php echo htmlspecialchars($final_total); ?></p>
        <p>New Balance: ₹<?php echo isset($new_balance) ? htmlspecialchars($new_balance) : 'N/A'; ?></p>
    </div>
</div>

<script>
    function showModal() {
        document.getElementById('bookingModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('bookingModal').style.display = 'none';
        // Redirect to home page
        window.location.href = 'http://localhost/forzamotors/index.php';
    }

    // Show modal if booking is successful
    <?php if (isset($new_balance)): ?>
        showModal();
    <?php endif; ?>
</script>


    </div>
    <footer id="contact"  class="a-contact">
			<div class="container">
				<div class="footer-top">
					<div class="row">
						<div class="col-md-3 col-sm-6">
							<div class="single-footer-widget">
								<div class="afooter-logo">
									<center>
									<a href="index.html">FORZA MOTORS</a>
								</div>
								<p>
								</p>
								<div class="afooter-contact">
									<p>support@forzamotors.com</p>
									<p>+91 7802130000</p>
									<p>M/s Forza Motors Passenger Cars India (P) Ltd
										Address: TC 79/1783-1, Idukki ,Venpalavattom, Anayara PO, Kuttikanam, Kerala - 685515</p>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-6">
							<div class="asingle-footer-widget">
								<h2>about forzamotors</h2>
								<ul>
									<li><a href="#">about us</a></li>
									<li><a href="#">career</a></li>
									<li><a href="#">terms <span> of service</span></a></li>
									<li><a href="#">privacy policy</a></li>
								</ul>
							</center>
							</div>
						</div>
					</div><div class="afooter-copyright">
						<div class="row">
							<div class="col-sm-6">
								<p>
									&copy; copyright.designed and developed by <a href="https://www.themesine.com/">forzamotors</a>.
								</p><!--/p-->
							</div>
							<div class="col-sm-6">
								<div class="afooter-social">
									<a href="#"><i class="fa fa-facebook"></i></a>	
									<a href="#"><i class="fa fa-instagram"></i></a>
									<a href="#"><i class="fa fa-linkedin"></i></a>
									<a href="#"><i class="fa fa-pinterest-p"></i></a>
									<a href="#"><i class="fa fa-behance"></i></a>	
								</div>
							</div>
						</div>
					</div><!--/.footer-copyright-->
				</div><!--/.container-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootsnav.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="assets/js/main.js"></script>
    
	
</body>
</html>
