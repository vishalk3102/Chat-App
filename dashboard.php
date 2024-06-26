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
            background-color: red;
            border-radius: 50%;
            display: inline-block;
            margin-right: 2px;
            padding-top: 2px;
        }

        #green12 {
            background-color: green;
        }

        .active_user {
            background-color: #45FFCA;
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
<script>
    var chatInterval;
    let currentActiveUser = null;
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
                    window.alert("Fetch Error: " + error);
                });
        } else {
            console.warn("User ID not found");
        }

    }
    function make_chat_area(user_name, username, user_status, chatStarted, user_photo) {
        var status_style = `<span class='dot' id='red'></span>`;
        if (user_status == 'Active') {
            status_style = `<span class='dot' id='green12'></span>`;
        }
        var htmlcode = `
                    <div class="chat-navbar user-text-box">
                        <div class="profile">
                            <img src="`+ user_photo + `" alt="avatar">
                        </div>
                        <div class="text-box">
                            <p class="username-box">`+ user_name + `</p>
                            <p class="status-box">`+ username + `</p>
                            <p class="status-box">`+ status_style + user_status + `</p>

                        </div>
                    </div>
                    <div class="chat-content">
                        <div class="chat-text-box" id="message_text_box">
                            
                        </div>
                    </div>

                    <div class="chat-message-box">
                        <form method="POST" onsubmit="event.preventDefault(); handleMessage();">
                            <textarea  type="text" id="user_text_message" placeholder="Type a message..." maxLength="255"></textarea>
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

    function loadChat(element) {

        document.querySelectorAll('.user-text-box').forEach(userBox => {
            userBox.classList.remove('active_user');
        });
        element.classList.add('active_user');
        receiver_userid = element.getAttribute('data-user-id');
        var receiver_name = document.getElementById('list_user_name_' + receiver_userid).innerHTML;
        var receiver_username = document.getElementById('list_user_username_' + receiver_userid).innerHTML;
        var receiver_status = document.getElementById('list_user_status_' + receiver_userid).innerHTML;
        var user_photo = document.getElementById('selected_user_image_' + receiver_userid).src;
        make_chat_area(receiver_name, receiver_username, receiver_status, true, user_photo);


        if (window.innerWidth <= 768) {
            document.querySelector('.users-box').classList.add('hidden');
            document.querySelector('.chat-box').classList.add('active');
        }
        if (chatInterval) {
            clearInterval(chatInterval);
        }

        // console.log('Triggered');
        // Call loadChat immediately and then every 2 seconds
        fetchChat(receiver_userid);
        chatInterval = setInterval(() => fetchChat(receiver_userid), 2000);

    }

    // FUNCTION TO AUTO SCROLL MESSAGE TO BOTTOM 
    function scrollToBottom() {
        var chatBox = document.querySelector('.chat-text-box');
        if (chatBox) {
            const scrollHeight = chatBox.scrollHeight;
            const height = chatBox.clientHeight;
            const maxScrollTop = scrollHeight - height;

            // Smooth scroll to bottom
            chatBox.scrollTo({
                top: maxScrollTop,
                behavior: 'smooth'
            });

            // Double-check scroll position after animation
            setTimeout(() => {
                if (chatBox.scrollTop !== maxScrollTop) {
                    chatBox.scrollTop = maxScrollTop;
                }
            }, 300);
        }
    }

    function fetchChat(recUserId) {
        receiver_userid = recUserId
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
                // console.log("Response received: " + data);
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
                window.alert("Fetch Error: " + error);
                console.error("Fetch Error: " + error);
            });
    }

    function handleMessage() {

        var inputmsg = document.getElementById('user_text_message');
        var message = inputmsg.value.trim();
        if (receiver_userid == '') {
            window.alert('something went wrong');
            return;
        }
        else if (message === '') {
            window.alert('message must not be empty');
            return;
        }
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
                    setTimeout(scrollToBottom, 100);
                }

            })
            .catch(error => {
                console.error("Fetch Error: " + error);
            });
        inputmsg.value = '';
    }

    // function userStatus() {
    //     var xhr = new XMLHttpRequest();

    //     xhr.onreadystatechange = function () {
    //         if (xhr.readyState === XMLHttpRequest.DONE) {
    //             if (xhr.status === 200) {
    //                 document.getElementById('users-box').innerHTML = xhr.responseText;
    //             } else {
    //                 console.error('Error fetching user data:', xhr.status, xhr.statusText);
    //             }
    //         }
    //     };

    //     xhr.open('GET', 'fetchUsers.php', true);
    //     xhr.send();
    // }


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

    function updateUsers() {
        var userId = document.getElementById('login_user_id').value;

        fetch('action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'user_id': userId,
                'action': 'get_users',
            })
        })
            .then(response => response.json()) // Parse response as JSON
            .then(data => {
                //console.log("Response received: ", data);
                // Check if data is valid
                if (Array.isArray(data)) {
                    // Construct HTML for users
                    let userHTML = '';
                    document.getElementById('users-box').innerHTML = '';
                    data.forEach(user => {
                        var status_style = `<span class='dot' id='red'></span>`;
                        var isActive = "";
                        if (user.status == 'Active') {
                            status_style = `<span class='dot' id='green12'></span>`;
                        }
                        if (receiver_userid != '' && user.user_id == receiver_userid) {
                            isActive = " active_user";
                        }
                        var unread = user.count_status != 0 ? `<span class='badge'>` + user.count_status + `</span>` : ``;
                        userHTML = `<div class='user-text-box chat_triggered_class ${isActive}' id='chat11_user_${user.user_id}'  data-user-id='${user.user_id}' onclick='loadChat(this)'>
                                    <div class='profile'>
                                        <img src='${user.imagepath}${user.photo}' id='selected_user_image_${user.user_id}' alt='avatar'>
                                    </div>
                                    <div class='text-box'>
                                        <p class='username-box notification' id='list_user_username_${user.user_id}'>` + user.username + unread + `</p>
                                          <p class='status-box ' id='list_user_name_${user.user_id}'>` + user.fname + ` ` + user.lname + `</p>
                                          <p class='status-box ' >`+ status_style + ` ` + `<span id='list_user_status_${user.user_id}'>` + user.status + `</span></p>
                                          
                                    </div>
                                </div>`;
                        document.getElementById('users-box').innerHTML += userHTML;
                    });
                    // Update the users-box element
                } else {
                    console.error('Invalid data format received.');
                }
            })
            .catch(error => {
                console.error("Fetch Error:", error);
            });
    }


    // userStatus();
    updateUsers()
    setInterval(updateUsers, 3000);


</script>

</html>