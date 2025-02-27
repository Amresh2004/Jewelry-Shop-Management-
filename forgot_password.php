

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Forgot Password</title>
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
        <h2>Forgot Password</h2>
        <form action="send_otp.php" method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Enter your registered email" required>
            </div>
            <button type="submit" class="btn">Send Reset Link</button>
        </form>
    </div>
</body>
</html>
