<?php
// Ensure any necessary session or database connections are included here

session_start(); // Ensure session is started if not already

if (isset($_SESSION['user_data'])) {
    $login_user_id = $_SESSION['user_data']['id'];
    require_once 'database/ChatUser.php';
    $chatuser = new ChatUser();
    $chatuser->setUserId($login_user_id);
    $user_data = $chatuser->getAllUsersDataWithStatus();

    // Prepare the HTML output for user list
    $user_html = '';
    foreach ($user_data as $user) {
        if ($user['user_id'] != $login_user_id) {
            $user_html .= "
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

    // Output the HTML
    echo $user_html;
} else {
    // Handle if user session data is not set
    echo 'Session data not found';
}
?>