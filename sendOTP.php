<?php
require 'bin\vendor\autoload.php';
require_once('database/ChatUser.php');
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use  PHPMailer\PHPMailer\SMTP;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function generateOTP() {
    // Generate a random 6-digit OTP
    return mt_rand(100000, 999999);
}


function sendOtp($email)
{
    try{

        $otp = generateOTP(); // Generate OTP
        $user = new ChatUser();
        $success = $user->updateOTP(md5($otp), $email); 

        if($success)
        {
            $mail = new PHPMailer();
            // $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_SERVER'];     
            $mail->Port = $_ENV['MPORT'];  
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = true;
            $mail->setFrom($_ENV['sender_mail']);
            $mail->addAddress($email); 

            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Your OTP for verification';
            $mail->Body    = 'Your OTP is: ' . $otp;
    
        
           
            if(!$mail->send())
            {
                header('location:errorPage.php');   
            }
            else
            {
                header('location:resetPassword.php');   
            }

        }

        else {
            header('location:errorPage.php');
        }


    }

    catch(Exception $e)
    {
        header('location:errorPage.php');
    }
}
?>