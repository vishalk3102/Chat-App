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
        $success = $user->updateOTP($otp, $email); 

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
    
            // $mail->SMTPDebug = true;
            // $mail->SMTPSecure = 'tls';
           // $mail->Username = $_ENV['sender_mail']; 
            // $mail->Password = ""; 


            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Your OTP for verification';
            $mail->Body    = 'Your OTP is: ' . $otp;
    
            // $mail -> SMTPOptions = array('ssl'=>array(
            //     'verify_peer'=> false,
            //     'verify_peer_name'=> false,
            //     'allow_self_signed'=> true
            // ));
           
            if(!$mail->send())
            {
                echo $mail->ErrorInfo;
            }
            else
            {
                header('location:resetPassword.php');   
                // echo 'sent';
            }

        }

        else {
            echo 'Error saving OTP to database.';
        }


    }

    catch(Exception $e)
    {
        echo 'error $e';
    }
}
?>