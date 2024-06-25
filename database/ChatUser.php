<?php
require_once 'DatabaseConnection.php';
class ChatUser{
    private $user_id;
    private $fname ;
    private $mname ;
    private $lname;
    private $password;
    private $email ;
    private $photo ;
    private $registration_date ;
    private $status ;
    private $password_update_date;
    private $connection;

    public function _contruct()
    {
        $database = new DatabaseConnection();
        $this->connection = $database->connect();

    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setfname($fname)
    {
        $this->fname = $fname;
    }
    public function getfname()
    {
        return $this->fname;
    }
    public function setmname($mname)
    {
        $this->mname = $mname;
    }
    public function getmname()
    {
        return $this->mname;
    }
    public function setlname($lname)
    {
        $this->lname = $lname;
    }
    public function getlname()
    {
        return $this->lname;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setRegistrationDate($registration_date)
    {
        $this->registration_date = $registration_date;
    }
    public function getRegistrationDate()
    {
        return $this->registration_date;
    }
    public function setRegistrationEmail($email)
    {
        $this->email = $email;
    }
    public function getRegistrationEmail()
    {
        return $this->email;
    }
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }
    public function getPhoto()
    {
        return $this->photo;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setPasswordUpdateDate($password_update_date)
    {
        $this->password_update_date = $password_update_date;
    }
    public function getPasswordUpdateDate()
    {
        return $this->password_update_date;
    }

    public function saveUser()
    {

    }

    public function resetPassword()
    {
        
    }

}
?>