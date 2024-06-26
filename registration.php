<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp - Registration</title>
    <link rel="stylesheet" href="style/style.css">

    <script>
        function validateForm() {
            var firstName = document.getElementById('firstName').value.trim();
            var lastName = document.getElementById('lastName').value.trim();
            var email = document.getElementById('email').value.trim();
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

          
            // Validate email format
            var emailRegex = /^[^\s@]+@([^\s@]+\.)?contata\.in$/i;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                $('.toast-body').html('Please enter a valid email address.');
                $('.toast').toast('show');
                return false;
            }

            // Validate password and confirm password match
            if(password.length<6){
                alert("Password length should be at least 6");
                return false;
            }
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            return true;
        }
    </script>
   
</head>

<body>
    <div class="container reg-container">
        <div class="title">Registration</div>
        <div class="content">
            <form action="#" >
                <div class="user-details fields">
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" id="firstName" placeholder="Enter your first name" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" id="middleName" placeholder="Enter your middle name" >
                    </div>
                    <div class="input-box">
                        <span class="details">Last Name</span>
                        <input type="text" id="lastName" placeholder="Enter your last name" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" id="confirmPassword" placeholder="Confirm your password" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" id="registerBtn" value="Register" onclick="validateForm()">
                </div>
                <div class="log">
                    Already Registered ? <a href="index.php">Login</a>
                </div>
            </form>
        </div>
    </div>


</body>

</html>
