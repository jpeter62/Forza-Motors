<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if not logged in
    header("Location: http://localhost/forzamotors/LOGIN&REGISTER/index.php");
    exit();
}
echo '<script>alert("' . $_SESSION['userid'] . '");</script>';

// Access session variables as needed
$user_id = $_SESSION['userid'];
$username = $_SESSION['username'];


// Function to log out and destroy session
if (isset($_POST['logout'])) {
   // Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

// Redirect to the login page
header("Location: http://localhost/forzamotors/LOGIN&REGISTER/index.php");
exit();
}
?>
<!doctype html>
<html class="no-js" lang="en">

    <head>
        <!-- meta data -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <!--font-family-->
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

		<link href="https://fonts.googleapis.com/css?family=Rufina:400,700" rel="stylesheet">
        
        <!-- title of site -->
        <title>CarVilla</title>

        <!-- For favicon png -->
		<link rel="shortcut icon" type="image/icon" href="assets/logo/favicon.png"/>
       
        <!--font-awesome.min.css-->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">

        <!--linear icon css-->
		<link rel="stylesheet" href="assets/css/linearicons.css">

        <!--flaticon.css-->
		<link rel="stylesheet" href="assets/css/flaticon.css">

		<!--animate.css-->
        <link rel="stylesheet" href="assets/css/animate.css">

        <!--owl.carousel.css-->
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
		
        <!--bootstrap.min.css-->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- bootsnav -->
		<link rel="stylesheet" href="assets/css/bootsnav.css" >	
        
        <!--style.css-->
        <link rel="stylesheet" href="assets/css/s.css">
        
        <!--responsive.css-->
        <link rel="stylesheet" href="assets/css/responsive.css">
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		
        <!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


	
	<style>
        .logout-btn {
            padding: 10px 20px;
			margin: 16px;
            background-color:#4e4ffa;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #ff0000;
            transform: scale(1.05);
        }
        .logout-btn:active {
            transform: scale(0.95);
        }
        .content {
            padding: 20px;
            background-color: white;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <!-- JavaScript to prevent going back after logout -->
    <script>
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
        setTimeout("noBack()", 0);
        window.onunload = function () { null };
    </script>
    </head>
	
	<body>
		<!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->
	
		<!--welcome-hero start -->
		<section id="home" class="welcome-hero">

			<!-- top-area Start -->
			<div class="top-area">
				<div class="header-area">
					<!-- Start Navigation -->
				    <nav class="navbar navbar-default bootsnav  navbar-sticky navbar-scrollspy"  data-minus-value-desktop="70" data-minus-value-mobile="55" data-speed="1000">

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
								<li class=""><a href="http://localhost/forzamotors/index.php">home</a></li>
				                    <li class="scroll"><a href="#service">service</a></li>
				                   <!--  <li class="scroll"><a href="#featured-cars">featured cars</a></li>-->
									<li class=""><a href="http://localhost/forzamotors/feedback.php">Reviews</a></li>
				                    <li class=""><a href="aboutf.html">about us</a></li>
				                    <li class=""><a href="ctact.html">contact</a></li>
									<li class=""><a href="http://localhost/forzamotors/LOGIN&REGISTER/index.php">Register/Login</a></li>
									<li class=""><a href="mybookings.php">My Bookings</a></li>
									<form method="POST" style="display: inline;">
                                        <button type="submit" name="logout" class="logout-btn">Logout</button>
                                    </form>

								</ul><!--/.nav -->
				            </div><!-- /.navbar-collapse -->
				        </div><!--/.container-->
				    </nav><!--/nav-->
				    <!-- End Navigation -->
				</div><!--/.header-area-->
			    <div class="clearfix"></div>

			</div><!-- /.top-area-->
			<!-- top-area End -->

			<div class="container">
				<div class="welcome-hero-txt">

                       <h2>RENT PREMIUM CARS.
						PAY ECONOMY.</h2>




					
				</div>
			</div>

			<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="model-search-content">
			<form action="http://localhost/forzamotors/listing%20page.php" method="POST">
    <div class="row">
        <div class="col-md-offset-1 col-md-2 col-sm-12">
            <div class="single-model-search">
                <label for="collection_point"><h2>Collection Point:</h2></label>
                <div class="model-select-icon">
                    <select class="form-control" name="collection_point" id="collection_point">
                        <option value="default">locations</option>
                        <option value="1">Kuttikanam</option>
                        <option value="2">Peermade</option>
                        <option value="3">Elappara</option>
                    </select>
                </div>
            </div>

            <div class="single-model-search">
                <h2>Return Point:</h2>
                <div class="model-select-icon">
                    <select class="form-control" name="returnPoint">
                        <option value="default">location</option>
                        <option value="1">Kuttikanam</option>
                        <option value="2">Peermade</option>
                        <option value="3">Elappara</option>
                    </select>
                </div>
            </div>
        </div>

		<div class="col-md-offset-1 col-md-2 col-sm-12">
    <div class="single-model-search">
        <label for="pickup_date"><h2>Pick-up Date:</h2></label>
        <div class="model-select-icon">
            <input type="date" class="form-control" id="pickup_date" name="pickup_date" required>
        </div>
    </div>

    <div class="single-model-search">
        <label for="dropoff_date"><h2>Drop-off Date:</h2></label>
        <div class="model-select-icon">
            <input type="date" class="form-control" name="dropoff_date" id="dropoff_date" required>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0];
        var pickupDateInput = document.getElementById('pickup_date');
        var dropoffDateInput = document.getElementById('dropoff_date');

        // Set today's date as the minimum for pickup date
        pickupDateInput.min = today;
        pickupDateInput.value = today;

        // Set drop-off date minimum to one day after the pickup date
        var initialDropoffDate = new Date(today);
        initialDropoffDate.setDate(initialDropoffDate.getDate() + 1);
        dropoffDateInput.min = initialDropoffDate.toISOString().split('T')[0];
        dropoffDateInput.value = dropoffDateInput.min;

        // Update drop-off date minimum when the pickup date changes
        pickupDateInput.addEventListener('change', function() {
            var pickupDate = new Date(this.value);
            pickupDate.setDate(pickupDate.getDate() + 1);
            var minDropoffDate = pickupDate.toISOString().split('T')[0];
            dropoffDateInput.min = minDropoffDate;
            dropoffDateInput.value = minDropoffDate; // Update drop-off date to new minimum
        });
    });
</script>

        <div class="col-md-2 col-sm-12">
            <div class="single-model-search text-center">
                <button type="submit" class="welcome-btn model-search-btn">Search</button>
            </div>
        </div>
    </div>
</form>


            </div>
        </div>
    </div>
</div>



							</div>
						</div>
					</div>
				</div>
			</div>

		</section><!--/.welcome-hero-->
		<!--welcome-hero end -->

		<!--service start -->
		<section id="service" class="service">
			<div class="container">
				<div class="service-content">
					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="single-service-item">
								<div class="single-service-icon">
									<i class="flaticon-car"></i>
								</div>
                                <h2><a href="#">Standout Cars<span></span></a></h2>
                                <p>
                                    A curated selection of cars to suit your style.
                                </p>
                            </div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="single-service-item">
								<div class="single-service-icon">
									<i class="flaticon-car-repair"></i>
								</div>
                                <h2><a href="#">Zero Maintenance</a></h2>
                                <p>
                                    Our rental cars come with complete maintenance coverage, so you can focus on the journey, not the upkeep. 
                                </p>
                            </div>
						</div>
						<div class="col-md-4 col-sm-6">
							<div class="single-service-item">
								<div class="single-service-icon">
									<i class="flaticon-car-1"></i>
								</div>
								<h2><a href="#">Exceptional service</a></h2>
								<p>
									Stress-free, trustworthy, no hidden costs.  
								</p>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.container-->

		</section><!--/.service-->
		<!--service end-->

		<!--new-cars start -->
		<section id="new-cars" class="new-cars">
			<div class="container">
				<div class="section-header">
			
					<h2>Our Services</h2>
				</div><!--/.section-header-->
				<div class="new-cars-content">
					<div class="owl-carousel owl-theme" id="new-cars-carousel">
						<div class="new-cars-item">
							<div class="single-new-cars-item">
								<div class="row">
									<div class="col-md-7 col-sm-12">
										<div class="new-cars-img">
											<img src="assets/images/new-cars-model/2.png" alt="img"/>
										</div><!--/.new-cars-img-->
									</div>
									<div class="col-md-5 col-sm-12">
										<div class="new-cars-txt">
											<h2><a href="#">1.
												Search & Book Your Preferred Vehicle</a></h2>
											<p>
												Chooose your desired vehicle from our various available options.
											</p>
											<p class="new-cars-para2">
												
											</p>
											
										</div><!--/.new-cars-txt-->	
									</div><!--/.col-->
								</div><!--/.row-->
							</div><!--/.single-new-cars-item-->
						</div><!--/.new-cars-item-->
						<div class="new-cars-item">
							<div class="single-new-cars-item">
								<div class="row">
									<div class="col-md-7 col-sm-12">
										<div class="new-cars-img">
										<img src="assets/images/new-cars-model/1.png" alt="img"/> 
										</div><!--/.new-cars-img-->
									</div>
									<div class="col-md-5 col-sm-12">
										<div class="new-cars-txt">
											<h2><a href="#">2.
												Pick Up and Drive.
												</a></h2>
											<p>
												Take delivery of your car, either by picking it up or having it delivered, and start your road trip with loved ones.m, and embark on a memorable road trip with loved ones. 
											</p>
											<p class="new-cars-para2">
												
											</p>
											
										</div><!--/.new-cars-txt-->	
									</div><!--/.col-->
								</div><!--/.row-->	
							</div><!--/.single-new-cars-item-->
						</div><!--/.new-cars-item-->
						<div class="new-cars-item">
							<div class="single-new-cars-item">
								<div class="row">
									<div class="col-md-7 col-sm-12">
										<div class="new-cars-img">
										<img src="assets/images/new-cars-model/1.png" alt="img"/> 
										</div><!--/.new-cars-img-->
									</div>
									<div class="col-md-5 col-sm-12">
										<div class="new-cars-txt">
											<h2><a href="#">3.
												Return your Vehicle</a></h2>
											<p>
												Get the vehicle back to your preferred return location, and we will take it from there. 
											</p>
											<p class="new-cars-para2">
												
											</p>
											
										</div><!--/.new-cars-txt-->	
									</div><!--/.col-->
								</div><!--/.row-->
							</div><!--/.single-new-cars-item-->
						</div><!--/.new-cars-item-->
					</div><!--/#new-cars-carousel-->
				</div><!--/.new-cars-content-->
			</div><!--/.container-->

		</section><!--/.new-cars-->
		<!--new-cars end -->

		<!--featured-cars start -->
		
		<section id="featured-cars" class="featured-cars">
			<div class="container">
				<div class="section-header">
					<p>checkout <span>the</span> featured cars</p>
					<h2>THE PERFECT CAR FOR YOUR NEXT TRIP</h2>
				</div><!--/.section-header-->
				<div class="featured-cars-content">
					<div class="row justify-content-center">
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="single-featured-cars">
								<div class="featured-img-box">
									<div class="featured-cars-img">
										<img src="assets/images/featured-cars/tabImg1.png" alt="cars">
									</div>
									<div class="featured-model-info">
										<center>
										<h1>
											SKODA SLAVIA
											
											
										</h1>
										</center>
									</div>
								</div>
								
							</div>
						</div>
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="single-featured-cars">
								<div class="featured-img-box">
									<div class="featured-cars-img">
										<img src="assets/images/featured-cars/tabImg4.png" alt="cars">
									</div>
									<div class="featured-model-info">
										<center>
											<h1>
										     INNOVA CRYSTA
												
												
											</h1>
											</center>
									</div>
								</div>
								
							</div>
						</div>
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="single-featured-cars">
								<div class="featured-img-box">
									<div class="featured-cars-img">
										<img src="assets/images/featured-cars/tabImg3.png" alt="cars">
									</div>
									<div class="featured-model-info">
										<center>
											<h1>
											VW POLO
												
												
											</h1>
											</center>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-4 col-sm-6">
							<div class="single-featured-cars">
								<div class="featured-img-box">
									<div class="featured-cars-img">
										<img src="assets/images/featured-cars/HECTOR PLUS-D-MT.png" alt="cars">
									</div>
									<div class="featured-model-info">
										<center>
											<h1>
												MG HECTOR
												
												
											</h1>
											</center>
									</div>
								</div>
								
							</div>
						</div>
					</div><!--/.row-->
				</div><!--/.featured-cars-content-->
			</div><!--/.container-->
		</section><!--/#featured-cars-->
		
	
		<!--featured-cars end -->

		<!-- clients-say strat -->
		<section id="clients-say"  class="clients-say">
			<div class="container">
				<div class="section-header">
					<h2>what our clients say</h2>
				</div><!--/.section-header-->
				<div class="row">
					<div class="owl-carousel testimonial-carousel">
						<div class="col-sm-3 col-xs-12">
							<div class="single-testimonial-box">
								<div class="testimonial-description">
									<div class="testimonial-info">
										<div class="testimonial-img">
											<img src="assets/images/clients/c1.png" alt="image of clients person" />
										</div><!--/.testimonial-img-->
									</div><!--/.testimonial-info-->
									<div class="testimonial-comment">
										<p>
											I had an amazing experience with FORZA MOTORS during my recent holiday trip in Kerala. I rented a
                        Skoda Slavia from them, and it was in excellent condition. The car provided a comfortable ride
                        and had all the modern amenities I needed. The staff was super friendly, professional, and the
                        rental process was smooth. I highly recommend Forza Motors for anyone looking for a reliable car
                        rental service in Kerala. 
										</p>
									</div><!--/.testimonial-comment-->
									<div class="testimonial-person">
										<h2><a href="#">Harish Kandragula</a></h2>
										<h4>Travel Guide</h4>
									</div><!--/.testimonial-person-->
								</div><!--/.testimonial-description-->
							</div><!--/.single-testimonial-box-->
						</div><!--/.col-->
						<div class="col-sm-3 col-xs-12">
							<div class="single-testimonial-box">
								<div class="testimonial-description">
									<div class="testimonial-info">
										<div class="testimonial-img">
											<img src="assets/images/clients/c2.png" alt="image of clients person" />
										</div><!--/.testimonial-img-->
									</div><!--/.testimonial-info-->
									<div class="testimonial-comment">
										<p>
											Initially we were bit apprehensive renting a self drive car for the first time, that too
                        from a lesser known brand. But we took the leap and it turned out to be fabulous. I had
                        booked Taigun AT via their website. Car was delivered on time in sparkling condition. All
                        paper work was done in less than 10 mins. Car was in good condition. Pick up process also
                        was smooth and over in 10 mins. Deposit refund credited in 2 days post handover without any
                        follow-ups. Would rent again in future !"
										</p>
									</div><!--/.testimonial-comment-->
									<div class="testimonial-person">
										<h2><a href="#">Ram Kishore Kannan</a></h2>
										<h4></h4>
									</div><!--/.testimonial-person-->
								</div><!--/.testimonial-description-->
							</div><!--/.single-testimonial-box-->
						</div><!--/.col-->
						<div class="col-sm-3 col-xs-12">
							<div class="single-testimonial-box">
								<div class="testimonial-description">
									<div class="testimonial-info">
										<div class="testimonial-img">
											<img src="assets/images/clients/c3.png" alt="image of clients person" />
										</div><!--/.testimonial-img-->
									</div><!--/.testimonial-info-->
									<div class="testimonial-comment">
										<p>
											I recently rented a car from FORZA MOTORS and I couldn't be happier with my experience. From
                            start
                            to finish, everything was top-notch. Customer Service: The customer service I received was
                            exceptional. The staff was friendly, knowledgeable, and efficient. They made the rental
                            process
                            quick and hassle-free. Vehicle Condition: The rental vehicle was in excellent condition,
                            clean,
                            and well-maintained. I felt confident and safe driving it throughout my trip. Price and
                            Transparency: The pricing was fair and transparent.
										</p>
									</div><!--/.testimonial-comment-->
									<div class="testimonial-person">
										<h2><a href="#">Saiprasad Reddy</a></h2>
										<h4>Avid Traveller</h4>
									</div><!--/.testimonial-person-->
								</div><!--/.testimonial-description-->
							</div><!--/.single-testimonial-box-->
						</div><!--/.col-->
					</div><!--/.testimonial-carousel-->
				</div><!--/.row-->
			</div><!--/.container-->

		</section><!--/.clients-say-->	
		<!-- clients-say end -->

	

		<!--blog start -->
		<section id="blog" class="blog"></section><!--/.blog-->
		<!--blog end -->

		<!--contact start-->
		<footer id="contact"  class="contact">
			<div class="container">
				<div class="footer-top">
					<div class="row">
						<div class="col-md-3 col-sm-6">
							<div class="single-footer-widget">
								<div class="footer-logo">
									<a href="index.html">FORZA MOTORS</a>
								</div>
								<p>
								</p>
								<div class="footer-contact">
									<p>support@forzamotors.com</p>
									<p>+91 7802130000</p>
								</div>
							</div>
						</div>
						<div class="col-md-2 col-sm-6">
							<div class="single-footer-widget">
								<h2>about forzamotors</h2>
								<ul>
									<li><a href="#">about us</a></li>
									<li><a href="#">career</a></li>
									<li><a href="#">terms <span> of service</span></a></li>
									<li><a href="#">privacy policy</a></li>
								</ul>
							</div>
						</div>
						
						<div class="col-md-offset-1 col-md-3 col-sm-6">
							<div class="single-footer-widget">
								<h2>news letter</h2>
								<div class="footer-newsletter">
									<p>
										Subscribe to get latest news  update and informations
									</p>
								</div>
								<div class="hm-foot-email">
									<div class="foot-email-box">
										<input type="text" class="form-control" placeholder="Add Email">
									</div><!--/.foot-email-box-->
									<div class="foot-email-subscribe">
										<span><i class="fa fa-arrow-right"></i></span>
									</div><!--/.foot-email-icon-->
								</div><!--/.hm-foot-email-->
							</div>
						</div>
					</div>
				</div>
				<div class="footer-copyright">
					<div class="row">
						<div class="col-sm-6">
							<p>
								&copy; copyright.designed and developed by <a href="https://www.themesine.com/">forzamotors</a>.
							</p><!--/p-->
						</div>
						<div class="col-sm-6">
							<div class="footer-social">
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

			<div id="scroll-Top">
				<div class="return-to-top">
					<i class="fa fa-angle-up " id="scroll-top" data-toggle="tooltip" data-placement="top" title="" data-original-title="Back to Top" aria-hidden="true"></i>
				</div>
				
			</div><!--/.scroll-Top-->
			
        </footer><!--/.contact-->
		<!--contact end-->


		
		<!-- Include all js compiled plugins (below), or include individual files as needed -->

		<script src="assets/js/jquery.js"></script>
        
        <!--modernizr.min.js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
		
		<!--bootstrap.min.js-->
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- bootsnav js -->
		<script src="assets/js/bootsnav.js"></script>

		<!--owl.carousel.js-->
        <script src="assets/js/owl.carousel.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

        <!--Custom JS-->
        <script src="assets/js/custom.js"></script>
        
    </body>
	
</html>