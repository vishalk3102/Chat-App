<?php
     session_start();
    
    $error ='';
    $success_message = '';
   
    if (!isset($_SESSION['user_data'])) {
        header('location:index.php');
    }

    $user_obj = $_SESSION['user_data'];
  

    if($_SERVER['REQUEST_METHOD'] == 'POST' ) 
    {
    
        require_once('database/ChatUser.php');

        $user = new ChatUser();

        $user->setUserId($user_obj['id']);
        if (empty($_POST['first_name'])) {
            $user->setfname($user_obj['fname']);
        } else {
            $user->setfname($_POST['first_name']);
        }
        // if (empty($_POST['middle_name'])) {
        //     $user->setmname($user_obj['mname']);
        // } else {
        //     $user->setmname($_POST['middle_name']);
        // }

        $user->setmname($_POST['middle_name']);
        
        if (empty($_POST['last_name'])) {
            $user->setlname($user_obj['lname']);
        } else {
            $user->setlname($_POST['last_name']);
        }
        
        if (empty($_POST['username'])) {
            $user->setUsername($user_obj['username']);
        } else {
            $user->setUsername($_POST['username']);
        }
        if (empty($_POST['photo'])) {
            $user->setPhoto($user_obj['photo']);
        } else {
            $user->setPhoto('avatar3');
        }

            if ($user->updateUser()) {
                $_SESSION['user_data']['fname']=$user->getfname();
                $_SESSION['user_data']['mname']=$user->getmname();
                $_SESSION['user_data']['lname']=$user->getlname();
                $_SESSION['user_data']['photo']=$user->getPhoto();
                $_SESSION['user_data']['username']=$user->getUsername();
                $success_message = "Profile Updated! :)";
            } else {
                $error =  "Error: " . $db->errorInfo()[2];
            }
        

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
        align-items: center;
        background-color: #fff;
        padding: 2rem;
    }

    .left-side-box {
        margin: 1rem;
    }

    .left-side-box img {
        border-radius: 10px;
        height: 250px;
        width: 300px;
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
        border: 1px solid black;
        margin: 10px;
        transition: border-color 0.3s ease;
    }
</style>

<body>
    <section id="profile" class="container">
        <div class="profile-card">
            <div class="left-side-box">
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
                <img src="./assets/avatar.png" alt="avatar">
                <div class="button-box">
                    <button>
                        <a href="editProfile.php">
                            Change Avatar
                        </a>
                    </button>
                </div>
                <div id="avatarModal" class="modal">
                    <div class="modal-content">
                        <h4>Select Your New Avatar</h4>
                        <div class="avatar-options">
                            <img src="./assets/avatar1.jpg" onclick="selectAvatar(this)" alt="Avatar 1"
                                class="avatar-option">
                            <img src="./assets/avatar2.jpg" onclick="selectAvatar(this)" alt="Avatar 2"
                                class="avatar-option">
                            <img src="./assets/avatar3.png" onclick="selectAvatar(this)" alt="Avatar 3"
                                class="avatar-option">
                            <img src="./assets/avatar4.jpg" onclick="selectAvatar(this)" alt="Avatar 4"
                                class="avatar-option">
                            <img src="./assets/avatar5.jpg" onclick="selectAvatar(this)" alt="Avatar 4"
                                class="avatar-option">
                            <img src="./assets/avatar6.png" onclick="selectAvatar(this)" alt="Avatar 4"
                                class="avatar-option">
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
                        <input type="text" placeholder="Enter if you want to change first name" name='first_name'>
                    </div>
                    <div class="input-box">
                        <span>Middle Name : </span>
                        <input type="text" placeholder="Enter your middle name" name='middle_name'>
                    </div>
                    <div class="input-box">
                        <span>Last Name : </span>
                        <input type="text" placeholder="Enter your last name" name='last_name'>
                    </div>
                    
                    <div class="input-box">
                        <span>Username : </span>
                        <input type="text" placeholder="Enter your user name" name='username'>
                    </div>
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
    </section>
</body>
<script>
    // Function to open the modal
    function openModal() {
        const modal = document.getElementById('avatarModal');
        modal.style.display = 'block';
    }

    // Function to select an avatar
    function selectAvatar(imgElement) {
        updateAvatarImage(imgElement.src);
    }

    // Function to close the modal
    function closeModal() {
        const modal = document.getElementById('avatarModal');
        modal.style.display = 'none';
    }

    // Function to update the avatar image
    function updateAvatarImage(src) {
        const avatarImage = document.querySelector('.left-side-box img');
        avatarImage.src = src;
        console.log('Selected Avatar:', src);
    }

    // Attach event listeners
    document.querySelector('.button-box').addEventListener('click', openModal);
    document.getElementById('closeBtn').addEventListener('click', closeModal);
    document.getElementById('saveBtn').addEventListener('click', () => {
        // Save logic here
        closeModal();
    });

</script>

</html>