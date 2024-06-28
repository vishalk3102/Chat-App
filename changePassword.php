<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password recovery</title>
    <link rel="stylesheet" href="style/style.css">
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

<script>
        function validateForm() {

           
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

           
            // Validate password and confirm password match
        
            var passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            var errorMessage = "Password must contain at least one letter, one number, one special character, and be at least 8 characters long";

            // Check if password matches the regex
            var target=document.getElementById('passwordError');

            if (!passwordRegex.test(password)) {
                target.textContent = errorMessage;
                target.style.display="inline";
                return false;
            }target.style.display="none"; 

            var errorMessage = "Password and Confirm Password do not match";
            var target=document.getElementById('confError');
            if (password !== confirmPassword) {
                target.textContent = errorMessage;
                target.style.display="inline";
                return false;
            }target.style.display="none";

            return true;
        }
    </script>

<body>
    <div class="container log-container">
        <div class="title">Password recovery</div>
        <div class="content">
            <form action="#" onsubmit="return validateForm()">
                <div class="user-details fileds">
                    <div class="input-box">
                        <span class="details">Old Password</span>
                        <input type="password" placeholder="Enter your old password"  name="old-password" required>
                    </div>
                    <div class="input-box">
                        <span class="details">New Password</span>
                        <input type="text" placeholder="Enter your new password" id="password" name="new-password" required>
                        <div id="passwordError" class="error-message"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm New Password</span>
                        <input type="password" placeholder="Confirm your new password" id="confirmPassword" name="confirm-new-password" required>
                        <div id="confError" class="error-message"></div>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Submit">
                </div>
                <div class="back-to-login">
                    <a href="profile.php">
                        <span><img src="./assets/arrow.png" alt=""></span>
                        <p>Back</p>
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>