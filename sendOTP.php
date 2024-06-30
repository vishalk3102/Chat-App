<?php
session_start();
require 'bin\vendor\autoload.php';
require_once('database/ChatUser.php');
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use  PHPMailer\PHPMailer\SMTP;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $user = new ChatUser();
        $user->setRegistrationEmail($_POST['email']);
        $user_data = $user->getUserByEmail();
        if(is_array( $user_data) && count($user_data) > 0)
        {
            sendOtp($_POST['email']);
        }
        else
        {
            echo 'error';
        }
}


function generateOTP() {
    // Generate a random 6-digit OTP
    return mt_rand(100000, 999999);
}


function sendOtp($email)
{
    try{
        $mail = new PHPMailer();
      
        $mail->isSMTP();
        
        $mail->Host = 'smtp.office365.com';  
        $mail->SMTPAuth = false;
        // $mail->Username = $_ENV['sender_mail']; 
        // $mail->Password = $_ENV['password'];    
        $mail->Port = 993;
        $mail->SMTPDebug = true;
       // $mail->SMTPSecure = 'smtp';
      
        $mail->setFrom($_ENV['sender_mail']);
        $mail->addAddress('nikhilgautam@contata.in'); 

        // Content
        $otp = generateOTP(); // Function to generate OTP

        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Your OTP for verification';
        $mail->Body    = 'Your OTP is: ' . $otp;

        // $mail -> SMTPOptions = array('ssl'=>array(
        //     'verify_peer'=> false,
        //     'verify_peer_name'=> false,
        //     'allow_self_signed'=> false
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

    catch(Exception $e)
    {
        echo 'error $e';
    }

           
        
            //     $to = "harshs@contata.in";
            //     $subject = "Password Reset OTP";
            //     $message = "Your OTP for password reset is: xxxxxx ";
            //     $headers = "From: harshzoro001@gmail.com"; // Replace with your actual email address
            // // // Send email
            // if (mail($to, $subject, $message, $headers)) {
            //     echo "Email sent successfully to $to. Check your inbox.";
            // } else {
            //     echo "Failed to send email. Please try again.";
            // }

}
?>