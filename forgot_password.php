<?php
include 'db_connection.php';  // Include your database connection

// Use PHPMailer classes from the vendor directory
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ensure PHPMailer is autoloaded via Composer


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit();
    }

    // Check if the email exists in the database
    $stmt = $pdo->prepare("SELECT id FROM userss WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Save the token to the database with an expiry time
        $stmt = $pdo->prepare("UPDATE userss SET reset_token = :token, token_expiry = NOW() + INTERVAL '1 hour' WHERE email = :email");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Generate the reset link
        $resetLink = "http://yourwebsite.com/reset_password.php?token=" . $token;

        // Set up PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@gmail.com'; // Your Gmail address
            $mail->Password = 'your-email-password'; // Your Gmail password or app-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('your-email@gmail.com', 'Password Reset');  // From address
            $mail->addAddress($email);  // Add recipient's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click this link to reset your password: <a href='$resetLink'>$resetLink</a>";

            // Send the email
            $mail->send();
            echo "<script>alert('Password reset link has been sent to your email.'); window.location.href = 'index.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.history.back();</script>";
        }

        exit();
    } else {
        echo "<script>alert('Email not found.'); window.history.back();</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="forgot_password.php" method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Enter your registered email" required>
            </div>
            <button type="submit" class="btn">Send Reset Link</button>
        </form>
    </div>
</body>
</html>
