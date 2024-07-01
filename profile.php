<?php
session_start();
if (!isset($_SESSION['user_data'])) {
    header('location:index.php');
}

$user_obj = $_SESSION['user_data'];

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

    .button-box a {
        border: 2px solid black;
        border-radius: 5px;
        padding: 10px 16px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
        background-color: #030617;
        color: #fff;
        margin: 10px 5px;
        text-decoration: none;
    }


    .button-box a:hover {
        cursor: pointer;
    }


    /* RESPONSIVE CODE  */
    @media screen and (max-width: 768px) {
        .profile-card {
            width: 70%;
            flex-direction: column;
            padding: 0rem;
        }

        .left-side-box {
            margin: 1rem;
        }

        .right-side-box {
            display: flex;
            flex-direction: column;
            margin-left: 0rem;
            padding: 1rem;
        }

        h3 {
            font-size: 1rem;
        }

        p {
            font-size: 0.8rem;
        }

        .button-box a {
            padding: 10px 10px;
            font-size: 12px;
        }
    }

    @media screen and (min-width: 768px) and (max-width: 992px) {
        .profile-card {
            width: 90%;
            padding: 1rem;
            justify-content: center;
        }

        .left-side-box img {
            height: 200px;
            width: 250px;
        }

        .right-side-box {
            display: flex;
            flex-direction: column;
        }

        .button-box a {
            padding: 10px 10px;
            font-size: 12px;
        }

    }
</style>

<body>
    <section id="profile" class="container">

        <div class="profile-card">
            <div class="left-side-box">
                <img src="<?php echo $imageFolder . $user_obj['photo'] ?>" alt="avatar">
                <!-- <img src="./assets/avatar1.jpg" alt="avatar"> -->
            </div>
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

                    <a href="editProfile.php">
                        Edit Profile
                    </a>

                    <a href="changePassword.php">
                        Change Password
                    </a>

                    <a href="dashboard.php">
                        Let's Chat
                    </a>

                </div>
            </div>

        </div>
    </section>
</body>

</html>