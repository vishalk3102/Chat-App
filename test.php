<?php

   $to = 'ayushk@contata.in';
   $subject = 'Hello from XAMPP!';
   $message = 'This is a PapercutSMTP test';
   $headers = "From: your@email-address.com\r\n";

   if (mail($to, $subject, $message, $headers)) {
      echo "SUCCESS";
   } else {
      echo "ERROR";
}