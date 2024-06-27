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

    


    public function fetch_chat()
    {
        $query = "
        SELECT
            m.sender_id,
            m.receiver_id,
            CAST(AES_DECRYPT(m.message, 'contatadshfsk')AS CHAR) as message,
            m.timestamp,
            m.message_status,
            CONCAT(u1.fname, ' ', u1.lname) AS from_user_name,
            CONCAT(u2.fname, ' ', u2.lname) AS to_user_name
        FROM
            chatting m
        INNER JOIN
            user u1 ON m.sender_id = u1.user_id
        INNER JOIN
            user u2 ON m.receiver_id = u2.user_id
        WHERE
            (m.sender_id = :sender_id AND m.receiver_id = :receiver_id)
            OR
            (m.sender_id = :receiver_id AND m.receiver_id = :sender_id)
        ORDER BY
            m.timestamp ASC";
            $conn = new PDO("mysql:host=localhost;dbname=chatapp", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare( $query );
 
        $stmt->bindParam(':sender_id', $this->sender_id);
        $stmt->bindParam(':receiver_id', $this->receiver_id);
 
        $stmt->execute();
 
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
