<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("./sendOTP.php");
  
    $user = new ChatUser();
    $user->setRegistrationEmail($_POST['email']);
    $user_data = $user->getUserByEmail();
    if(is_array( $user_data) && count($user_data) > 0)
    {

        $_SESSION['reset_email']=$_POST['email'];
        sendOtp($_POST['email']);
    }
    else
    {
        echo 'error';
    }
}
?>

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

            // Validate email format
            var emailRegex = /^[^\s@]+@([^\s@]+\.)?contata\.in$/i;
            var errorMessage = "Please enter a valid email address";
            if (!emailRegex.test(email)) {
                document.getElementById('emailError').textContent = errorMessage;
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
            <form method="post" onsubmit="return validateForm()">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" id="email" name="email" placeholder="Enter your email" required>
                        <div id="emailError" class="error-message"></div>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Reset Password">
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