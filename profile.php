<?php
require_once 'db_connection.php'; // Ensure this file contains the PDO connection setup
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view your profile.";
    exit();
}

// Fetch user details from the database
try {
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM userss WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>User Profile</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap');
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
    background-color:rgba(255, 255, 255, 0.8);
    width: 800px;
    border-radius: 8px;
    box-shadow: 0px 0px 50px cyan,
    0px 0px 50px cyan inset;
    padding: 80px;
    text-align: center;
    border: 1px solid cyan;

}
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #444;
        }
        .profile-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 5px;
            border-bottom: 1px solid #ddd;
            font-size: larger;
        }
        .profile-item:last-child {
            border-bottom: none;
        }
        .profile-item label {
            font-weight: bold;
            color: #555;
        }
        .profile-item span {
            color: #666;
        }
        .logout-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: 1px solid;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.3s;
        }
        .logout-button:hover {
            background: #0056b3;
        }
        @media (max-width: 768px) {
      nav ul {
        flex-wrap: wrap;
        justify-content: center;
      }

      nav ul li {
        margin: 10px;
      }

      .container {
        padding: 20px;
      }

      h1 {
        font-size: 20px;
      }

      button {
        font-size: 14px;
      }
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
        <!-- User Details Section -->
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
    
    <div class="container">
        <u><h1>User Profile</h1></u>
        <div class="profile-item">
            <label>Name:</label>
            <span><?= htmlspecialchars($user['name']) ?></span>
        </div>
        <div class="profile-item">
            <label>Email:</label>
            <span><?= htmlspecialchars($user['email']) ?></span>
        </div>
        <div class="profile-item">
            <label>Phone:</label>
            <span><?= htmlspecialchars($user['phone']) ?></span>
        </div>
        <div class="profile-item">
            <label>Address:</label>
            <span><?= htmlspecialchars($user['address']) ?></span>
        </div>
        <a href="Home.php" class="logout-button">Back To Home</a>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>
