<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration</h2>
        <form action="signup.php" method="POST">
            <div class="input-group">
                <input type="email" name="email" placeholder="Enter your email" required>
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
