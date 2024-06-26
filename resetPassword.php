<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password recovery</title>
    <link rel="stylesheet" href="style/style.css">

    <script>
        function validateForm() {
           
            var email = document.getElementById('email').value.trim();
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

            // Validate email format
            var emailRegex = /^[^\s@]+@([^\s@]+\.)?contata\.in$/i;
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
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
<div class="container log-container">
        <div class="title">Password recovery</div>
        <div class="content">
            <form action="#" onsubmit="return validateForm()">
                <div class="user-details fileds">
                   
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-box">
                        <span class="details">New Password</span>
                        <input type="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm New Password</span>
                        <input type="password" id="confirmPassword" placeholder="Confirm your password" required>
                    </div>
                    <div class="input-box">
                        <span class="details">OTP</span>
                        <input type="text" placeholder="Enter OTP" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Submit">
                </div>
                
            </form>
        </div>
    </div>
</body>
</html>