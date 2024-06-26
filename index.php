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
            <form action="#">
                <div class="user-details">
                  
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" placeholder="Enter your email" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="text" placeholder="Enter your password" required>
                    </div>
                   
                </div>
                <div class="button">
                    <input type="submit" value="Login">
                </div>
                <p> Forgot Password ! <a href="forgetPass.php">Click</a> </p>
                <div class="log">
                        New User !  
                        <a href="registration.php"> Register </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>