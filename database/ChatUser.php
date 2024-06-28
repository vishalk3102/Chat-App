<?php
require_once 'DatabaseConnection.php';
class ChatUser
{
    private $user_id;
    private $fname;
    private $mname;
    private $lname;
    private $username;
    private $password;
    private $email;
    private $photo;
    private $registration_date;
    private $status;
    private $password_update_date;
    private $connection;

    public function __construct()
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
        // $this->password = $password;
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
        try {
            // calling INSERT_USER stored procedure
            $query = "CALL insert_user(:fname, :mname, :lname, :username, :password, :email, :photo, :registration_date, :status, :password_update_date)";
    
            $statement = $this->connection->prepare($query);

            $statement->bindParam(':fname', $this->fname);
            // $statement->bindParam(':mname', $this->mname, PDO::PARAM_NULL);
            if ($this->mname === '') {
                $statement->bindValue(':mname', null, PDO::PARAM_NULL);
            } else {
                $statement->bindParam(':mname', $this->mname, PDO::PARAM_STR);
            }
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
        try {
            $query = "CALL update_user_password(:email, :password)";
            $statement = $this->connection->prepare($query);
 
            $statement->bindParam(':email', $this->email);
            $statement->bindParam(':password', $this->password);
 
            $result = $statement->execute();
 
            return $result;
           
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }


    public function getUserByEmail()
    {
        try {
            $query = "CALL get_user_by_email(:email)";
            $statement = $this->connection->prepare($query);
            
            $statement->bindParam(':email', $this->email);
            
            $statement->execute();
            
            $user_data = $statement->fetch(PDO::FETCH_ASSOC);

            return $user_data;
            
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function updateUserLoginStatus()
    {
        try {
            $query = "CALL update_user_status(:user_id, :status)";
            $statement = $this->connection->prepare($query);

            $statement->bindParam(':user_id', $this->user_id);
            $statement->bindParam(':status', $this->status);

            $result = $statement->execute();

            return $result;
            
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
        return false;
    }


    public function getAllUsersDataWithStatus()
    {
        try {
            $query = "CALL get_all_users_data_with_status(:user_id)";
            $stmt = $this->connection->prepare($query);
            
            $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
            
            $stmt->execute();
            
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $data;
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }


}
?>