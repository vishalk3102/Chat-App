<?php

    
    $error ='';
    $success_message = '';


    if($_SERVER['REQUEST_METHOD'] == 'POST' ) 
    {
        session_start();
        if(isset($_SESSION['user_data']))
        {
            header('location:profile.php');
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
                        <input type="text" placeholder="Enter your name" name="middle_name" id="middleName" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Last Name</span>
                        <input type="text" placeholder="Enter your name" name="last_name" id="lastName" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" placeholder="Enter your email" name="email" id="email" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="text" placeholder="Enter your password" name="password" id="password" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="text" placeholder="Confirm your password" name="cpassword" id="confirmPassword" required>
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
            if (!emailRegex.test(email)) {
                alert("Please enter a valid email address.");
                // $('.toast-body').html('Please enter a valid email address.');
                // $('.toast').toast('show');
                console.log("abcdefghijklmnopqrstuvwxyz");
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
</body>


</html>
