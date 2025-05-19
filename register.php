<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Registration</title>
    <link rel="stylesheet" href="assets/register/regi.css">
    <script>
    function checkAvailability(type, value) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "check_exists.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText.includes("taken")) {
                    document.getElementById(type + "-error").innerText = "Already taken";
                } else {
                    document.getElementById(type + "-error").innerText = "";
                }
            }
        };
        
        xhr.send("type=" + type + "&value=" + encodeURIComponent(value));
    }

    function validateForm() {
        var firstname = document.forms["registrationForm"]["firstname"].value;
        var lastname = document.forms["registrationForm"]["lastname"].value;
        var email = document.forms["registrationForm"]["email"].value;
        var phone = document.forms["registrationForm"]["phone"].value;
        var username = document.forms["registrationForm"]["username"].value;
        var password = document.forms["registrationForm"]["password"].value;
        var confirm_password = document.forms["registrationForm"]["confirm_password"].value;

        // Basic validation - checking if fields are empty
        if (firstname == "" || lastname == "" || email == "" || phone == "" || username == "" || password == "" || confirm_password == "") {
            alert("All fields must be filled out");
            return false;
        }

        // Alphabet validation for first name and last name
        if (!/^[a-zA-Z]+$/.test(firstname)) {
            alert("First name can only contain alphabets");
            return false;
        }
        if (!/^[a-zA-Z]+$/.test(lastname)) {
            alert("Last name can only contain alphabets");
            return false;
        }

        // Phone number validation
        if (!/^(9|7|6)\d{8,9}$/.test(phone)) {
            alert("Phone number should start with 9, 7, or 6 and be 9 to 10 digits long");
            return false;
        }

        // Password validation - basic check for length
        if (password.length < 6) {
            alert("Password must be at least 6 characters long");
            return false;
        }

        // Checking if passwords match
        if (password !== confirm_password) {
            alert("Passwords do not match");
            return false;
        }

        // If all validations pass, return true to allow form submission
        return true;
    }
    </script>
</head>

<body class="register-page">
    <div>
        <h2>Register to Forza Motors</h2>
        <form name="registrationForm" method="post" onsubmit="return validateForm()">
            <div class="textbox">
                <input type="text" placeholder="First Name" name="firstname" required>
            </div>
            <div class="textbox">
                <input type="text" placeholder="Last Name" name="lastname" required>
            </div>
            <div class="textbox">
                <input type="email" placeholder="Email" name="email" required onkeyup="checkAvailability('email', this.value)">
                <span id="email-error" style="color: red;"></span>
            </div>
            <div class="textbox">
                <input type="tel" placeholder="Phone Number" name="phone" required onkeyup="checkAvailability('phone', this.value)">
                <span id="phone-error" style="color: red;"></span>
            </div>
            <div class="textbox">
                <input type="text" placeholder="Username" name="username" required onkeyup="checkAvailability('username', this.value)">
                <span id="username-error" style="color: red;"></span>
            </div>
            <div class="textbox">
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="textbox">
                <input type="password" placeholder="Confirm Password" name="confirm_password" required>
            </div>
            <input type="submit" class="btn" value="Register">
            <p class="login-link"><center>Already have an account? <a href="index.php">Login</a></center></p>
        </form>
    </div>
</body>
</html>
