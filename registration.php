<?php


$error = '';
$success_message = '';

function validateEmail($email)
{
    $emailRegex = "/^[^\s@]+@([^\s@]+\.)?contata\.in$/i";
    return preg_match($emailRegex, $email);
}

function validatePassword($password)
{
    $passwordRegex = "/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    return preg_match($passwordRegex, $password);
}

function allFieldsFilled($data)
{
    return isset($data['first_name']) && isset($data['last_name']) &&
        isset($data['email']) && isset($data['password']) && isset($data['cpassword']);
}
function validateNameLength($name, $maxLength = 50) {
    return strlen($name) <= $maxLength;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    if (isset($_SESSION['user_data'])) {
        header('location:dashboard.php');
    }

    require_once ('database/ChatUser.php');
    if (!allFieldsFilled($_POST)) {
        $error = "All fields except middle name are required.";
    } elseif (!validateNameLength($_POST['first_name']) || !validateNameLength($_POST['middle_name']) || !validateNameLength($_POST['last_name'])) {
        $error = "First name, middle name, and last name must each be no more than 50 characters long.";
    } elseif (!validateEmail($_POST['email'])) {
        $error = "Invalid email format. Email must be a contata.in domain.";
    } elseif (!validatePassword($_POST['password'])) {
        $error = "Password must be at least 8 characters long and contain at least one letter, one number, and one special character.";
    } elseif ($_POST['password'] !== $_POST['cpassword']) {
        $error = "Passwords do not match.";
    } else {
        $user = new ChatUser();
        $user->setfname($_POST['first_name']);
        $user->setmname($_POST['middle_name']);
        $user->setlname($_POST['last_name']);
        $user->setRegistrationEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setUsername(explode('@', $_POST['email'])[0]);
        $user->setPasswordUpdateDate(date('Y-m-d H:i:s'));
        $user->setRegistrationDate(date('Y-m-d H:i:s'));
        $user->setPhoto('avatar.png');
        $user->setStatus('Inactive');
        $checkuser = $user->getUserByEmail();
        if (is_array($checkuser) && count($checkuser) > 0) {
            $error = "There already exist a user with this email";
        } else {
            if ($user->saveUser()) {
                $success_message = "Registration successful!";
            } else {
                $error = "Error: " . $db->errorInfo()[2];
            }
        }
    }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp - Registration</title>
    <link rel="stylesheet" href="style/style.css">

</head>
,<style>
.alert-danger{
  color: red ;
  font-size: 14px;
}
.
.alert-success{
  color: #104b1e;
  font-size: 14px;
}
</style>
<body>
    <div class="container reg-container">
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
        <div class="title">Registration</div>
        <div class="content">

            <form method="POST" onsubmit="return validateForm()">
                <div class="user-details fields">
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" placeholder="Enter your name" maxlength="50" name="first_name" id="firstName" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" placeholder="Enter your name" maxlength="50" name="middle_name" id="middleName">
                    </div>
                    <div class="input-box">
                        <span class="details">Last Name</span>
                        <input type="text" placeholder="Enter your name" maxlength="50" name="last_name" id="lastName" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" placeholder="Enter your email"  name="email" id="email" required>
                        <div id="emailError" style="display:inline" class="error-message"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" placeholder="Enter your password" maxlength="20" name="password" id="password" required>
                        <div id="passwordError" style="display:inline" class="error-message"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" placeholder="Confirm your password" maxlength="20" name="cpassword" id="confirmPassword"
                            required>
                        <div id="confError" style="display:inline" class="error-message"></div>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" id="registerBtn" value="Register">
                </div>
                <div class="log">
                    Already Registered ? <a href="index.php">Login</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            // var firstName = document.getElementById('firstName').value.trim();
            // var lastName = document.getElementById('lastName').value.trim();
            var email = document.getElementById('email').value.trim();
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;



            // Validate email format
            var emailRegex = /^[^\s@]+@([^\s@]+\.)?contata\.in$/i;
            var errorMessage = "Please enter a valid email address, like example@contata.in";

            var target = document.getElementById('emailError');
            if (!emailRegex.test(email)) {
                target.style.display = "inline";
                target.textContent = errorMessage;
                return false;
            } target.style.display = "none";

            // Validate password and confirm password match

            var passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            var errorMessage = "Password must contain at least one letter, one number, one special character, and be at least 8 characters long.";

            // Check if password matches the regex
            var target = document.getElementById('passwordError')
            if (!passwordRegex.test(password)) {
                target.style.display = "inline";
                target.textContent = errorMessage;
                return false;
            } target.style.display = "none";

            var errorMessage = "Password and Confirm Password do not match";

            var target = document.getElementById('confError')
            if (password !== confirmPassword) {
                target.style.display = "inline";
                target.textContent = errorMessage;
                return false;
            } target.style.display = "none";

            return true;
        }
    </script>
</body>


</html>