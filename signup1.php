<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .password-toggle {
            cursor: pointer;
            margin-left: -25px;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        .input-group {
            position: relative;
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
        .link {
            margin-top: 15px;
            font-size: 14px;
            color: #777;
        }
        .link a {
            color: #d49300;
            text-decoration: none;
            font-weight: bold;
        }
        .link a:hover {
            text-decoration: underline;
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
        <h2>Registration</h2>
        <form action="signup.php" method="POST">
            <div class="input-group">
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <input type="text" name="phone" placeholder="Enter your phone number">
            </div>
            <div class="input-group">
                <input type="text" name="address" placeholder="Enter your address">
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Create a password" required>
                <span class="password-toggle" onclick="togglePassword('password')">👁</span>
            </div>
            <div class="input-group">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                <span class="password-toggle" onclick="togglePassword('confirm_password')">👁</span>
            </div>
            <button type="submit" name="btn" class="btn">Sign Up</button>
        </form>
        <div class="link">
            Already a member? <a href="index.php">Login</a>
        </div>
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
