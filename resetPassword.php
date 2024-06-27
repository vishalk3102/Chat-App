<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password recovery</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            if (password.length < 6) {
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
<style>
    .button {
        margin-bottom: 2px !important;
    }

    .back-to-login a {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px 0px;
        text-decoration: none;
        color: #000;

    }

    .back-to-login a span {
        display: flex;
        justify-content: center;
        align-items: center;

    }

    .back-to-login a span img {
        height: 20px;
        width: 30px;
        padding: 4px;
        margin-right: 4px;
    }

    .back-to-login a p {
        font-size: 12px;
        font-weight: 600;
    }
</style>

<body>
    <div class="container log-container">
        <div class="title">Password recovery</div>
        <div class="content">
            <form action="#" onsubmit="return validateForm()">
                <div class="user-details fileds">
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
                <div class="back-to-login">
                    <a href="index.php">
                        <span><img src="./assets/arrow.png" alt=""></span>
                        <p>Back to Log in</p>
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>