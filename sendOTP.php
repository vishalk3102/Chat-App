<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Generate OTP (you can adjust length and complexity as needed)
    $otp = mt_rand(100000, 999999); // 6-digit OTP

    // Store OTP in session for verification
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;

    // Email details
    $to = $email;
    $subject = 'Password Reset OTP';
    $message = 'Your OTP for password reset is: ' . $otp;
    $headers = 'From: hrishabh.2024cse1171@kiet.edu'; // Replace with your actual email address

    echo 'this is otp'. $otp ;
    
    // Send email using PHP's mail() function
    if (mail($to, $subject, $message, $headers)) {
        // Email sent successfully
        echo "Email sent successfully. Check your inbox for OTP.";
    } else {
        // Email sending failed
        echo "Failed to send email. Please try again.";
    }

    // Redirect to resetPassword.php (optional)
     header("Location: resetPassword.php");
     exit;
}
?>
