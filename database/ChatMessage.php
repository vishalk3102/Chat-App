<?php
require_once 'DatabaseConnection.php';
class ChatMessage{

    private $message_id;
    private $sender_id;      // (Foreign Key referencing Users table)
    private $receiver_id;    // (Foreign Key referencing Users table for private messages)
    private $message;        // (Encrypted)
    private $timestamp;
    private $message_status;  //(“send” and “received”)   
    private $connection;

    public function _contruct()
    {
        $database = new DatabaseConnection();
        $this->connection = $database->connect();

    }

    public function setMessageId($message_id)
    {
        $this->message_id = $message_id;
    }
    public function getMessageId()
    {
        return $this->message_id;
    }
    public function setSenderId($sender_id)
    {
        $this->sender_id = $sender_id;
    }
    public function getSenderId()
    {
        return $this->sender_id;
    }
    public function setReceiverId($receiver_id)
    {
        $this->receiver_id = $receiver_id;
    }

    public function getReceiverId()
    {
            return $this->receiver_id;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }
            
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setMessageStatus($message_status)
    {
        $this->message_status = $message_status;
    }

    public function getMessageStatus()
    {
        return $this->message_status;
    }

    public function save_chat()
    {

    }

    public function fetch_chat()
    {

    }

    public function update_chat()
    {
        
    }

}
?>
