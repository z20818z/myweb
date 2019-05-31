<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


mb_internal_encoding('UTF-8');

//Load composer's autoloader
require 'vendor/autoload.php';
function sendmail($title){
$mail = new PHPMailer(true);// Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();       // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = 'z20818z@gmail.com';    // SMTP username
    $mail->Password = '0981619741';    // SMTP password
    $mail->SMTPSecure = 'ssl';   // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;  // TCP port to connect to
    //Recipients
    $mail->setFrom('z20818z@gmail.com', 'Shop admin');
    $mail->addAddress('s10655017@gm2.nutn.edu.tw', 'Terry');     // Add a recipient

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = "行程通知";
    $mail->Body    = $title.'通知';

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
}
?>