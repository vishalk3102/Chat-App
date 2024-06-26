<?php
require_once 'DatabaseConnection.php';
class ChatUser{
    private $user_id;
    private $fname ;
    private $mname ;
    private $lname;

    private $username;
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

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
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

    public function saveUser() {
        try {
            $query = "
                INSERT INTO `user` (fname, mname, lname, username, password, email, photo, registration_date, status, password_update_date) 
                VALUES (:fname, :mname, :lname, :username, :password, :email, :photo, :registration_date, :status, :password_update_date)
            ";
    
            $statement = $this->db->prepare($query);
    
            $statement->bindParam(':fname', $this->fname);
            $statement->bindParam(':mname', $this->mname, PDO::PARAM_NULL);
            $statement->bindParam(':lname', $this->lname);
            $statement->bindParam(':username', $this->username);
            $statement->bindParam(':password', $this->password);
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':photo', $this->photo);
            $statement->bindParam(':registration_date', $this->registration_date);
            $statement->bindParam(':status', $this->status);
            $statement->bindParam(':password_update_date', $this->password_update_date, PDO::PARAM_NULL);
    
            $result = $statement->execute();
    
            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    

    public function resetPassword()
    {

    }

    public function getUserByEmail()
    {
        $query = "
        SELECT * FROM User
        WHERE email = :email
        ";
 
        $statement = $this->connect->prepare($query);
 
        $statement->bindParam(':email', $this->email);
 
        if ($statement->execute()) {
            $user_data = $statement->fetch(PDO::FETCH_ASSOC);
        }
        return $user_data;
    }
}
?>