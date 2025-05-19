<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/forzamotors/index.php");
    exit();
}

// Database connection details
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'forzamotors'; // Adjust for your database

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
}

// Fetch user data from the users_data table based on session username
$username = $_SESSION['username'];
$email = '';

// Fetch the email for the logged-in user
$sql = "SELECT email FROM users_data WHERE username = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();
} else {
    die("<p style='color:red;'>Error preparing statement: " . $conn->error . "</p>");
}

// Initialize variables
$name = $username; // Autofill with the session username
$car_model = $rating = $review = '';
$errors = [];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging: Show submitted POST data
    var_dump($_POST); // Check the submitted data

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $car_model = trim($_POST['car_model']);
    $rating = $_POST['rate'];
    $review = trim($_POST['review']);

    // Validate form inputs
    if (empty($name)) {
        $errors[] = "Name must be at least 3 characters long and start with a capital letter.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (empty($car_model)) {
        $errors[] = "Car model is required.";
    }
    if (empty($rating)) {
        $errors[] = "Rating is required.";
    }
    if (empty($review)) {
        $errors[] = "Review is required.";
    }

    // If no errors, insert data into database
    if (empty($errors)) {
        $sql = "INSERT INTO feedback (name, email, car_model, rating, review) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $name, $email, $car_model, $rating, $review);
            if ($stmt->execute()) {
                echo "<p style='color:green;'>Review submitted successfully!</p>";
            } else {
                echo "<p style='color:red;'>Error during submission: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p style='color:red;'>Error preparing insert statement: " . $conn->error . "</p>";
        }
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
    echo '<p class="success-message">Thank you for your feedback! Your review has been submitted successfully.</p>';
}


$conn->close();
?>


<!DOCTYPE html>
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
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 100px;
        }
        /* Success message styling */
    .success-message {
        color: green;
        font-size: 1.1em;
        margin-bottom: 15px;
        text-align: center;
    }
        .navbar {
            background-color: black !important; /* Set the background color to black */
        }

        .navbar-nav > li > a {
            color: white !important; /* Set the text color to white */
        }

        .navbar-nav > li > a:hover {
            color: blue !important; /* Set a lighter color on hover for better visibility */
        }
        
        .navbar-brand {
            color: white !important; /* Set the brand text color to white */
        }

        .header-area {
            margin-bottom: 20px; /* Add space below the navigation bar */
        }
        /* Container styling */
    .review-container {
    background-color: #f7f7f7;
    background-image: url('images/feedback-bg.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 50px auto; /* Adjust margin-top to move it down */
    text-align: center;
}

        .review-h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }

        /* Form styling */
        .review-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .label {
            font-size: 16px;
            margin-bottom: 5px;
            color: #333;
        }

        .input-review, select, textarea {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: #f9f9f9;
            color: #333;
        }

        .input-review, select:focus, textarea:focus {
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .submit-btn {
            padding: 14px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }
        .rating:not(:checked) > input {
  position: absolute;
  appearance: none;
}

.rating:not(:checked) > label {
  float: right;
  cursor: pointer;
  font-size: 30px;
  color: #666;
}

.rating:not(:checked) > label:before {
  content: '★';
}

.rating > input:checked + label:hover,
.rating > input:checked + label:hover ~ label,
.rating > input:checked ~ label:hover,
.rating > input:checked ~ label:hover ~ label,
.rating > label:hover ~ input:checked ~ label {
  color: #e58e09;
}

.rating:not(:checked) > label:hover,
.rating:not(:checked) > label:hover ~ label {
  color: #ff9e0b;
}

.rating > input:checked ~ label {
  color: #ffa723;
}
        


    </style>
</head>
<body>
<body id="about-page">
    <!-- Navigation Start -->
    <section id="home">
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
                            <a class="navbar-brand" href="http://localhost/forzamotors/index.php">FORZA MOTORS<span></span></a>
                        </div><!--/.navbar-header-->
                        <!-- End Header Navigation -->
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse menu-ui-design" id="navbar-menu">
                            <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                                <li><a href="http://localhost/forzamotors/index.php">home</a></li>
                                <li class=""><a href="aboutf.html">about us</a></li>
                                <li class=""><a href="ctact.html">contact</a></li>
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
    

<div class="review-container">
    <h1 class="review-h1">Share Your Feedback</h1>
    <form action="" method="POST" class="review-form">
        <div class="form-group">
            <label for="name" class="label">Your UserName:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required class="input-review" readonly>
        </div>
        <div class="form-group">
            <label for="email" class="label">Your Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required class="input-review" readonly>
        </div>
        <div class="form-group">
            <label for="car_model" class="label">Car Model:</label>
            <input type="text" id="car_model" name="car_model" required class="input-review">
        </div>
        
        <label for="car_rating" class="label3">Car Rating:</label>
        <div class="rating">          
          <input value="5" name="rate" id="star5" type="radio">
          <label title="text" for="star5"></label>
          <input value="4" name="rate" id="star4" type="radio">
          <label title="text" for="star4"></label>
          <input value="3" name="rate" id="star3" type="radio" checked="">
          <label title="text" for="star3"></label>
          <input value="2" name="rate" id="star2" type="radio">
          <label title="text" for="star2"></label>
          <input value="1" name="rate" id="star1" type="radio">
          <label title="text" for="star1"></label>
        </div>
        <div class="form-group">
            <label for="review" class="label">Your Review:</label>
            <textarea id="review" name="review" rows="5" required></textarea>
        </div>
        <button type="submit" class="submit-btn">Submit Feedback</button>
    </form>
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
                <!-- Include JavaScript files -->



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootsnav.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="assets/js/main.js"></script>
	

</body>
</html>