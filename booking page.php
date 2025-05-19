<?php
session_start(); // Start the session

// Retrieve parameters from URL
$car_id = isset($_GET['car_id']) ? $_GET['car_id'] : '';
$collection_point_id = isset($_GET['collection_point']) ? $_GET['collection_point'] : '';
$return_point_id = isset($_GET['return_point']) ? $_GET['return_point'] : '';
$pickup_date = isset($_GET['pickup_date']) ? $_GET['pickup_date'] : '';
$dropoff_date = isset($_GET['dropoff_date']) ? $_GET['dropoff_date'] : '';

// Check if any parameter is missing
if (empty($car_id) || empty($collection_point_id) || empty($return_point_id) || empty($pickup_date) || empty($dropoff_date)) {
    echo "<p>Error: Missing required parameters.</p>";
} else {
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

    // Fetch car details from database using car_id
    $car_name = '';
    $car_image = '';  // Variable to hold car image URL
    $car_price = 0;   // Variable to hold car price
    if ($car_id) {
        $sql = "SELECT name, image, price FROM cars WHERE car_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing query: " . $conn->error);
        }
        $stmt->bind_param("i", $car_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $car_name = $row['name'];
            $car_image = $row['image'];  // Get car image URL
            $car_price = $row['price'];   // Get car price
        }
        $stmt->close();
    }

    // Fetch location names
    $collection_point_name = '';
    $return_point_name = '';
    if ($collection_point_id) {
        $sql = "SELECT name FROM locations WHERE loc_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing query: " . $conn->error);
        }
        $stmt->bind_param("i", $collection_point_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $collection_point_name = $row['name'];
        }
        $stmt->close();
    }
    if ($return_point_id) {
        $sql = "SELECT name FROM locations WHERE loc_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing query: " . $conn->error);
        }
        $stmt->bind_param("i", $return_point_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $return_point_name = $row['name'];
        }
        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 100px;
        }
        .navbar {
            background-color: white !important; /* Set the background color to black */
        }

        .navbar-nav > li > a {
            color: black !important; /* Set the text color to white */
        }

        .navbar-nav > li > a:hover {
            color: #ddd !important; /* Set a lighter color on hover for better visibility */
        }
        
        .navbar-brand {
            color: black !important; /* Set the brand text color to white */
        }

        .header-area {
            margin-bottom: 20px; /* Add space below the navigation bar */
        }
        form {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .vehicle-info, .choose-plan, .protection-packages, .addons, .checkout {
            margin-bottom: 20px;
        }
        .vehicle-details {
            display: flex;
            align-items: center;
        }
        .image-container {
            margin-right: 200px;
        }
        .image-container img {
            width: 300px;
            height: auto;
        }
        .details {
            flex: 1;
        }
        .price-summary {
            text-align: right;
        }
        .plans, .packages {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }
        .plan, .package {
            background: #e3f2fd;
            padding: 20px;
            border-radius: 10px;
            flex: 1;
            margin: 0 10px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .plan.active, .package.selected {
            border: 2px solid #3f51b5;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .select-plan, .select-package, .checkout-button {
            background: #81d4fa;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .select-plan:hover, .select-package:hover, .checkout-button:hover {
            background: #29b6f6;
            transform: scale(1.05);
        }
        h2 {
            color: #424242;
        }
        h4 {
            color: #00695c;
        }
        p {
            color: #555;
        }
        .total-amount {
            font-size: 1.5em;
            font-weight: bold;
        }
    </style>
</head>
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
                                <li class="scroll"><a href="#service">service</a></li>
                                <li><a href="aboutf.html">about us</a></li>
                                <li><a href="contact.html">contact</a></li>
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

    
    <div class="booking-form">
    
    <form action="fbook.php?car_id=<?php echo htmlspecialchars($car_id); ?>&collection_point=<?php echo urlencode($collection_point_name); ?>&return_point=<?php echo urlencode($return_point_name); ?>&pickup_date=<?php echo urlencode($pickup_date); ?>&dropoff_date=<?php echo urlencode($dropoff_date); ?>" method="POST">
    <h2>Book Your Vehicle</h2>

    <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car_id); ?>">
    <input type="hidden" name="_token" value="your_token" autocomplete="off">
    <input type="hidden" name="car_daily_price" value="<?php echo htmlspecialchars($car_price); ?>" id="car-daily-price">
    <input type="hidden" name="final_total" value="0" id="final-total">
    
    <div class="vehicle-details">
        <?php if (!empty($car_image)): ?>
            <div class="image-container">
                <img src="<?php echo htmlspecialchars($car_image); ?>" alt="Car Image" class="car-image">
            </div>
        <?php else: ?>
            <p>No image available.</p>
        <?php endif; ?>

        <div class="details">
            <h3 class="vehicle-title"><?php echo htmlspecialchars($car_name); ?></h3>
            <div class="location">
                <div class="pickup-location">
                    <h3>Collection Point</h3>
                    <p><?php echo htmlspecialchars($collection_point_name); ?></p>
                    <p><?php echo htmlspecialchars($pickup_date); ?></p>
                </div>
                <div class="drop-location">
                    <h3>Return Point</h3>
                    <p><?php echo htmlspecialchars($return_point_name); ?></p>
                    <p><?php echo htmlspecialchars($dropoff_date); ?></p>
                </div>
            </div>
        </div>

        <div class="price-summary">
            <h3>Total</h3>
            <div class="amount" id="grand-total">₹0.00</div> <!-- Initialize to 0 -->
        </div>
    </div>

    <section class="choose-plan">
        <h2>Choose Your Plan</h2>
        <div class="plans">
            <div class="plan premium">
                <h4>Premium</h4>
                <p>No Security Deposit</p>
                <button type="button" class="select-plan" data-amount="13000">₹ 13,000.00</button>
            </div>
            <div class="plan plus">
                <h4>Plus</h4>
                <p>Security Deposit: ₹4000</p>
                <p>668 KMs</p>
                <button type="button" class="select-plan" data-amount="7000">₹ 7,000.00</button>
            </div>
            <div class="plan basic active">
                <h4>Basic</h4>
                <p>Security Deposit: ₹5000</p>
                <p>445 KMs</p>
                <button type="button" class="select-plan" data-amount="6000">₹ 6,000.00</button>
            </div>
        </div>
    </section>

    <section class="protection-packages">
        <h2>Protection Packages</h2>
        <div class="packages">
            <div class="package basic">
                <h4>Basic</h4>
                <p>₹ 1,500</p>
                <button type="button" class="select-package" data-amount="1500">Select</button>
            </div>
            <div class="package smart">
                <h4>Smart</h4>
                <p>₹ 3,000</p>
                <button type="button" class="select-package" data-amount="3000">Select</button>
            </div>
            <div class="package safe">
                <h4>Safe</h4>
                <p>₹ 7,000</p>
                <button type="button" class="select-package" data-amount="7000">Select</button>
            </div>
        </div>
    </section>

    <section class="addons">
        <h3>Addons</h3>
        <div class="addon-option">
            <label>
                <input type="checkbox" name="addons[]" value="1" data-amount="200"> Co-Driver - ₹200
            </label>
        </div>
    </section>

    <div class="form-group">
        <input type="button" value="Book Now" onclick="submitForm();">
    </div>
</form>


<script>
    let totalAmount = 0; // Initialize total amount
    const carDailyPrice = parseFloat(document.getElementById('car-daily-price').value) || 0; // Get car daily price
    const pickupDate = new Date('<?php echo htmlspecialchars($pickup_date); ?>');
    const dropoffDate = new Date('<?php echo htmlspecialchars($dropoff_date); ?>');

    // Calculate the number of days
    const timeDiff = dropoffDate - pickupDate;
    const numberOfDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); // Convert milliseconds to days
    const carPriceTotal = carDailyPrice * numberOfDays; // Total car price

    // Function to update total
    function updateTotal() {
    const selectedPlanAmount = parseFloat(document.querySelector('.plans .plan.active .select-plan')?.dataset.amount || 0);

    const selectedPackageAmount = parseFloat(document.querySelector('.protection-packages .package.active .select-package')?.dataset.amount || 0);

    const selectedAddonsAmount = Array.from(document.querySelectorAll('.addons input:checked'))
        .reduce((sum, addon) => sum + parseFloat(addon.dataset.amount || 0), 0);

    totalAmount = carPriceTotal + selectedPlanAmount + selectedPackageAmount + selectedAddonsAmount;

    document.getElementById('grand-total').innerText = '₹ ' + totalAmount.toFixed(2);
    document.getElementById('final-total').value = totalAmount.toFixed(2);
}



// Function to submit the form


    

    // Function to submit the form
    function submitForm() {
        updateTotal(); // Ensure the total is updated before submission
        document.forms[0].submit(); // Submit the form
    }

    // Event listeners for plans and packages
    document.querySelectorAll('.select-plan').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.plans .plan').forEach(plan => plan.classList.remove('active'));
            this.parentElement.classList.add('active');
            updateTotal();
        });
    });

    // Listen for addon checkbox changes
document.querySelectorAll('.addons input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', updateTotal);
});


    document.querySelectorAll('.select-package').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.protection-packages .package').forEach(pkg => pkg.classList.remove('active'));
            this.parentElement.classList.add('active');
            updateTotal();
        });
    });

    // Calculate total on page load
    updateTotal();
</script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootsnav.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="assets/js/main.js"></script>
	
</body>
</html>