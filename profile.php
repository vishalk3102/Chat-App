<?php
session_start();
if (!isset($_SESSION['user_data'])) {
    header('location:index.php');
}

$user_obj = $_SESSION['user_data'];
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
        /* border: 2px solid red; */
        /* width: 40%; */
        border-radius: 10px;
        display: flex;
        align-items: center;
        background-color: #fff;
        padding: 2rem;
    }

    .left-side-box {
        /* border: 2px solid red; */
        margin: 1rem;
    }

    .left-side-box img {
        /* border: 2px solid red; */
        border-radius: 10px;
        height: 250px;
        width: 300px;
    }

    .right-side-box {
        /* border: 2px solid red; */
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
    }

    .text-box {
        /* border: 2px solid red; */
        display: flex;
    }

    h3 {
        font-size: 1.2rem;
        font-weight: 700;
        padding: 5px;
    }

    p {
        font-size: 1rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        padding: 5px;
    }

    .button-box {
        /* border: 2px solid black; */
        margin-top: 1rem;
        display: flex;
        justify-content: center;
        align-items: center;
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

    
    @media (max-width: 459px) {
        .profile-card {
       
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        padding: 2rem;
    }
    }
</style>

<body>
    <section id="profile" class="container">

        <div class="profile-card">
            <div class="left-side-box"><img src="./assets/avatar.png" alt="avatar"></div>
            <div class="right-side-box">
                <div class="text-box">
                    <h3 class="">Full Name :</h3>
                    <p class="">
                        <?php echo $user_obj['fname'] . ' ' . $user_obj['mname'] . ' ' . $user_obj['lname']; ?>
                    </p>
                </div>
                <div class="text-box">
                    <h3 class="">Username :</h3>
                    <p class="">
                            <?php echo $user_obj['username'] ?>
                    </p>
                </div>
                <div class="text-box">
                    <h3 class="">Email :</h3>
                    <p class="">
                        <?php echo $user_obj['email'] ?>
                    </p>
                </div>

                <div class="button-box">
                    <button>
                        <a href="editProfile.php">
                            Edit Profile
                        </a>
                    </button>
                    <button>
                        <a href="changePassword.php">
                            Change Password
                        </a>
                    </button>
                    <button>
                        <a href="dashboard.php">
                            Let's Chat
                        </a>
                    </button>
                </div>
            </div>

        </div>
    </section>
</body>

</html>