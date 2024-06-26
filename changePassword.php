<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password recovery</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <div class="container log-container">
        <div class="title">Password recovery</div>
        <div class="content">
            <form action="#">
                <div class="user-details fileds">
                    <div class="input-box">
                        <span class="details">Old Password</span>
                        <input type="text" placeholder="Enter your old password" name="old-password" required>
                    </div>
                    <div class="input-box">
                        <span class="details">New Password</span>
                        <input type="text" placeholder="Enter your new password" name="new-password" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm New Password</span>
                        <input type="text" placeholder="Confirm your new password" name="confirm-new-password" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="Submit">
                </div>

            </form>
        </div>
    </div>
</body>

</html>