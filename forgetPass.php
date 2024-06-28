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
            <form action="sendOTP.php" method="post" onsubmit="return validateForm()">
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