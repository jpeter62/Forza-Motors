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
    <title>Forza Motors - Available Cars</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 20px;
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
            color: white !important; /* Set the brand text color to white */
        }

        .header-area {
            margin-bottom: 20px; /* Add space below the navigation bar */
        }
        .vehicle-title-container {
        display: flex;
       justify-content: center; /* Center horizontally */
       align-items: center; /* Center vertically if needed */
       padding: 20px; /* Optional: space around the container */
       } 

        .vehicle-title {
         font-size: 1.5em;
         color: #333;
         margin: 20px auto; /* Center horizontally with auto margins */
         text-align: center; /* Center the text inside the container */
         align-items:center;
         padding: 0 20px;
         max-width: 1200px; /* Optional: constrain the width for better centering */
        }

        .vehicle-title h2 {
         font-size: 1.5em;
        color: #333;
        text-align: center;
        padding: 0 20px;
        max-width: 1200px;
        font-weight: 700; /* Bold */
        text-transform: uppercase; /* Capitalize all letters */
        letter-spacing: 1px; /* Add space between letters */
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3); /* Subtle shadow */
        font-family: 'Oswald', sans-serif; /* Stylish font */
        }

        .cars-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1200px;
            padding: 20px;
            margin: 20px;
        }

        .car-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background-color: #fff;
            text-align: center;
            padding: 15px;
        }

        .car-card img {
            max-width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
        }

        .car-card h2 {
            font-size: 1.25em;
            margin: 10px 0;
        }

        .car-card p {
            margin: 5px 0;
        }

        .book-button {
            background-color: #000000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 1em;
            margin-top: 10px;
            padding: 10px;
           
        }

        .book-button:hover {
            background-color: #000056;
            transform: scale(1.05);
        }
        
        .additional-title-container {
    background-color: #f0f0f0; /* Light gray background */
    border: 1px solid #ddd; /* Light border */
    border-radius: 8px; /* Rounded corners */
    padding: 20px; /* Space inside the box */
    margin: 20px auto; /* Center the box */
    max-width: 800px; /* Constrain the width */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    text-align: center; /* Center text */
}
         
        .additional-title {
          
     
         font-size: 1.25em; /* Slightly smaller than the main title */
         color: #555; /* A lighter shade for differentiation */
         text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1); /* Subtle shadow */
         font-family: 'Poppins', sans-serif; /* Another stylish font */
        } 

         .additional-title h2 {
          margin: 30px; /* Add some horizontal spacing between the sentences */
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
                            <a class="navbar-brand" href="index.php">FORZA MOTORS<span></span></a>
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
        <!-- top-area End -->
    </section>
</div> 


<div class="vehicle-title-container">
    <div class="vehicle-title">
        <h2>WHICH VEHICLE WOULD YOU LIKE TO DRIVE?</h2>
    </div>
</div>
 
     
<div class="vehicle-title">
        <h2>WHICH VEHICLE WOULD YOU LIKE TO DRIVE?</h2>
    </div>

    <div class="cars-container">
        
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $collection_point = $_POST['collection_point'];
    $return_point = $_POST['returnPoint'];
    $pickup_date = $_POST['pickup_date'];
    $dropoff_date = $_POST['dropoff_date'];

    // Prepare and execute the SQL query to check car availability
    $sql = "SELECT c.car_id, c.name, c.image, c.transmission, c.year 
    FROM availability a
    JOIN cars c ON a.car_id = c.car_id
    WHERE a.location_id = ? 
      AND a.available_from <= ? 
      AND a.available_to >= ? 
      AND a.status = 'available'";

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
        // Output data for each car
        while ($row = $result->fetch_assoc()) {
            echo '<div class="car-card">';
            echo '<img src="' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["name"]) . '">';
            echo '<h2>' . htmlspecialchars($row["name"]) . '</h2>';
            echo '<p>Transmission: ' . htmlspecialchars($row["transmission"]) . '</p>';
            echo '<p>Year: ' . htmlspecialchars($row["year"]) . '</p>';
            echo '<a href="http://localhost/forzamotors/booking%20page.php?car_id=' . htmlspecialchars($row["car_id"]) . '&collection_point=' . urlencode($collection_point) . '&return_point=' . urlencode($return_point) . '&pickup_date=' . urlencode($pickup_date) . '&dropoff_date=' . urlencode($dropoff_date) . '" class="book-button">Book Now</a>';
            echo '</div>';
        }
    } else {
        echo "<h3>No cars available</h3>";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>   <div class="additional-title-container">
         <div class="additional-title">
           <h2>All our vehicles are safe and reliable.</h2>
         </div>
       </div>      
     <div class="additional-title-container">   
         <div class="additional-title">
           <h2>From high-end sedans to premium SUVs</h2> 
         </div>
       </div>     
      <div class="additional-title-container">     
         <div class="additional-title">
           <h2>Stress-free, no hidden costs</h2>
         </div>
      </div>   
         
         

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
