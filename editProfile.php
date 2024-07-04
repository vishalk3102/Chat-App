<?php
session_start();

$error = '';
$success_message = '';

//checking already login logic
if (!isset($_SESSION['user_data'])) {
    header('location:index.php');
}

$user_obj = $_SESSION['user_data'];

//checking user required field
function allFieldsFilled($data)
{
    return isset($data['first_name']) && $data['first_name'] !== "" && isset($data['last_name']) && $data['last_name'] !== "" &&
        isset($data['username']) && $data['username'] !== "" && isset($data['avatar_src']) && $data['avatar_src'] !== "";
}

//validating name length
function validateNameLength($name, $maxLength = 50)
{
    return strlen($name) <= $maxLength;
}

//applying validation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once ('database/ChatUser.php');

    $user = new ChatUser();
    if (!allFieldsFilled($_POST)) {
        $error = "First Name, Last Name and Username are required Fields.";
    } elseif (!validateNameLength($_POST['first_name']) || !validateNameLength($_POST['middle_name']) || !validateNameLength($_POST['last_name'])) {
        $error = "First name, middle name, and last name must each be no more than 50 characters long.";
    } else {
        $user->setUserId($user_obj['id']);
        $user->setfname($_POST['first_name']);
        $user->setmname($_POST['middle_name']);
        $user->setlname($_POST['last_name']);
        $user->setUsername($_POST['username']);
        $user->setPhoto($_POST['avatar_src']);
        if ($user->updateUser()) {
            $_SESSION['user_data']['fname'] = $_POST['first_name'];
            $_SESSION['user_data']['mname'] = $_POST['middle_name'];
            $_SESSION['user_data']['lname'] = $_POST['last_name'];
            $_SESSION['user_data']['photo'] = $_POST['avatar_src'];
            $_SESSION['user_data']['username'] = $_POST['username'];
            $success_message = "Profile Updated! :)";
        } else {
            $error = "Error: " . $db->errorInfo()[2];
        }
    }

}

require 'bin\vendor\autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//validating path
$imageFolder = $_ENV['imgpath'];
if (!$imageFolder) {
    die('IMAGE_FOLDER environment variable is not set.');
}


?>


<!DOCTYPE html>
<html lang="en">
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #030617;
        height: 100vh;
        width: 100%;
    }

    .profile-card {
        width: 50%;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #fff;
        padding: 2rem;
    }

    .profile-card> :nth-child(2) {
        width: 100%;
        display: flex;
        flex-direction: row;
    }

    .toaster-box {
        width: 100%;
        text-align: center;
        padding: 5px 0px;
        margin-bottom: 1rem;
    }

    .left-side-box {
        margin: 1rem;
        height: 80%;
        width: 80%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .left-side-box img {
        border-radius: 10px;
        width: 80%;
    }

    .left-side-box .button-box {
        display: flex;
        justify-content: center;
    }

    .right-side-box {
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
        width: 100%;
    }

    .input-box {
        margin-bottom: 5px;
    }

    .input-box span {
        font-size: 14px;
        font-weight: 600;
    }

    .input-box input {
        font-size: 1rem;
        display: flex;
        align-items: center;
        padding: 5px;
        width: 100%;
        outline: none;
        border: 1px solid black;
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


    /* MODAL BOX STYLING  */
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

    .back-to-login a {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px 0px;
        text-decoration: none;
        color: #000;

    }

    .back-to-login a p {
        font-size: 14px;
        font-weight: 600;
    }

    .alert-success {
        color: #104b1e;
        font-size: 14px;
    }

    .alert-danger {
        color: red;
        font-size: 14px;
    }


    .toaster {
        position: fixed;
        top: 60px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #065e40;
        color: white;
        padding: 15px 32px;
        border-radius: 8px;
        display: none;
        z-index: 999;
    }

    /* RESPONSIVE CODE  */
    @media screen and (max-width: 768px) {
        .profile-card {
            width: 65%;
            display: flex;
            padding: 1rem
        }

        .profile-card> :nth-child(2) {
            width: 100%;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .left-side-box {
            margin: 0rem;
            width: 80%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .left-side-box img {
            width: 80%;
        }

        .right-side-box {
            margin-left: 0rem;
        }

        .input-box span {
            font-size: 12px;
        }

        .input-box input {
            font-size: 14px;
        }

        .button-box {
            margin-top: 0rem;
        }

        .button-box button {
            padding: 10px 10px;
            font-size: 12px;
            margin: 10px 5px;
        }

        .right-side-box .button-box {
            display: flex;
            justify-content: center;
        }

        .modal {
            width: 400px;
        }

    }

    @media screen and (min-width: 768px) and (max-width: 992px) {
        .profile-card {
            width: 90%;
            /* flex-direction: column; */
        }

        .input-box span {
            font-size: 12px;
        }

        .input-box input {
            font-size: 14px;
        }

        .modal {
            width: 400px;
        }

    }

    @media screen and (min-width: 992px) and (max-width: 1200px) {
        .profile-card {
            width: 90%;
            /* flex-direction: column; */
        }

        .input-box span {
            font-size: 12px;
        }

        .input-box input {
            font-size: 14px;
        }

        .modal {
            width: 400px;
        }

    }
</style>

<body>
    <div id="toaster" class="toaster"></div>
    <section id="profile" class="container">
        <input type="hidden" id="login_user_id" name="login_user_id" value="<?php echo $user_obj['id'] ?>">
        <div class="profile-card">
            <div class="toaster-box">
                <?php
                // if ($error != '') {
                //     echo '<p class=" alert alert-danger" role="alert">
                // ' . $error . '
                // </p>';
                // }
                // if ($success_message != '') {
                //     echo '<p class="alert alert-success" role="alert">
                // ' . $success_message . '
                // </p>';
                // }
                ?>
            </div>
            <div class="">
                <div class="left-side-box">
                    <img src="<?php echo $imageFolder . $_SESSION['user_data']['photo'] ?>" alt="avatar">
                    <div class="button-box">
                        <button>
                            <a>
                                Change Avatar
                            </a>
                        </button>
                    </div>
                    <div id="avatarModal" class="modal">
                        <div class="modal-content">
                            <h4>Select Your New Avatar</h4>
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
                                <button id="closeBtn">Close</button>
                                <button id="saveBtn">Save</button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="right-side-box">

                    <form method="POST">
                        <div class="input-box">
                            <span>Email : </span>
                            <input type="text" placeholder="<?php echo $user_obj['email'] ?>" disabled>
                        </div>

                        <div class="input-box">
                            <span>First Name : </span>
                            <input type="text" value="<?php echo $_SESSION['user_data']['fname'] ?>" name='first_name'>
                        </div>
                        <div class="input-box">
                            <span>Middle Name : </span>
                            <input type="text" value="<?php echo $_SESSION['user_data']['mname'] ?>" name='middle_name'>
                        </div>
                        <div class="input-box">
                            <span>Last Name : </span>
                            <input type="text" value="<?php echo $_SESSION['user_data']['lname'] ?>" name='last_name'>
                        </div>

                        <div class="input-box">
                            <span>Username : </span>
                            <input type="text" value="<?php echo $_SESSION['user_data']['username'] ?>" name='username'>
                        </div>

                        <input type="hidden" id="avatar_src" name="avatar_src"
                            value="<?php echo $_SESSION['user_data']['photo'] ?>">

                        <div class="button-box">
                            <button id="change-avatar-btn" type="submit">
                                Update Profile
                            </button>
                        </div>
                    </form>

                    <div class="back-to-login">
                        <a href="profile.php">
                            <p>Back to Profile</p>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>
</body>
<script>
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
        const avatarImage = document.querySelector('.left-side-box img');

        avatarImage.src = src; // Assign new src

        var filename = src.substring(src.lastIndexOf('/') + 1);
        var avatarSrcInput = document.getElementById('avatar_src');
        avatarSrcInput.value = filename;
    }

    // Attach event listeners
    document.querySelector('.button-box').addEventListener('click', openModal);
    document.getElementById('closeBtn').addEventListener('click', closeModal);
    document.getElementById('saveBtn').addEventListener('click', () => {
        if (tempSelectedAvatar) {
            updateAvatarImage(tempSelectedAvatar)
        }
        closeModal();
    });

    // Toaster Message
    <?php if ($success_message != '' || $error != ''): ?>
        var toaster = document.getElementById('toaster');
        toaster.textContent = "<?php echo $success_message != '' ? $success_message : $error; ?>";
        toaster.style.backgroundColor = "<?php echo $success_message != '' ? '#065e40' : '#f44336'; ?>"; // Green for success, red for error

        toaster.style.display = "block";

        setTimeout(function () {
            toaster.style.display = "none"; // Redirect after 2 seconds

        }, 2000);
    <?php endif; ?>

</script>
<script type="text/javascript" src="./js/script.js"> </script>

</html>