<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Login</title>
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
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f9f9f9;
    background: rgba(0, 0, 0, 0.5) url('https://storage.googleapis.com/a1aa/image/b748eecf-3ee1-4a78-850f-b0b36d5f0f63.jpeg');
}


.container {
    background-color: #ffffff86;
    width: 800px;
    border-radius: 8px;
    box-shadow: 0px 0px 50px cyan,
    0px 0px 50px cyan inset;
    padding: 80px;
    text-align: center;
    border: 1px solid cyan;

}

h1, h2 {
    margin-bottom: 20px;
    color: #333;
}

.input-group {
    margin-bottom: 15px;
    text-align: left;
    position: relative;
}

.input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
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
.input-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    background: #fff;
    transition: border 0.1000s ease-in-out, text-shadow 0.10000s ease-in-out; /* Transition for border and text-shadow */
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
        <h1>Login</h1>
        <form action="login.php" method="POST">
        <div class="input-group">
                <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Enter a password" required>
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