<?php
session_start();
$error = $_SESSION['reset_email'];
$success_message = '';

if (!isset($_SESSION['reset_email'])) {
    header('location:forgetPass.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once ('database/ChatUser.php');

    $user = new ChatUser();
    $user->setPassword($_POST['password']);
    if ($user->newPassword($_POST['otp'], $_SESSION['reset_email'], $_POST['password'])) {
        $success_message = "Password updated ! Enjoy your safe & secure chatting :)";

    } else {
        $error = "Error: Invalid otp";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function validateForm() {


            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;


            // Validate password and confirm password match

            var passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            var errorMessage = "Password must contain at least one letter, one number, one special character, and be at least 8 characters long.";

            var target = document.getElementById('passwordError');
            // Check if password matches the regex
            if (!passwordRegex.test(password)) {
                target.style.display = "inline";
                target.textContent = errorMessage;
                return false;
            } target.style.display = "none";

            var errorMessage = "Password and Confirm Password do not match";
            var target = document.getElementById('confError');

            if (password !== confirmPassword) {
                target.style.display = "inline";
                target.textContent = errorMessage;
                return false;
            } target.style.display = "none";

            return true;
        }
    </script>
</head>
<style>
    .otp-input-resend-box {
        display: flex;
    }

    .resend-button {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px 10px;
        text-decoration: none;
        color: #fff;
        background-color: #030617;
        border: none;
    }

    .otp-timer {
        font-size: 14px;
        text-align: center;
        margin-top: 2rem;
        padding: 4px;
        color: red;
    }

    .submit-button {
        margin: 0px 0px !important;
    }
</style>

<body>
    <div class="container log-container">
        <?php
        if ($error != '') {
            echo '<div class="alert alert-danger" role="alert">
                ' . $error . '
                </div>';
        }
        if ($success_message != '') {
            echo '<div class="alert alert-success" role="alert">
                ' . $success_message . '
                </div>';
        }
        ?>
        <div class="title">Password recovery</div>
        <div class="content">
            <form method="POST" onsubmit="return validateForm()">
                <div class="user-details fileds">
                    <div class="input-box">
                        <span class="details">New Password</span>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <div id="passwordError" class="error-message"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm New Password</span>
                        <input type="password" id="confirmPassword" name="cpassword" placeholder="Confirm your password"
                            required>
                        <div id="confError" class="error-message"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">OTP</span>
                        <div class="otp-input-resend-box">
                            <input type="text" placeholder="Enter OTP" name="otp" required>
                            <button class="resend-button" id="delayedLink">Resend</button>
                            </input>
                        </div>
                    </div>
                </div>
                <div class="otp-timer">
                    <span id="timer">
                        2:00
                    </span>
                </div>
                <div class="button submit-button">
                    <input type="submit" value="Submit">
                </div>
                <div class="back-to-login">
                    <a href="index.php">
                        <span><img src="./assets/arrow.png" alt=""></span>
                        <p>Back to Log in</p>
                    </a>

                    <a href="forgetPass.php" id="delayedLink" style="display:inline;">Resend OTP</a>
                </div>
            </form>
        </div>
    </div>



</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let timer = 120; // 2 minutes in seconds
        const timerDisplay = document.getElementById('timer');
        const resendButton = document.getElementsByClassName('resend-button');

        function startTimer() {
            let minutes, seconds;
            const countdown = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                timerDisplay.textContent = minutes + ":" + seconds;

                if (--timer < 0) {
                    clearInterval(countdown);
                    resendButton.disabled = false;
                    timerDisplay.textContent = "00:00";
                }
            }, 1000);
        }

        // Start the timer when the page loads
        startTimer();

        // Reset timer when resend button is clicked
        resendButton.addEventListener('click', function () {
            timer = 120;
            resendButton.disabled = true;
            startTimer();
            // Here you would also add the logic to resend the OTP
        });
    });
</script>

</html>