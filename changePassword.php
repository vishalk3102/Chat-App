<?php

session_start();
$error = '';
$success_message = '';

if (!isset($_SESSION['user_data'])) {
    header('location:index.php');
}
$user_obj = $_SESSION['user_data'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_SESSION['user_data'])) {
        require_once ('database/ChatUser.php');

        $user = new ChatUser();

        $user->setRegistrationEmail($_SESSION['user_data']['email']);

        $userData = $user->getUserByEmail();
        if (is_array($userData) && count($userData) > 0) {
            if (password_verify($_POST['opassword'], $userData['password'])) {
                if ($_POST['npassword'] !== $_POST['cnpassword']) {
                    $error = "Password and confirm password did not matched";
                } else if (password_verify($_POST['npassword'], $userData['password'])) {
                    $error = "New password must be different from old password";
                } else {
                    $user->setPassword($_POST['npassword']);
                    if ($user->resetPassword()) {
                        $success_message = "Password updated ! Enjoy your safe & secure chatting :)";
                    } else {
                        $error = "Error: " . $db->errorInfo()[2];
                    }
                }

            } else {
                $error = "You entered wrong password ! ";
            }
        } else {
            $error = "No user exist with this provided email id";
        }
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
</head>
<style>
    .alert-danger {
        color: red;
        font-size: 14px;
    }

    .alert-success {
        color: #104b1e;
        font-size: 14px;
    }
</style>

<script>
    function validateForm() {


        var password = document.getElementById('new-password').value;
        var confirmPassword = document.getElementById('cnew-password').value;

        console.log(password);
        // Validate password and confirm password match

        var passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        var errorMessage = "Password must contain at least one letter, one number, one special character, and be at least 8 characters long";

        // Check if password matches the regex
        var target = document.getElementById('newPasswordError');

        if (!passwordRegex.test(password)) {
            console.log("ghg");
            target.style.display = "inline";
            target.textContent = errorMessage;
            return false;
        } target.style.display = "none";
        console.log("ttt");

        var errorMessage = "Password and Confirm Password do not match";
        var target = document.getElementById('confError');
        if (password !== confirmPassword) {
            console.log("uuu");
            target.style.display = "inline";
            target.textContent = errorMessage;
            return false;
        } target.style.display = "none";

        return true;
    }
</script>

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
        <input type="hidden" id="login_user_id" name="login_user_id" value="<?php echo $user_obj['id'] ?>">
        <div class="content">
            <form method="POST" onsubmit="return validateForm()">
                <div class="user-details fileds">
                    <div class="input-box">
                        <span class="details">Old Password</span>
                        <input type="password" placeholder="Enter your old password" id="old-password" name="opassword"
                            required>

                    </div>
                    <div class="input-box">
                        <span class="details">New Password</span>
                        <input type="password" placeholder="Enter your new password" id="new-password" name="npassword"
                            required>
                        <div id="newPasswordError" class="error-message"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm New Password</span>
                        <input type="password" placeholder="Confirm your new password" id="cnew-password"
                            name="cnpassword" required>
                        <div id="confError" class="error-message"></div>
                    </div>
                </div>
                <div class="button btn">
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


    <script>
        function validateForm() {
            // event.preventDefault();

            var oldPassword = document.getElementById('old-password').value;
            var newPassword = document.getElementById('new-password').value;
            var confirmPassword = document.getElementById('cnew-password').value;


            // Validate password and confirm password match

            var passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            var errorMessage = "Password must contain at least one letter, one number, one special character, and be at least 8 characters long.";

            // Check if password matches the regex
            if (!passwordRegex.test(oldPassword)) {
                document.getElementById('oldPasswordError').textContent = errorMessage;
                return false;
            }

            if (!passwordRegex.test(newPassword)) {
                document.getElementById('newPasswordError').textContent = errorMessage;
                return false;
            }

            var errorMessage = "Password and Confirm Password do not match";
            if (newPassword !== confirmPassword) {
                document.getElementById('confError').textContent = errorMessage;
                return false;
            }

            return true;
        }

        
    </script>
    <script type="text/javascript" src="./js/script.js"> </script>


</body>

</html>