<?php
require 'db_connection.php'; // Include your database connection
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    try {
        // Check if the email exists in the database
        $stmt = $pdo->prepare("SELECT id FROM userss WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user) {
            die("Email not found!");
        }

        // Generate OTP
        $otp = random_int(100000, 999999);
        $otp_expiry = date("Y-m-d H:i:s", strtotime("+15 minutes"));

        // Update OTP in the database
        $stmt = $pdo->prepare("UPDATE userss SET otp = ?, otp_expiry = ? WHERE email = ?");
        $stmt->execute([$otp, $otp_expiry, $email]);

        // Send OTP via email
        $mail = new PHPMailer(true);

        //Server settings
        $mail->isSMTP();                              //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;             //Enable SMTP authentication
        $mail->Username   = 'amreshwarad1234@gmail.com';   //SMTP write your email
        $mail->Password   = 'cetergprvgrucdrj';      //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
        $mail->Port       = 587;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  

        $mail->setFrom('amreshwarad1234@gmail.com', 'AW Jewellary Shop');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for Password Reset';
        $mail->Body = "<p>Your OTP is: <strong>$otp</strong>. It is valid for 15 minutes.</p>";

        $mail->send();
        echo "OTP sent to your email!";
        header("Location: verify_otp.php?email=" . urlencode($email));
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

