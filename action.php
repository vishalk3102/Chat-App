<?php
session_start();

// $logFile = 'debug.log';

// file_put_contents($logFile, "Request received: " . print_r($_POST, true) . "\n", FILE_APPEND);

if (isset($_POST['action']) && $_POST['action'] == 'leave') {
    require('database/ChatUser.php');
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

// file_put_contents($logFile, "Response: " . print_r($response, true) . "\n", FILE_APPEND);
if(isset($_POST["action"]) && $_POST["action"] == 'fetch_chat')
{
    require 'database/ChatMessage.php';
    $chat_object = new ChatMessage();
    $chat_object->setSenderId($_POST["to_user_id"]);
    $chat_object->setReceiverId($_POST["from_user_id"]);
    // $private_chat_object->change_chat_status();
    echo json_encode($chat_object->fetch_chat());
}

if(isset($_POST["action"]) && $_POST["action"] == "send_message")
{
    require 'database/ChatMessage.php';
    $chat_object = new ChatMessage();
    $chat_object->setSenderId($_POST["from_user_id"]);
    $chat_object->setReceiverId($_POST["to_user_id"]);
    $chat_object->setTimestamp(date('Y-m-d H:i:s'));
    $chat_object->setMessageStatus('send');
    $chat_object->setMessage($_POST["message"]);
    $res = $chat_object->save_chat();
    $response = ["status"=> $res,"timestamp"=> $chat_object->getTimestamp()];
    echo json_encode($response);
}

?>
