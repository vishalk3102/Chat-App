<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/dashboard.css">
</head>
<!-- <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    #dashboard {
        width: 100%;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #030617;
    }

    .container {
        border-radius: 10px;
        width: 70%;
        background-color: #ebeef3;
        color: #000;
    }

    /* NAVBAR STYLING  */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        /* border: 2px solid blue; */
        border-bottom: 1px solid black;
    }

    .navbar .logo {
        font-size: 1.2rem;
        font-weight: 700;
    }

    .navbar .profile {
        font-size: 1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
    }

    .navbar .profile p {
        font-size: 14px;
        font-weight: 700;
        padding-right: 6px;
    }

    .navbar .profile p a {
        text-decoration: none;
        color: #000;
    }

    .navbar .profile p:hover {
        cursor: pointer;
    }

    .navbar .profile span {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .navbar .profile span img {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        border: 1px solid black;
    }

    /* USER SECTION STYLING  */

    /* USER SIDE STYLING(LEFT) */
    .user-chat-box {
        display: flex;
        height: 100%;
        margin: 0px 5px 5px 5px;
    }

    .users-box {
        height: 100%;
        width: 30%;
        background-color: #ebeef3;
        padding: 12px;
    }

    .user-text-box {
        background-color: #fff;
        color: #000;
        border-radius: 6px;
        display: flex;
        padding: 5px 0px;
        margin-bottom: 6px;
    }

    .user-text-box .profile {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 5px 5px 5px 10px;
    }

    .user-text-box .profile img {
        border: 1px solid black;
        border-radius: 50%;
        height: 50px;
        width: 50px;
    }

    .user-text-box .text-box {
        margin-left: 8px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .user-text-box .text-box .username-box {
        font-size: 14px;
        font-weight: 600;
    }

    .user-text-box .text-box .status-box {
        font-size: 12px;
    }

    /* CHAT SIDE STYLING(RIGHT)  */
    .chat-box {
        border-left: 1px solid black;
        width: 70%;
        background-color: #ebeef3;
        display: flex;
        flex-direction: column;
    }

    .chat-navbar {
        border-bottom: 1px solid black;
        border-radius: 0%;
    }

    .chat-navbar .profile img {
        height: 30px;
        width: 30px;
    }

    .chat-content {
        flex-grow: 1;
        overflow: auto;
        max-height: 500px;
    }

    .chat-text-box {
        flex-grow: 1;
        overflow-y: auto;
        padding: 10px;
    }

    .chat-text-box .receiver-message {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .chat-text-box .sender-message {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .chat-text-box .receiver-message p,
    .sender-message p {
        border-radius: 5px;
        width: 40%;
        padding: 10px;
        margin: 10px 5px 2px 5px;
    }

    .chat-text-box .receiver-message span,
    .sender-message span {
        font-size: 12px;
    }

    .chat-text-box .receiver-message p {
        background-color: #030617;
        color: #fff;
    }

    .chat-text-box .sender-message p {
        background-color: #fff;
        color: #000;
    }

    .chat-text-box .receiver-message span {
        margin-left: 6px;
    }

    .chat-text-box .sender-message span {
        margin-right: 6px;
    }

    .chat-message-box {
        border-radius: 5px;
        height: 3rem;
        display: flex;
        align-items: center;
        margin: 5px;
    }

    .chat-message-box input {
        background-color: transparent;
        border: none;
        border-radius: 5px;
        height: 100%;
        width: 100%;
        outline: none;
        background-color: #fff;
        color: #000;
        font-size: 16px;
        padding: 4px 8px;
    }

    .chat-message-box span {
        background-color: #030617;
        border-radius: 5px;
        border-start-start-radius: 0px;
        border-end-start-radius: 0px;
        height: 100%;
        display: flex;
        align-items: center;
        padding: 10px 15px;
    }

    .chat-message-box span i {
        font-size: 22px;
        color: #fff;
    }
</style> -->

<body>
    <section id="dashboard">
        <div class="container">
            <div class="navbar">
                <h1 class="logo">ChatApp</h1>
                <div class="profile">
                    <p>
                        <a href="profile.php">
                            Vishalk3102
                        </a>
                    </p>
                    <span>
                        <img src="./assets/avatar.png" alt="avatar">
                    </span>
                    <div class="dropdown-content">
                        <a href="profile.php">Profile</a>
                        <a href="#">Logout</a>
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
</script>

</html>