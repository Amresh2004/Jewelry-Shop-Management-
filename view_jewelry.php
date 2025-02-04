
<?php
session_start();  // Start the session to access session variables
require_once 'db_connection.php';

// Check if the user is logged in, otherwise redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");  // Redirect to login page
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jewelry Inventory</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">

    
        <style>
            @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Navigation Styles */
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
        /* Mobile Navigation */
        .mobile-menu {
            display: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        /* Form Container Styles */
        .main-content {
            padding-top: 100px; /* Space for fixed navbar */
            min-height: calc(100vh - 70px);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: #ffffff86;
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border: 5px solid transparent;
            background-clip: padding-box;
            position: relative;
            overflow: hidden;
            margin: 20px;
        }

        .form-container:before {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            z-index: -1;
            border-radius: 15px;
            background: linear-gradient(45deg, rgb(0, 255, 4), rgb(192, 153, 255), #fe0008, #ffd700);
            animation: gradientMove 3s infinite linear;
        }

        /* Rest of your existing styles */
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .form-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #d49300;
            box-shadow: 0 0 10px rgba(212, 147, 0, 0.5);
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .cancel-btn {
            background-color: #ccc;
            color: #333;
        }

        .submit-btn {
            background-color: #d49300;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #bbb;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .submit-btn:hover {
            background-color: #b77b00;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .mobile-menu {
                display: block;
            }

            .nav-links.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: linear-gradient(45deg, #000000, #1a1a1a);
                padding: 20px;
                gap: 20px;
            }
        }

        @media (max-width: 600px) {
            .form-container {
                width: 90%;
                padding: 20px;
            }

            .form-title {
                font-size: 20px;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            justify-content: center;
            align-items: center;
            display: flex;
            min-height: 100vh;
            background-color: #f9f9f9;
            background: rgba(0, 0, 0, 0.5) url('https://storage.googleapis.com/a1aa/image/b748eecf-3ee1-4a78-850f-b0b36d5f0f63.jpeg');
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff86;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #d49300;
            color: white;
        }
        
        tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .add-new {
            background-color: #d49300;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .add-new:hover {
            background-color: #b77b00;
        }

        .action-btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            margin-right: 5px;
            font-size: 14px;
        }

        .edit-btn {
            background-color: #4CAF50;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }

        .delete-btn:hover {
            background-color: #e41e1e;
        }

        footer {
            position: fixed;
            bottom: 10px;
            text-align: center;
            color: #fff;
            font-size: large; 
            text-shadow: 0px 0px 10px cyan,
                        0px 0px 20px cyan,
                        0px 0px 40px cyan,
                        0px 0px 80px cyan;
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
        <h1>Jewelry Inventory</h1>
        
        <?php if (isset($_POST['success'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_POST['success']); ?>
            </div>
        <?php endif; ?>
        
        <a href="add_jewelry.html" class="add-new">Add New Jewelry</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Carat</th>
                    <th>Price</th>
                    <th>GST</th>
                    <th>Total Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Prepare SQL statement to select jewelry for the logged-in user
                    $stmt = $pdo->prepare("SELECT * FROM jewelry WHERE user_id = :user_id ORDER BY id DESC");
                    $stmt->execute([':user_id' => $_SESSION['user_id']]);  // Use session user_id
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $totalPrice = $row['price'] + ($row['price'] * $row['gst'] / 100);
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['carat']) . "</td>";
                        echo "<td>₹" . number_format($row['price'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($row['gst']) . "%</td>";
                        echo "<td>₹" . number_format($totalPrice, 2) . "</td>";
                        echo "<td>
                            <a href='edit_jewelry.php?id=" . htmlspecialchars($row['id']) . "' class='action-btn edit-btn'>Edit</a>
                            <a href='delete_jewelry.php?id=" . htmlspecialchars($row['id']) . "' class='action-btn delete-btn' onclick=\"return confirm('Are you sure you want to delete this item?');\">Delete</a>
                        </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        &copy; 2024 Amazing Jewellery Shop. All rights reserved.
    </footer>

</body>
</html>
