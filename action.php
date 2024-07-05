<?php
session_start();
require 'bin\vendor\autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// $logFile = 'debug.log';

// file_put_contents($logFile, "Request received: " . print_r($_POST, true) . "\n", FILE_APPEND);

if (isset($_POST['action']) && $_POST['action'] == 'leave') {
    require ('database/ChatUser.php');
    $user = new ChatUser();
    $user->setUserId($_POST['user_id']);
    $user->setStatus("Inactive");
    if ($user->updateUserLoginStatus()) {
        unset($_SESSION['user_data']);
        session_destroy();

        $response = ['status' => 1];
    } else {
        $response = ['status' => 0, 'message' => 'Failed to update user status'];
    }
    echo json_encode($response);
}

if (isset($_POST["action"]) && $_POST["action"] == 'fetch_chat') {
    require 'database/ChatMessage.php';
    $chat_object = new ChatMessage();
    $chat_object->setSenderId($_POST["to_user_id"]);
    $chat_object->setReceiverId($_POST["from_user_id"]);
    $chat_object->change_chat_status();
    echo json_encode($chat_object->fetch_chat());
}

if (isset($_POST["action"]) && $_POST["action"] == "send_message") {
    require 'database/ChatMessage.php';
    $chat_object = new ChatMessage();
    $chat_object->setSenderId($_POST["from_user_id"]);
    $chat_object->setReceiverId($_POST["to_user_id"]);
    date_default_timezone_set("ASIA/KOLKATA");
    $chat_object->setTimestamp(date('Y-m-d H:i:s'));
    $chat_object->setMessageStatus('send');
    $chat_object->setMessage(htmlspecialchars($_POST["message"], ENT_QUOTES));
    $res = $chat_object->save_chat();
    $response = ["status" => $res, "timestamp" => $chat_object->getTimestamp()];
    echo json_encode($response);
}

if (isset($_POST["action"]) && $_POST["action"] == "get_users") {

    $user_id = $_POST["user_id"];
    require_once 'database/ChatUser.php';
    $chatuser = new ChatUser();
    $chatuser->setUserId($user_id);
    $user_data = $chatuser->getAllUsersDataWithStatus();
    $imageFolder = $_ENV['imgpath'];
    if (!$imageFolder) {
        die('IMAGE_FOLDER environment variable is not set.');
    }
    $redirect = false;
    $user_html = [];
    foreach ($user_data as $user) {

        if ($user['user_id'] != $user_id) {
            $user_html[] = [
                'user_id' => $user['user_id'],
                'fname' => $user['fname'],
                'lname' => $user['lname'],
                'status' => $user['status'],
                'username' => $user['username'],
                'photo' => $user['photo'],
                'count_status' => $user['count_status'],
                'imagepath' => $_ENV['imgpath'],
            ];
        } else {
            if ($user['status'] == 'Inactive') {
                $redirect = true; // Set flag to true for redirection
                $user_html[]= [
                    'redirect' => true,
                ];
                break; // No need to check further, we found the inactive user
            }
        }
    }
    if ($redirect) {
        unset($_SESSION['user_data']);
        session_destroy();
    }
    
    echo json_encode($user_html);

    

}

if(isset($_POST['action']) && $_POST["action"] == "check_user_status") {
    $user_id = $_POST["user_id"];
    require_once 'database/ChatUser.php';
    $chatuser = new ChatUser();
    $chatuser->setUserId($user_id);
    $user_data = $chatuser->getStatusWithUserId();
    if ($user_data[0]['status'] == 'Inactive') {
        unset($_SESSION['user_data']);
        session_destroy();
    }
    echo json_encode($user_data);
}

?>