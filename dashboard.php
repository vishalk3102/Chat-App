<?php
session_start();
if (!isset($_SESSION['user_data'])) {
    header('location:index.php');
}
$_SESSION['last_activity'] = time();
$user_obj = $_SESSION['user_data'];

$session_timeout = 3 * 60; 

// Check if session is expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_timeout) {
    require_once 'database/ChatUser.php';
    $chatuser = new ChatUser();
    session_unset();    // unset all session variables
    session_destroy();  // destroy session data in storage
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/dashboard.css">
    <style>
        .notification .badge {
            border-radius: 50%;
            background: red;
            color: white;
            font-size: 10px;
            color: #fff;
            background-color: #030617;
            display: inline-block;
            height: 16px;
            width: 16px;
            text-align: center;
            vertical-align: center;
            margin-left: 6px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dot {
            height: 10px;
            width: 10px;
            background-color: #e79023;
            border-radius: 50%;
            display: inline-block;
            margin-right: 2px;
            padding-top: 2px;
        }

        #green12 {
            background-color: #10B982;
        }

        .active_user {
            background-color: #4e61c7;
            color: #fff;
        }

        .sender-message p {
            display: flex;
            flex-direction: column;
            font-size: 14px;
        }

        .sender-message p span:nth-child(1) {
            font-size: 14px;
        }

        .message_status_show {
            margin-left: 94%;
            bottom: 0;
            height: 8px;
            width: 16px;
            padding: 2px;

        }
    </style>
</head>

<body>
    <section id="dashboard">
        <div class="container">
            <div class="navbar">
                <h1 class="logo">ChatApp</h1>
                <?php

                require 'bin\vendor\autoload.php';

                $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
                $dotenv->load();

                $imageFolder = $_ENV['imgpath'];
                if (!$imageFolder) {
                    die('IMAGE_FOLDER environment variable is not set.');
                }


                $login_user_id = $user_obj['id'];
                require_once 'database/ChatUser.php';
                $chatuser = new ChatUser();
                $chatuser->setUserId($login_user_id);
                $user_data = $chatuser->getAllUsersDataWithStatus();

                ?>
                <div class="profile">
                    <p>
                        <a href="profile.php">
                            <?php echo $user_obj['username'] ?>
                        </a>
                    </p>
                    <span>
                        <img src="<?php echo $imageFolder . $user_obj['photo'] ?>" alt="avatar">
                    </span>
                    <input type="hidden" id="login_user_id" name="login_user_id" value="<?php echo $login_user_id ?>">
                    <div class="dropdown-content">
                        <a href="profile.php">Profile</a>
                        <a id="logout" onclick="logoutUser()">Logout</a>
                    </div>
                </div>

            </div>
            <div class="user-chat-box">
                <div class="users-box" id="users-box">
                    <?php

                    foreach ($user_data as $key => $user) {
                        if ($user['user_id'] != $login_user_id) {
                            echo "
                                <div class='user-text-box chat_triggered_class' id='chat11_user_" . $user['user_id'] . "'  data-user-id='" . $user['user_id'] . "' onclick='loadChat(this)'>
                                    <div class='profile'>
                                        <img src='" . $imageFolder . $user['photo'] . "' id='selected_user_image_" . $user['user_id'] . "' alt='avatar'>
                                    </div>
                                    <div class='text-box'>
                                        <p class='username-box notification' id='list_user_username_" . $user['user_id'] . "'>" . $user['username'] . "
                                            " . ($user['count_status'] != 0 ? "<span class='badge'>" . $user['count_status'] . "</span>" : "") . "   
                                        </p>
                                          <p class='status-box ' id='list_user_name_" . $user['user_id'] . "'>" . $user['fname'] . ' ' . $user['lname'] . "</p>
                                          <p class='status-box ' >" . ($user['status'] === 'Active' ? "<span class='dot' id='green12'></span>" : "<span class='dot' id='red'></span>") . "<span id='list_user_status_" . $user['user_id'] . "'>" . $user['status'] . "</span> </p>
                                          
                                    </div>
                                </div>
                                
                            ";
                        }

                    }
                    ?>

                </div>
                <div class="chat-box" id="chatpart">

                </div>
            </div>
            <div class="back-button" id="backButton">
                <button onclick="backToUserPage()">
                    <i class="fa fa-arrow-left"></i>
                    <span>
                        Back
                    </span>
                </button>
            </div>
        </div>
    </section>
</body>

<script type="text/javascript" src="./js/logout.js"> </script>
<script type="text/javascript" src="./js/dashboard.js"> </script>

<!-- <script type="text/javascript" src="./js/session.js"></script> -->
</html>