<?php
require_once 'DatabaseConnection.php';
class ChatMessage
{

    private $message_id;
    private $sender_id;      // (Foreign Key referencing Users table)
    private $receiver_id;    // (Foreign Key referencing Users table for private messages)
    private $message;        // (Encrypted)
    private $timestamp;
    private $message_status;  //(“send” and “received”)   
    private $connection;

    public function __construct()
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
        try {
            $query = "CALL insert_chat_message(:sender_id, :receiver_id, :message, :timestamp, :message_status)";
            $stmt = $this->connection->prepare($query);
 
            $stmt->bindParam(':sender_id', $this->sender_id);
            $stmt->bindParam(':receiver_id', $this->receiver_id);
            $stmt->bindParam(':message', $this->message);
            $stmt->bindParam(':timestamp', $this->timestamp);
            $stmt->bindParam(':message_status', $this->message_status);
 
            $stmt->execute();
   
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['chat_id'];
 
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function fetch_chat()
    {
        try {
            $stmt = $this->connection->prepare("CALL fetch_chat_messages(:sender_id, :receiver_id)");
   
            $stmt->bindParam(':sender_id', $this->sender_id);
            $stmt->bindParam(':receiver_id', $this->receiver_id);
 
            $stmt->execute();
   
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



}

?>