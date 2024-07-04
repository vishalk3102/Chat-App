<?php
require 'bin\vendor\autoload.php';
require_once('database/ChatUser.php');
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use  PHPMailer\PHPMailer\SMTP;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Generate a random 6-digit OTP
function generateOTP() {
    return mt_rand(100000, 999999);
}


function sendOtp($email)
{
    try{

        $otp = generateOTP(); 
        
        //saving otp
        if(saveOtp($otp,$email))
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

//otp encryption 
function encryptData($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}
//otp decryption
function decryptData($data, $key) {
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

function generateJunkData($length = 20) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $max = strlen($characters) - 1; 
    $junkData = '';
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, $max); 
        $junkData .= $characters[$randomIndex]; 
    }

    return $junkData;
}

function saveOtp($otp,$email)
{
    
        $junkDataBefore = generateJunkData();
        $junkDataAfter = generateJunkData();
        
        $dataToEncrypt = $junkDataBefore . $otp . $junkDataAfter;
        $encryptedData = encryptData($dataToEncrypt, $_ENV["ENY_KEY"]);
        
        // $encryptedData = $otp;
        $directory = 'C:/xampp/$temp~'; //non-web-accessible directory
        if (!file_exists($directory)) {
            mkdir($directory, 0700, true); 
        }
        
        
        $filename = $directory . '/' . hash('sha256', $email) . '.dat';
        //$filename = $directory . '/' . $email . '.txt';
        
        if(file_exists($filename))
        {
            unlink($filename);
        }

        $creationTime = time();
        $dataToStore = $creationTime . ',' . $encryptedData;
    
        if (file_put_contents($filename, $dataToStore) !== false) {
            return true; 
        } else {
            return false;
        }
   

}


function checkOtp($otp,$email) {
    
    $directory = 'C:/xampp/$temp~';
    $filename = $directory . '/' . hash('sha256', $email) . '.dat';
    //$filename = $directory . '/' . $email . '.txt';
    if (!file_exists($filename)) {
        return false; 
    }

    // Read encrypted OTP data from file
    $content = file_get_contents($filename);
    $parts = explode(',', $content, 2); 
    $creationTime = (int) $parts[0];
    $encryptedData = $parts[1];

    
    $decryptedData = decryptData($encryptedData,$_ENV["ENY_KEY"]);

    if ($decryptedData !== false) {
    
        $junkDataBeforeLength = 20; 
        $otpLength = 6; 
        $extractedOtp = substr($decryptedData, $junkDataBeforeLength, $otpLength);

       
        if ($otp === $extractedOtp) {    
            $expirationTime = 120; 
            if (time() <= ($creationTime + $expirationTime)) {
                unlink($filename);
                return 2; 
            }
            else
            {
                return 1;
            }
    }

    return 0; 
}
}
?>