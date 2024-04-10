<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Path to autoload.php from Composer
// Create a new PHPMailer instance
$mail = new PHPMailer(true);
// check request method is post and secrete key is set
if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_POST['secrete_key'])) {
    echo "Invalid request";
    exit;
} else {
    $secrete_key = $_POST['secrete_key'];
    // verify secrete key
    if ($secrete_key != "12345") {
        echo "Invalid secrete key";
        exit;
    } else {
        $subject=$_POST['subject'];
        $body=$_POST['body'];
        $toEmail=$_POST['toEmail'];
        $name=$_POST['name'];
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'viratsinghkaharwar8923@gmail.com'; // SMTP username
            $mail->Password   = 'ltuv kvim btss zgyo'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, 'ssl' also accepted
            $mail->Port       = 587; // TCP port to connect to
        
            // Sender and recipient details
            $mail->setFrom('viratsinghkaharwar8923@gmail.com', 'Bharat Temple Tourism');
            $mail->addAddress('svinnykumar02@gmail.com', $name);
        
            // Email content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = strip_tags($body);
        
            // Send email
            $mail->send();
            echo 'success';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}