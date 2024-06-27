<?php
session_start();
if (!isset($_SESSION['user_data'])) {
    header('location:index.php');
}

$user_data = $_SESSION['user_data'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/dashboard.css">
</head>

<body>
    <section id="dashboard">
        <div class="container">
            <div class="navbar">
                <h1 class="logo">ChatApp</h1>
                <?php

                $login_user_id = $user_data['id'];
                ?>
                <div class="profile">
                    <p>
                        <a href="profile.php">
                            <?php echo $user_data['username'] ?>
                        </a>
                    </p>
                    <span>
                        <img src="./assets/avatar.png" alt="avatar">
                    </span>
                    <input type="hidden" id="login_user_id" name="login_user_id" value="<?php echo $login_user_id ?>">
                    <div class="dropdown-content">
                        <a href="profile.php">Profile</a>
                        <a id="logout" onclick="logoutUser()">Logout</a>
                    </div>
                </div>

            </div>
            <div class="user-chat-box">
                <div class="users-box">
                    <div class="user-text-box">
                        <div class="profile">
                            <img src="./assets/avatar.png" alt="avatar">
                        </div>
                        <div class="text-box">
                            <p class="username-box">Vishal Kumar</p>
                            <p class="status-box">Active</p>
                        </div>
                    </div>
                    <div class="user-text-box">
                        <div class="profile">
                            <img src="./assets/avatar.png" alt="avatar">
                        </div>
                        <div class="text-box">
                            <p class="username-box">Vishal Kumar</p>
                            <p class="status-box">Active</p>
                        </div>
                    </div>
                    <div class="user-text-box">
                        <div class="profile">
                            <img src="./assets/avatar.png" alt="avatar">
                        </div>
                        <div class="text-box">
                            <p class="username-box">Vishal Kumar</p>
                            <p class="status-box">Active</p>
                        </div>
                    </div>
                    <div class="user-text-box">
                        <div class="profile">
                            <img src="./assets/avatar.png" alt="avatar">
                        </div>
                        <div class="text-box">
                            <p class="username-box">Vishal Kumar</p>
                            <p class="status-box">Active</p>
                        </div>
                    </div>
                    <div class="user-text-box">
                        <div class="profile">
                            <img src="./assets/avatar.png" alt="avatar">
                        </div>
                        <div class="text-box">
                            <p class="username-box">Vishal Kumar</p>
                            <p class="status-box">Active</p>
                        </div>
                    </div>
                </div>
                <div class="chat-box">
                    <div class="chat-navbar user-text-box">
                        <div class="profile">
                            <img src="./assets/avatar.png" alt="avatar">
                        </div>
                        <div class="text-box">
                            <p class="username-box">Vishal Kumar</p>
                            <p class="status-box">Active</p>
                        </div>
                    </div>
                    <div class="chat-content">
                        <div class="chat-text-box">
                            <div class="receiver-message">
                                <p>
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                </p>
                                <span>12:49 pm</span>
                            </div>
                            <div class="sender-message">
                                <p>
                                    Fine
                                </p>
                                <span>12:49 pm</span>
                            </div>
                        </div>
                        <div class="chat-text-box">
                            <div class="receiver-message">
                                <p>
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                </p>
                                <span>12:49 pm</span>
                            </div>
                            <div class="sender-message">
                                <p>
                                    Fine
                                </p>
                                <span>12:49 pm</span>
                            </div>
                        </div>
                        <div class="chat-text-box">
                            <div class="receiver-message">
                                <p>
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                </p>
                                <span>12:49 pm</span>
                            </div>
                            <div class="sender-message">
                                <p>
                                    Fine
                                </p>
                                <span>12:49 pm</span>
                            </div>
                        </div>
                        <div class="chat-text-box">
                            <div class="receiver-message">
                                <p>
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                </p>
                                <span>12:49 pm</span>
                            </div>
                            <div class="sender-message">
                                <p>
                                    Fine
                                </p>
                                <span>12:49 pm</span>
                            </div>
                        </div>
                        <div class="chat-text-box">
                            <div class="receiver-message">
                                <p>
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                </p>
                                <span>12:49 pm</span>
                            </div>
                            <div class="sender-message">
                                <p>
                                    Fine
                                </p>
                                <span>12:49 pm</span>
                            </div>
                        </div>
                        <div class="chat-text-box">
                            <div class="receiver-message">
                                <p>
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                </p>
                                <span>12:49 pm</span>
                            </div>
                            <div class="sender-message">
                                <p>
                                    Fine
                                </p>
                                <span>12:49 pm</span>
                            </div>
                        </div>
                        <div class="chat-text-box">
                            <div class="receiver-message">
                                <p>
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                </p>
                                <span>12:49 pm</span>
                            </div>
                            <div class="sender-message">
                                <p>
                                    Fine
                                </p>
                                <span>12:49 pm</span>
                            </div>
                        </div>
                        <div class="chat-text-box">
                            <div class="receiver-message">
                                <p>
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                    hii how are you
                                </p>
                                <span>12:49 pm</span>
                            </div>
                            <div class="sender-message">
                                <p>
                                    Fine
                                </p>
                                <span>12:49 pm</span>
                            </div>
                        </div>
                    </div>

                    <div class="chat-message-box">
                        <input type="text" placeholder="Type a message...">
                        <span><i class="fa fa-send-o"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const profileIcon = document.querySelector('.profile span');
        const dropdownContent = document.querySelector('.dropdown-content');

        function toggleDropdown(event) {
            event.stopPropagation();
            dropdownContent.classList.toggle('show');
        }

        function closeDropdown(event) {
            if (!profileIcon.contains(event.target) && dropdownContent.classList.contains('show')) {
                dropdownContent.classList.remove('show');
            }
        }

        profileIcon.addEventListener('click', toggleDropdown);
        document.addEventListener('click', closeDropdown);



    });
    function logoutUser() {
        var userId = document.getElementById("login_user_id").value;
        console.log(userId);
        if (userId) {
            fetch('action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'user_id': userId,
                    'action': 'leave'
                })
            })
                .then(response => response.text())
                .then(data => {
                    console.log("Response received: " + data);
                    let response;
                    try {
                        response = JSON.parse(data);
                    } catch (e) {
                        console.log("Failed to parse JSON response: " + e);
                        return;
                    }

                    if (response.status == 1) {
                        console.log("Logout successful, redirecting...");
                        location.href = "index.php";
                    } else {
                        console.log("Logout failed");
                    }
                })
                .catch(error => {
                    console.error("Fetch Error: " + error);
                });
        } else {
            console.warn("User ID not found");
        }

    }
</script>

</html>