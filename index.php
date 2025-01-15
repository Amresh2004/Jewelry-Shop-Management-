<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .password-toggle {
            cursor: pointer;
            margin-left: -25px;
            position: relative;
        }
        .input-group {
            position: relative;
        }
        .input-group input {
            width: 100%;
        }
        .forgot-password {
            margin-top: 10px;
            text-align: right;
        }
        .forgot-password a {
            color: red;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <span class="password-toggle" onclick="togglePassword('password')">👁</span>
            </div>
            <div class="forgot-password">
                <a href="forgot_password.php">Forgot Password?</a>
            </div>
            <button type="submit" name="btn" class="btn">Login</button>
        </form>
        <div class="link">
            Not a member? <a href="signup1.php">Sign Up</a>
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
