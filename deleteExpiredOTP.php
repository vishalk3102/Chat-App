<?php
//deletion on unused otp file
function checkAndDeleteExpiredOtp() {
    $directory = 'C:/xampp/$temp~'; 

    
    foreach (glob($directory . '/*.dat') as $filename) {
       
        $content = file_get_contents($filename);
        $parts = explode(',', $content, 2); 
        $creationTime = (int) $parts[0];

        
        $expirationTime = 120;

        
        $deleteTime = $creationTime + $expirationTime;

        
        if (time() >= $deleteTime) {
            unlink($filename);
            echo "Deleted expired OTP file: $filename\n";
        }
    }
}
checkAndDeleteExpiredOtp();
?>