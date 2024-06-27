<?php
session_start();
require 'bin\vendor\autoload.php';
// require_once('database/ChatUser.php');
// use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use  PHPMailer\PHPMailer\SMTP;

// require 'vendor/autoload.php';

// $dotenv = Dotenv::createImmutable(__DIR__);
// $dotenv->load();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    // $user = new ChatUser();

    // $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // if($user->isEmailExisted($email))
    // {
         sendOtp();
    // }
}


function generateOTP() {
    // Generate a random 6-digit OTP
    return mt_rand(100000, 999999);
}


function sendOtp()
{

            // $mail = new PHPMailer();
      
            // $mail->isSMTP();
            
            // $mail->Host = 'smtp.gmail.com';  // Specify SMTP server
            // $mail->SMTPAuth = true;
            // $mail->Username = 'harshzoro001@gmail.com'; // SMTP username
            // $mail->Password ='glblyiscdldiebmg'; // SMTP password
            
            // $mail->Port = 587;
            //   $mail->SMTPDebug = true;
            // $mail->SMTPSecure = 'tls';
            // // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            // //Recipients
            // $mail->setFrom('harshzoro001@gmail.com');
            // $mail->addAddress('harshgoku001@gmail.com'); // Add a recipient

            // // Content
            // // $otp = generateOTP(); // Function to generate OTP
            // $otp=123456;
            // $mail->isHTML(true); // Set email format to HTML
            // $mail->Subject = 'Your OTP for verification';
            // $mail->Body    = 'Your OTP is: ' . $otp;

            // $mail -> SMTPOptions = array('ssl'=>array(
            //     'verify_peer'=> false,
            //     'verify_peer_name'=> false,
            //     'allow_self_signed'=> false
            // ));
           
            // if(!$mail->send())
            // {
            //     echo $mail->ErrorInfo;
            // }
            // else
            // {
            //     echo 'sent';
            // }
        




// error_reporting(E_ALL);
// ini_set('display_errors', 1);
    $to = "harshgoku001@gmail.com";
    $subject = "Password Reset OTP";
    $message = "Your OTP for password reset is: xxxxxx ";
    $headers = "From:harshzoro001@gmail.com"; // Replace with your actual email address

//   //  echo 'this is otp'. $otp ;
    
//     // Send email using PHP's mail() function
//     if (mail($to, $subject, $message, $headers)) {
//         // Email sent successfully
//         echo "Email sent successfully. Check your inbox for OTP.";
//     } else {
//         // Email sending failed
//         echo "Failed to send email. Please try again.";
//     }

      
//         }


// Additional headers
// $headers = 'From: harshzoro001@gmail.com' . "\r\n" .
//            'Reply-To: harshgoku001@gmail.com' . "\r\n" .
//            'X-Mailer: PHP/' . phpversion();

// // Send email
if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully. Check your inbox.";
} else {
    echo "Failed to send email. Please try again.";
}

}
?>