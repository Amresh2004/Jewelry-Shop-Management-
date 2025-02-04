<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    // Update password in the database
    $stmt = $pdo->prepare("UPDATE userss SET password = ?, otp = NULL, otp_expiry = NULL WHERE email = ?");
    $stmt->execute([$new_password, $email]);

    echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Billing Receipt</title>
    <style>
    body {
        background: rgba(0, 0, 0, 0.5) url('https://storage.googleapis.com/a1aa/image/b748eecf-3ee1-4a78-850f-b0b36d5f0f63.jpeg');
        background-size: cover;
        background-color: #f9f9f9;
    }
    .bill-container {
        max-width: 800px;
        margin: 250px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 5px 10px rgb(0, 0, 0);    
        box-shadow: 0px 0px 50px cyan,
        0px 0px 50px cyan inset;
        padding: 80px;
        text-align: center;
        border: 1px solid cyan;
        background-color: #ffffff86;
        font-size: larger;
        transition: transform 0.3s, background-color 0.3s;
    }
    .bill-container:hover {
        transform: scale(1.02);
        background-color:rgba(255, 255, 255, 0.32);
    }
    .bill-container h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    a {
        display: inline-block;
        padding: 10px 15px;
        margin: 5px;
        color: #fff;
        background-color: #007bff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    a:hover {
        background-color:rgb(3, 125, 255);
        box-shadow: 0 10px 20px cyan;
    }

    @media (max-width: 600px) {
        .bill-container {
            padding: 10px;
        }
        a {
            padding: 8px 12px;
        }
    }
    </style>
</head>
<body>
    <div class='bill-container'>
        <div style='background-color:rgb(212, 237, 218); color: #155724; padding: 20px; border: 1px solid #c3e6cb; border-radius: 5px; display: inline-block;'>
            Password reset successfully!
        </div>
        <br><br>
        <div class='btn'>
            <a href='index.php'>
                Login here
            </a>
        </div>
    </div>
</body>
</html>";
exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .password-toggle {
            cursor: pointer;
            margin-left: -25px;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
        }
        .input-group {
            position: relative;
            margin-bottom: 15px;
        }
        .container {
            background-color: #ffffff86;
            width: 800px;
            border-radius: 8px;
            box-shadow: 0px 0px 50px cyan, 0px 0px 50px cyan inset;
            padding: 80px;
            text-align: center;
            border: 1px solid cyan;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background: #fff;
            transition: border 0.1s ease-in-out, text-shadow 0.1s ease-in-out;
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
            position: relative;
        }
        .btn {
            background-color: #d49300;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #b77b00;
        }
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
        <h1>Reset Password</h1>
        <form action="reset_password.php" method="POST">
            <div class="input-group">
                <input type="hidden" name="email" value="<?= htmlspecialchars($_GET['email']) ?>">
                <input type="password" name="new_password" id="new_password" placeholder="Enter New Password" required>
                <span class="password-toggle" onclick="togglePassword('new_password')">👁</span>
            </div>
            <div class="input-group">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm New Password" required>
                <span class="password-toggle" onclick="togglePassword('confirm_password')">👁</span>
            </div>
            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>
    <script>
        // Function to toggle the password visibility
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>
