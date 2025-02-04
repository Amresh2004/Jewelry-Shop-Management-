<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    // Verify OTP
    $stmt = $pdo->prepare("SELECT otp, otp_expiry FROM userss WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || $user['otp'] != $otp || strtotime($user['otp_expiry']) < time()) {
        die("Invalid or expired OTP!");
    }

    // Redirect to reset password page
    header("Location: reset_password.php?email=" . urlencode($email));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<h
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .input-group input:focus,
    .input-group textarea:focus {
      border-color: cyan;
      box-shadow: 0 0 8px cyan;
      outline: none;
    }
    </style>
</head>
<body>
    <div class="container">
    <h1>Verify OTP</h1>
    <form action="verify_otp.php" method="POST">
        <div class="input-group">
        <input type="hidden" name="email"  value="<?= htmlspecialchars($_GET['email']) ?>">
        <input type="text" name="otp" id="otp" placeholder="Enter OTP: " required>
        </div>
        <button type="submit" class="btn">Verify</button>
    </form>
    </div>
</body>
</html>
