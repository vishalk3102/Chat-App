<?php

    
    $error ='';
    $success_message = '';


    if($_SERVER['REQUEST_METHOD'] == 'POST' ) 
    {
        session_start();
        if(isset($_SESSION['user_data']))
        {
            header('location:dashboard.php');
        }

        require_once('database/ChatUser.php');

        $user = new ChatUser();
        $user->setfname($_POST['first_name']);
        $user->setmname($_POST['middle_name']);
        $user->setlname($_POST['last_name']);
        $user->setRegistrationEmail($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->setUsername(explode('@', $_POST['email'])[0]);
        $user->setPasswordUpdateDate(date('Y-m-d H:i:s'));
        $user->setRegistrationDate(date('Y-m-d H:i:s'));
        $user->setPhoto('avtar1');
        $user->setStatus('Inactive');
        $checkuser = $user->getUserByEmail();
        if(is_array( $checkuser) && count($checkuser) > 0)
        {
            $error = "There already exist a user with this email";
        }
        else
        {
            if ($user->saveUser()) {
                $success_message = "Registration successful!";
            } else {
                $error =  "Error: " . $db->errorInfo()[2];
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

<body>
    <div class="container reg-container">
        <?php
            if($error != '')
            {
                echo '<div class="alert alert-danger" role="alert">
                '.$error.'
                </div>';
            }
            if($success_message != '')
            {
                echo '<div class="alert alert-success" role="alert">
                '.$success_message.'
                </div>';
            }
        ?>
        <div class="title">Registration</div>
        <div class="content">
            
        <form  method="POST"  onsubmit="return validateForm()">
                <div class="user-details fields">
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" placeholder="Enter your name" name="first_name" id="firstName" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" placeholder="Enter your name" name="middle_name" id="middleName" >
                    </div>
                    <div class="input-box">
                        <span class="details">Last Name</span>
                        <input type="text" placeholder="Enter your name" name="last_name" id="lastName" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" placeholder="Enter your email" name="email" id="email" required>
                        <div id="emailError" class="error-message"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" placeholder="Enter your password" name="password" id="password" required>
                        <div id="passwordError" class="error-message"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" placeholder="Confirm your password" name="cpassword" id="confirmPassword" required>
                        <div id="confError" class="error-message"></div>
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
            var firstName = document.getElementById('firstName').value.trim();
            var lastName = document.getElementById('lastName').value.trim();
            var email = document.getElementById('email').value.trim();
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('confirmPassword').value;

          
        
            // Validate email format
            var emailRegex = /^[^\s@]+@([^\s@]+\.)?contata\.in$/i;
            var errorMessage = "Please enter a valid email address";
            if (!emailRegex.test(email)) {
                document.getElementById('emailError').textContent = errorMessage;
                return false;
            }

            // Validate password and confirm password match
        
            var passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            var errorMessage = "Password must contain at least one letter, one number, one special character, and be at least 8 characters long.";

            // Check if password matches the regex
            if (!passwordRegex.test(password)) {
                document.getElementById('passwordError').textContent = errorMessage;
                return false;
            } 

            var errorMessage = "Password and Confirm Password do not match";
            if (password !== confirmPassword) {
                document.getElementById('confError').textContent = errorMessage;
                return false;
            }

            return true;
        }
    </script>
</body>


</html>
