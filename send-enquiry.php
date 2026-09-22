<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure PHPMailer is installed via Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $container_type = htmlspecialchars($_POST['container_type']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // or your mail server
        $mail->SMTPAuth = true;
        $mail->Username = 'yourgmail@gmail.com'; // replace with your email
        $mail->Password = 'your_app_password';   // use Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender & recipient
        $mail->setFrom($email, $name);
        $mail->addAddress('yourcompany@example.com'); // replace with your receiving email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Enquiry: $subject";
        $mail->Body = "
            <h3>New Enquiry Received</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Container Type:</strong> $container_type</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong><br>$message</p>
        ";

        $mail->send();
        echo "Thank you, your enquiry has been sent!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
