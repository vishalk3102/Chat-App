<?php
session_start();
$error = '';
if (isset($_SESSION['user_data']))
{
    header('location:profile.php');
} 

if(isset($_POST['email'],$_POST['password']))
{
    require_once('database/ChatUser.php');
    $user = new ChatUser();
    $user->setRegistrationEmail($_POST['email']);
    $user_data = $user->getUserByEmail();
    if(is_array( $user_data) && count($user_data) > 0)
    {
        if(password_verify($_POST['password'],$user_data['password']))
        {
            $user->setUserId($user_data['user_id']);
            $user->setStatus('Active');
            if($user->UpdateUserLoginStatus())
            {
                $_SESSION['user_data'] = [
                    'id'=> $user_data['user_id'],
                    'fname'=> $user_data['fname'],
                    'mname'=> $user_data['mname'],
                    'lname'=> $user_data['lname'],
                    'photo'=> $user_data['photo'],
                    'email' => $user_data['email'],
                    'username' => $user_data['username'],
                ];
                header('location:profile.php');
            }
        }
        else
        {
            $error='Wrong credentials try with valid credentials';
        }

    }
    else
    {
        $error= 'User does not exist with this email please sign in';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-page</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<div class="container log-container">
        <div class="title">Login</div>
        <div class="content">
            <form method="POST">
                <div class="user-details">
                    <?php
                      if($error != '')
                      {
                        echo '<div class="alert alert-danger>
                        '.$error.'</div>
                        ';
                      }
                      ?>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" name="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="text" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                   
                </div>
                <div class="button">
                    <input type="submit" value="Login">
                </div>
                
                <div class="log">
                        <p> Forgot Password ? <a  href="forgetPass.php">Click</a> </p>
                        New User !  
                        <a href="registration.php"> Register </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>