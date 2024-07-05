<?php
session_start();
$error = '';
$success_message = '';

//checking user is logged in
if (!isset($_SESSION['reset_email'])) {
    header('location:forgetPass.php');
}
$user_email = $_SESSION['reset_email'];

//handling otp send request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['otp'])) {
    require_once ('sendOtp.php');

    $user = new ChatUser();
    $user->setPassword($_POST['password']);
    $user->setRegistrationEmail($_SESSION['reset_email']);
    $res = checkOtp($_POST['otp'], $_SESSION['reset_email']);

    if ($res == 2) {
        $user->resetPassword();
        $success_message = "Password updated ! Enjoy your safe & secure chatting :)";
        unset($_SESSION["reset_email"]);
    } else if ($res == 1) {
        $error = "OTP is Expired";
    } else {
        $error = "Invalid OTP";
    }
}

//Resend otp logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['otpemail'])) {
    require ("./sendOTP.php");


    $user = new ChatUser();
    $user->setRegistrationEmail($_POST['otpemail']);
    $user_data = $user->getUserByEmail();
    if (is_array($user_data) && count($user_data) > 0) {

        sendOtp($_POST['otpemail']);
        $success_message = "Email Sent";
    } else {
        $success_message = "Email Sent";
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

    #resend-button {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px 10px;
        text-decoration: none;
        color: #fff;
        background-color: #030617;
        border: none;
    }

    #resend-button[disabled] {
        cursor: not-allowed;
        opacity: 0.7;
        pointer-events: none;
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

    <div id="toaster" class="toaster"></div>

    <div class="container log-container">
        <!-- <?php
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
        ?> -->
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
                            <button id="resend-button" id="delayedLink" data-email="<?php echo $user_email ?>"
                                style="display:inline;" disabled>Resend</button>
                            </input>
                        </div>
                    </div>
                </div>
                <div class="otp-timer">
                    <span id="timer">

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
                </div>
            </form>
        </div>
    </div>


    <script src="js/check.js">

    </script>
</body>
<script>
    // LOGIC FOR COUNTDOWN TIMER
    document.addEventListener('DOMContentLoaded', function () {
        const timerDisplay = document.getElementById('timer');
        const resendButton = document.getElementById('resend-button');
        let timer;
        let countdown;

        function initializeTimer() {
            const startTime = localStorage.getItem('otpStartTime');
            const now = new Date().getTime();
            const elapsedTime = now - parseInt(startTime);

            if (startTime && elapsedTime < 30000) {
                // If less than 30 seconds have passed, continue the timer
                timer = Math.max(0, 30 - Math.floor(elapsedTime / 1000));
            } else {
                // If more than 30 seconds have passed or no start time, set timer to 0
                timer = 0;
            }

            updateTimerDisplay();
            if (timer > 0) {
                startTimer();
                resendButton.disabled = true;
            } else {
                resendButton.disabled = false;
            }
        }

        function startTimer() {
            countdown = setInterval(function () {
                timer--;
                updateTimerDisplay();

                if (timer <= 0) {
                    clearInterval(countdown);
                    resendButton.disabled = false;
                    localStorage.removeItem('otpStartTime');
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            let minutes = Math.floor(timer / 60);
            let seconds = timer % 60;

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            timerDisplay.textContent = minutes + ":" + seconds;
        }

        function resetTimer() {
            clearInterval(countdown);
            timer = 30;
            const now = new Date().getTime();
            localStorage.setItem('otpStartTime', now.toString());
            resendButton.disabled = true;
            updateTimerDisplay();
            startTimer();
        }

        // LOGIC FOR RESENDING OTP
        resendButton.addEventListener('click', function (event) {
            // console.log('resend clicked')
            event.preventDefault();

            // Get the email from data attribute
            var userEmail = resendButton.getAttribute('data-email');

            // Create form element
            var form = document.createElement('form');
            form.setAttribute('method', 'POST');

            // Create hidden input field for email
            var emailInput = document.createElement('input');
            emailInput.setAttribute('type', 'hidden');
            emailInput.setAttribute('name', 'otpemail');
            emailInput.setAttribute('value', userEmail);

            // Append the input to the form
            form.appendChild(emailInput);

            // Append the form to the document body
            document.body.appendChild(form);

            form.submit();

            // Reset the timer after form submission
            resetTimer();
        });

        initializeTimer();
    });

    // Toaster Message
    <?php if ($success_message != '' || $error != ''): ?>
        var toaster = document.getElementById('toaster');
        toaster.textContent = "<?php echo $success_message != '' ? $success_message : $error; ?>";
        toaster.style.backgroundColor = "<?php echo $success_message != '' ? '#065e40' : '#f44336'; ?>"; // Green for success, red for error

        toaster.style.display = "block";

        setTimeout(function () {
            toaster.style.display = "none"; // Redirect after 2 seconds
            <?php if ($success_message != ''): ?>
            window.location.href = "index.php";
            <?php endif; ?>
        }, 2000);
    <?php endif; ?>

</script>

</html>