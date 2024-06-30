<?php
session_start();
if (!isset($_SESSION['user_data'])) {
    header('location:index.php');
}

$user_obj = $_SESSION['user_data'];
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
        .notification {
            background-color: #555;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            position: relative;
            display: inline-block;
            border-radius: 2px;
        }

        .notification .badge {
            position: absolute;
            top: -10px;
            right: -10px;
            padding: 5px 10px;
            border-radius: 50%;
            background: red;
            color: white;
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

                    $imageFolder =$_ENV['imgpath'] ;
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
                        <img src="<?php echo $imageFolder.$user_obj['photo']?>" alt="avatar">
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
                                <div class='user-text-box chat_triggered_class' id='chat11_user'  data-userid = '" . $user['user_id'] . "' onclick='loadChat()'>
                                    <div class='profile'>
                                        <img src='./assets/avatar.png' alt='avatar'>
                                    </div>
                                    <div class='text-box'>
                                        <p class='username-box notification' id='list_user_name_" . $user['user_id'] . "'>" . $user['fname'] . ' ' . $user['lname'] . "
                                            ".($user['count_status'] != 0 ? "<span class='badge'>" . $user['count_status'] . "</span>":"")."   
                                        </p>
                                        <p class='status-box ' id='list_user_status_" . $user['user_id'] . "'>" . $user['status'] . "</p>
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
<script>
    var chatInterval;
    // VARIABLE FOR MAINTAINING VIEW STATUS FOR BACK BUTTON (MOBILE DEVICE)
    const VIEW_MODE_USER_LIST = 'user_list';
    const VIEW_MODE_CHAT = 'chat';
    let currentViewMode = VIEW_MODE_USER_LIST;


    var receiver_userid = '';
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
    function make_chat_area(user_name, user_status, chatStarted) {
        var htmlcode = `
                    <div class="chat-navbar user-text-box">
                        <div class="profile">
                            <img src="./assets/avatar.png" alt="avatar">
                        </div>
                        <div class="text-box">
                            <p class="username-box">`+ user_name + `</p>
                            <p class="status-box">`+ user_status + `</p>
                        </div>
                    </div>
                    <div class="chat-content">
                        <div class="chat-text-box" id="message_text_box">
                            
                        </div>
                    </div>

                    <div class="chat-message-box">
                        <form method="POST" onsubmit="event.preventDefault(); handleMessage();">
                            <textarea  type="text" id="user_text_message" placeholder="Type a message..."></textarea>
                            <button type="submit" ><span><i class="fa fa-send-o"></i></span></button>
                        </form>
                    </div>
                    
                </div>
        `;
        document.getElementById('chatpart').innerHTML = htmlcode;
        var backButton = document.getElementById('backButton');
        var screenWidth = window.innerWidth;
        if (chatStarted && screenWidth <= 768) {
            backButton.style.display = 'block';
        } else {
            backButton.style.display = 'none';
        }
    }

    function loadChat() {
        receiver_userid = document.getElementById('chat11_user').getAttribute('data-userid');
        var receiver_name = document.getElementById('list_user_name_' + receiver_userid).innerHTML;
        var receiver_status = document.getElementById('list_user_status_' + receiver_userid).innerHTML;
        make_chat_area(receiver_name, receiver_status, true);


        if (window.innerWidth <= 768) {
            document.querySelector('.users-box').classList.add('hidden');
            document.querySelector('.chat-box').classList.add('active');
        }
        if (chatInterval) {
            clearInterval(chatInterval);
        }

        console.log('Triggered');
        // Call loadChat immediately and then every 2 seconds
        fetchChat();
        chatInterval = setInterval(fetchChat, 2000);

    }

    // FUNCTION TO AUTO SCROLL MESSAGE TO BOTTOM 
    function scrollToBottom() {
        var chatBox = document.getElementById('message_text_box');
        if (chatBox) {
            console.log('Scrolling to bottom. ScrollHeight:', chatBox.scrollHeight);
            chatBox.scrollTop = chatBox.scrollHeight;
        } else {
            console.error('Chat box element not found');
        }
    }

    function fetchChat() {
        receiver_userid = document.getElementById('chat11_user').getAttribute('data-userid');
        var userId = document.getElementById('login_user_id').value;
        fetch('action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'to_user_id': receiver_userid,
                'from_user_id': userId,
                'action': 'fetch_chat',
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
                if (response.length > 0) {
                    var html_data = '';
                    for (var count = 0; count < response.length; count++) {
                        if (response[count].sender_id == userId) {
                            html_data += `<div class="sender-message">
                                <p>
                                    `+ response[count].message + `
                                </p>
                                <span>`+ response[count].timestamp + `</span>
                            </div>`
                        }
                        else {
                            html_data += `
                            <div class="receiver-message">
                                <p>
                                    `+ response[count].message + `
                                </p>
                                <span>`+ response[count].timestamp + `</span>
                            </div>
                            `
                        }

                    }
                    document.getElementById('message_text_box').innerHTML = html_data;
                    setTimeout(scrollToBottom, 100);
                }

            })
            .catch(error => {
                console.error("Fetch Error: " + error);
            });
    }

    function handleMessage() {

        var inputmsg = document.getElementById('user_text_message');
        var message = inputmsg.value.trim();
        var receiver_userid = document.getElementById('chat11_user').getAttribute('data-userid');
        var userId = document.getElementById('login_user_id').value;
        console.log(receiver_userid, userId);
        fetch('action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'to_user_id': receiver_userid,
                'from_user_id': userId,
                'message': message,
                'action': 'send_message',
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
                if (response && parseInt(response.status) > 0) {
                    var html_data = '';

                    html_data += `<div class="sender-message">
                        <p>
                            `+ message + `
                        </p>
                        <span>`+ response.timestamp + `</span>
                    </div>`

                    document.getElementById('message_text_box').innerHTML += html_data;
                    setTimeout(scrollToBottom, 2000);
                }

            })
            .catch(error => {
                console.error("Fetch Error: " + error);
            });
        inputmsg.value = '';
    }

    function userStatus() {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('users-box').innerHTML = xhr.responseText;
                } else {
                    console.error('Error fetching user data:', xhr.status, xhr.statusText);
                }
            }
        };

        xhr.open('GET', 'fetchUsers.php', true);
        xhr.send();
    }


    // FUNCTION TO HIDE USER-BOX (MOBILE DEVICE)
    function showUsersList() {
        document.querySelector('.users-box').classList.remove('hidden');
        document.querySelector('.chat-box').classList.remove('active');
    }



    // FUNCTION TO HANDLE BACK BUTTON  CLICK(MOBILE DEVICE)
    function backToUserPage() {
        currentViewMode = VIEW_MODE_USER_LIST;
        toggleBackButtonVisibility();
        showUsersList();
    }

    // FUNCTION TO HANDLE HIDE/SHOW OF BACK BUTTON (MOBILE DEVICE)
    function toggleBackButtonVisibility() {
        var backButton = document.getElementById('backButton');
        if (currentViewMode === VIEW_MODE_CHAT) {
            backButton.style.display = 'block';
        } else {
            backButton.style.display = 'none';
        }
    }


    // Initial check on page load
    toggleBackButtonVisibility();

    // Listen for visibility changes
    document.addEventListener('visibilitychange', toggleBackButtonVisibility);

    //         function updateUsers() {
    //             var userId = document.getElementById('login_user_id').value;

    //             fetch('action.php', {
    //                 method: 'POST',
    //                 headers: {
    //                     'Content-Type': 'application/x-www-form-urlencoded'
    //                 },
    //                 body: new URLSearchParams({
    //                     'user_id': userId,
    //                     'action': 'get_users',
    //                 })
    //             })
    //             .then(response => response.json()) // Parse response as JSON
    //             .then(data => {
    //                 console.log("Response received: ", data);
    //                 // Check if data is valid
    //                 if (Array.isArray(data)) {
    //                     // Construct HTML for users
    //                     let userHTML = '';
    //                     data.forEach(user => {
    //                         userHTML += `
    //                             <div class='user-text-box' data-userid='${user.user_id}' onclick='loadChat(${user.user_id}'>
    //                                 <div class='profile'>
    //                                     <img src='./assets/avatar.png' alt='avatar'>
    //                                 </div>
    //                                 <div class='text-box'>
    //                                     <p class='username-box' id='list_user_name_${user.user_id}'>${user.fname} ${user.lname}</p>
    //                                     <p class='status-box' id='list_user_status_${user.user_id}'>${user.status}</p>
    //                                 </div>
    //                             </div>
    //                         `;
    //                     });
    //                     // Update the users-box element
    //                     document.getElementById('users-box').innerHTML = userHTML;
    //                 } else {
    //                     console.error('Invalid data format received.');
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error("Fetch Error:", error);
    //             });
    // }


    userStatus();
    setInterval(userStatus, 3000);


</script>

</html>