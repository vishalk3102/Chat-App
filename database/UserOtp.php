<?php
require_once 'DatabaseConnection.php';
class ChatUser
{
    private $otp;
    private $email;
    private $time;

    public function setOtp($otp)
    {
        $this->otp = $otp;
    }

    public function getOtp()
    {
         return $this->otp;
    }
    
    public function __construct()
    {
        $database = new DatabaseConnection();
        $this->connection = $database->connect();

    }

}