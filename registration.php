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
function validateNameLength($name, $maxLength = 50)
{
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
        date_default_timezone_set("ASIA/KOLKATA");
        $user->setPasswordUpdateDate(date('Y-m-d H:i:s'));
        $user->setRegistrationDate(date('Y-m-d H:i:s'));
        $user->setPhoto('avatar.png');
        $user->setStatus('Inactive');
        $checkuser = $user->getUserByEmail();
        if (is_array($checkuser) && count($checkuser) > 0) {
            $error = "There already exist a user with this email";
        } else {
            if ($user->saveUser()) {
                $success_message = "Registration successful! Now you can login.";
                //  header('location:index.php?Message='.$success_message.'');   
            } else {
                $error = "Error: " . $db->errorInfo()[2];
            }
        }
    }

}


require 'bin\vendor\autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$imageFolder = $_ENV['imgpath'];
if (!$imageFolder) {
    die('IMAGE_FOLDER environment variable is not set.');
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
<style>
    .avatar-box button {
        height: 45px;
        width: 100%;
        outline: none;
        font-size: 16px;
        border-radius: 5px;
        padding-left: 15px;
        border: 1px solid #ccc;
        border-bottom-width: 2px;
        transition: all 0.3s ease;
        margin-top: 1rem;

    }

    .image-box {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-box img {
        width: 30%;
        border-radius: 10px;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 500px;
        max-height: 80vh;
        overflow-y: auto;
        background-color: #ebeef3;
        padding: 1rem;
        border-radius: 10px;
    }

    .modal h4 {
        font-size: 1.2rem;
        text-align: center;
        padding: 5px;
        margin: 1rem 0px;
    }

    .avatar-options {
        display: flex;
        justify-content: space-evenly;
        flex-wrap: wrap;
    }

    .avatar-options .avatar-option {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        cursor: pointer;
        border: 1px solid transparent;
        margin: 10px;
        transition: border-color 0.3s ease;
    }

    .avatar-options .avatar-option.selected {
        border: 3px solid #EE4E4E;
    }

    .button-box {
        margin-top: 1rem;
    }

    .button-box button {
        border: 2px solid black;
        border-radius: 5px;
        padding: 10px 16px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        background-color: #030617;
        color: #fff;
        margin: 10px 5px;
    }

    .button-box button a {
        color: #fff;
        text-decoration: none;
    }

    .button-box button:hover {
        cursor: pointer;
    }



    /* RESPONSIVE CODE  */
    @media screen and (max-width: 768px) {

        .container {
            padding: 15px 25px;
        }

        .content form .user-details {
            margin: 16px 0px 0px 0px;
        }

        .reg-container form .user-details .input-box {
            /* border: 2px solid red; */
            margin-bottom: 5px;
        }

        .user-details .input-box input {
            height: 40px;
        }

        .modal {
            width: 400px;
        }

    }
</style>

<body>
    <div id="toaster" class="toaster"></div>
    <div class="container reg-container">
        <?php
        if ($error != '') {
            echo '<div class="alert alert-danger" role="alert">
                ' . $error . '
                </div>';
        }
        ?>
        <div class="title">Registration</div>
        <div class="content">

            <form method="POST" onsubmit="return validateForm()">
                <div class="user-details fields">
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" placeholder="Enter your first name" maxlength="50" name="first_name"
                            id="firstName" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Middle Name</span>
                        <input type="text" placeholder="Enter your middle name" maxlength="50" name="middle_name"
                            id="middleName">
                    </div>
                    <div class="input-box">
                        <span class="details">Last Name</span>
                        <input type="text" placeholder="Enter your last name" maxlength="50" name="last_name"
                            id="lastName" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="text" placeholder="Enter your email" name="email" id="email" required
                            onchange="updateUsernameFromEmail()">
                        <div id="emailError" style="display: inline" class="error-message"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Password</span>
                        <input type="password" placeholder="Enter your password" maxlength="20" name="password"
                            id="password" required>
                        <div id="passwordError" style="display:inline" class="error-message"></div>
                    </div>
                    <div class="input-box">
                        <span class="details">Confirm Password</span>
                        <input type="password" placeholder="Confirm your password" maxlength="20" name="cpassword"
                            id="confirmPassword" required>
                        <div id="confError" style="display:inline" class="error-message"></div>
                    </div>
                    <div class="input-box" style="width:100%">
                        <span class="details">Username*</span>
                        <input type="text" placeholder="Enter your username" maxlength="50" name="username"
                            id="username">
                    </div>
                    <div class="input-box avatar-box" style="width:100%">
                        <span class="details">Avatar</span>
                        <div class="image-box">
                            <img src="./assets/avatar1.jpg" alt="avatar">
                        </div>
                        <button type="button" id="openAvatarModal">Select Avatar</button>
                        <input type="hidden" id="avatar_src" name="avatar_src" value="default_avatar.jpg">
                    </div>
                    <div id="avatarModal" class="modal">
                        <div class="modal-content">
                            <h4>Select Your Avatar</h4>
                            <div class="avatar-options">
                                <img src="<?php echo $imageFolder . 'avatar1.jpg' ?>" onclick="selectAvatar(this)"
                                    alt="Avatar 1" class="avatar-option">
                                <img src="<?php echo $imageFolder . 'avatar2.jpg' ?>" onclick="selectAvatar(this)"
                                    alt="Avatar 2" class="avatar-option">
                                <img src="<?php echo $imageFolder . 'avatar3.jpg' ?>" onclick="selectAvatar(this)"
                                    alt="Avatar 3" class="avatar-option">
                                <img src="<?php echo $imageFolder . 'avatar4.jpg' ?>" onclick="selectAvatar(this)"
                                    alt="Avatar 4" class="avatar-option">
                                <img src="<?php echo $imageFolder . 'avatar5.jpg' ?>" onclick="selectAvatar(this)"
                                    alt="Avatar 5" class="avatar-option">
                                <img src="<?php echo $imageFolder . 'avatar6.png' ?>" onclick="selectAvatar(this)"
                                    alt="Avatar 6" class="avatar-option">
                            </div>
                            <div class="modal-footer button-box">
                                <button type="button" id="closeBtn">Close</button>
                                <button type="button" id="saveBtn">Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="button" style="margin:0px">
                    <input type="submit" id="registerBtn" value="Register">
                </div>
                <div class="log">
                    Already Registered ? <a href="index.php">Login</a>
                </div>
            </form>
        </div>
    </div>


    <script>

        // Function to update username field based on email
        function updateUsernameFromEmail() {
            var email = document.getElementById('email').value.trim();
            var usernameField = document.getElementById('username');

            // Extract username part from email before '@'
            var atIndex = email.indexOf('@');
            var username = (atIndex !== -1) ? email.substring(0, atIndex) : email;

            // Update username field
            usernameField.value = username;
        }

        // Function to open the modal
        function openModal() {
            const modal = document.getElementById('avatarModal');
            modal.style.display = 'block';
        }

        let tempSelectedAvatar = null;

        // Function to select an avatar
        function selectAvatar(imgElement) {
            document.querySelectorAll('.avatar-option').forEach(img => {
                img.classList.remove('selected');
            });

            // Add 'selected' class to the clicked avatar
            imgElement.classList.add('selected');
            tempSelectedAvatar = imgElement.src;
        }

        // Function to close the modal
        function closeModal() {
            const modal = document.getElementById('avatarModal');
            modal.style.display = 'none';
            tempSelectedAvatar = null;
        }

        // Function to update the avatar image
        function updateAvatarImage(src) {
            const avatarImage = document.querySelector('.image-box img');
            avatarImage.src = src; // Assign new src
            var filename = src.substring(src.lastIndexOf('/') + 1);
            var avatarSrcInput = document.getElementById('avatar_src');
            avatarSrcInput.value = filename;
            const openModalBtn = document.getElementById('openAvatarModal');
            openModalBtn.textContent = 'Avatar Selected';
        }

        // Attach event listeners
        document.querySelector('#openAvatarModal').addEventListener('click', openModal);
        document.getElementById('closeBtn').addEventListener('click', closeModal);
        document.getElementById('saveBtn').addEventListener('click', () => {
            if (tempSelectedAvatar) {
                updateAvatarImage(tempSelectedAvatar)
            }
            closeModal();
        });


        // FUNCTION TO VALIDATE FORM 
        function validateForm() {

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

        // Toater Message and Redirect
        <?php if ($success_message != ''): ?>
            var toaster = document.getElementById('toaster');
            toaster.textContent = "<?php echo $success_message; ?>";
            toaster.style.display = "block";

            setTimeout(function () {
                window.location.href = "index.php"; // Redirect after 2 seconds

            }, 2000);
        <?php endif; ?>

    </script>
</body>


</html>