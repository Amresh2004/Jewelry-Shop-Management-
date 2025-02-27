<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: rgba(0, 0, 0, 0.5) url('https://storage.googleapis.com/a1aa/image/b748eecf-3ee1-4a78-850f-b0b36d5f0f63.jpeg');
            background-size: cover;
            background-position: center;
            padding-top: 80px;
        }

        .settings-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            margin-top: 80px
        }

        .settings-container h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        .settings-container form {
            margin-top: 20px;
        }

        .settings-container .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .settings-container .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .settings-container .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .settings-container .btn {
            background: #d49300;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .settings-container .btn:hover {
            background: #b77b00;
        }
        .user-menu {
    position: absolute;
    top: 60px; /* Adjust based on your nav height */
    right: 20px; /* Align with the user-details */
    background: rgba(0, 0, 0, 0.8);
    color: #fff;
    border-radius: 10px;
    padding: 10px;
    width: 200px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    transform: translateY(-20px) scale(0); /* Hidden by default */
    transform-origin: top right; /* Animation starts from top right */
    transition: transform 0.3s ease, opacity 0.3s ease;
    opacity: 0;
    visibility: hidden;
}

.user-menu.active {
    transform: translateY(10px) scale(1); /* Slide down and scale up when active */
    opacity: 5;
    visibility: visible;
}

.user-menu ul {
    list-style: none;
    padding: 10px; /* Adds padding inside the menu */
    margin: 0;
}

.user-menu ul li {
    margin: 15px 0; /* Spacing between items */
   
}

.user-menu ul li a {
    color: cyan;
    text-decoration: none;
    font-size: 13px; /* Adjusted font size for visibility */
    padding: 5px 10px; /* Adds internal spacing to links */
    display: inline-block;
    width: 50%; /* Makes the links full width */
    transition: color 0.3s ease, transform 0.3s ease;
}

.user-menu ul li a:hover {
    color: #ffd700;
    transform: scale(1.1); /* Adds hover zoom effect */
}
nav {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: rgba(0, 0, 0, 0.8);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      z-index: 100;
      box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.5);
    }

    nav .logo {
      display: flex;
      align-items: center;
      color: #fff;
    }

    nav .logo img {
      height: 40px;
      margin-right: 10px;
      border-radius: 50%;
      border: 2px solid cyan;
    }

    nav .logo h2 {
      font-size: 20px;
      color: cyan;
    }

    nav ul {
      display: flex;
      list-style: none;
    }

    nav ul li {
      margin: 0 15px;
    }

    nav ul li a {
      text-decoration: none;
      color: #fff;
      font-size: 16px;
      transition: color 0.3s ease, text-shadow 0.3s ease;
    }

    nav ul li a:hover {
      color: cyan;
      text-shadow: 0 0 10px cyan;
    }

    .user-details {
      display: flex;
      align-items: center;
      cursor: pointer;
    }

    .user-details img {
      height: 40px;
      width: 40px;
      border-radius: 50%;
      margin-right: 10px;
      border: 2px solid cyan;
    }

    .user-details span {
      color: #fff;
      font-size: 14px;
    }
    </style>
</head>
<body>

<nav>
        <div class="logo">
            <img src="https://storage.googleapis.com/a1aa/image/b748eecf-3ee1-4a78-850f-b0b36d5f0f63.jpeg" alt="Jewellery Shop Logo">
            <h2> AW JEWELLERY SHOP</h2>
        </div>
        <ul>
        <li><a href="Home.php">HOME</a></li>
            <li><a href="add_jewelry.html">JEWELLERY</a></li>
            <li><a href="inventory.php">INVERNTORY</a></li>
            <li><a href="billing.php">BILLING</a></li>
            <li><a href="users.php">USERS</a></li>
            <li><a href="inventory.php">REPORTS</a></li>
            <li><a href="about.html">ABOUT US</a></li>
            <li><a href="contact.html">CONTACT US</a></li>
            <li><a href="index.php">LOGIN</a></li>
            <li><a href="logout.php">LOGOUT</a></li>
        </ul>
<div class="user-details" onclick="toggleUserMenu()">
    <img src="hacker.png" alt="User Avatar">
    <span>My Account</span>
</div>
<div class="user-menu" id="user-menu">
    <ul>
        <li><a href="profile.php">View Profile</a></li>
        <li><a href="settings.php">Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

    </nav>
    <script>
        function toggleUserMenu() {
    const userMenu = document.getElementById('user-menu');
    userMenu.classList.toggle('active');
}
</script>
    <div class="settings-container">
        <h1>Account Settings</h1>
        <form action="update_settings.php" method="POST">
            <!-- Profile Section -->
            <h3>Profile Information</h3>
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name"  required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email"  required>
            </div>

            <!-- Password Section -->
            <h3>Change Password</h3>
            <div class="form-group">
                <label for="current-password">Current Password</label>
                <input type="password" id="current-password" name="current_password" required>
            </div>
            <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" id="confirm-password" name="confirm_password" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn">Save Changes</button>
        </form>
    </div>
</body>
</html>
