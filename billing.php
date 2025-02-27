<?php
session_start();
require_once 'db_connection.php';

// Check if the user is logged in as an admin
//if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    //echo "<script>alert('Access Denied. Only admins can generate bills.'); window.location.href = 'Home.php';</script>";
    //exit();
//}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_bill'])) {
    try {
        // Get the logged-in user's ID from the session
        $user_id = $_SESSION['user_id']; 

        // Query to fetch the jewelry items belonging to the logged-in user
        $stmt = $pdo->prepare("SELECT * FROM jewelry WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if the user has any jewelry items
        if (count($items) === 0) {
            echo "<script>alert('No jewelry items found for this user.'); window.history.back();</script>";
            exit();
        }

        $billDetails = "";
        $grandTotal = 0;

        // Loop through the items and calculate the total price including GST
        foreach ($items as $row) {
            $totalPrice = $row['price'] + ($row['price'] * $row['gst'] / 100);
            $grandTotal += $totalPrice;

            $billDetails .= "
                <tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['type']) . "</td>
                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                    <td>₹" . number_format($row['price'], 2) . "</td>
                    <td>" . htmlspecialchars($row['gst']) . "%</td>
                    <td>₹" . number_format($totalPrice, 2) . "</td>
                </tr>";
        }

        echo "
        <!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='icon' type='image/x-icon' href='favicon.ico'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css'>
    <title>Billing Receipt</title>
    <style>
    body {
        background: rgba(0, 0, 0, 0.5) url('https://storage.googleapis.com/a1aa/image/b748eecf-3ee1-4a78-850f-b0b36d5f0f63.jpeg');
        background-size: cover;
        background-color: #f9f9f9;
    }
    .bill-container {
        max-width: 800px;
        margin: 20px auto;
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
    }
    .bill-container h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-size: large;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    table th {
        background-color:rgb(0, 255, 47);
        color: #333;
    }

    .total-row {
        font-weight: bold;
        background-color:rgb(255, 21, 4);
    }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        margin: 5px;
        color: #fff;
        background-color: #007bff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    @media (max-width: 600px) {
        .bill-container {
            padding: 10px;
        }

        table th, table td {
            padding: 8px;
        }

        .btn {
            padding: 8px 12px;
        }
    }
    </style>
</head>
<body>

    <div class='bill-container'>
        <h1>Billing Receipt</h1>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Price (₹)</th>
                    <th>GST (%)</th>
                    <th>Total Price (₹)</th>
                </tr>
            </thead>
            <tbody>
                $billDetails
            </tbody>
            <tfoot>
                <tr class='total-row'>
                    <td colspan='5'>Grand Total</td>
                    <td>₹" . number_format($grandTotal, 2) . "</td>
                </tr>
            </tfoot>
        </table>
        <a href='billing.php' class='btn'>Generate Another Bill</a>
        <a href='inventory.php' class='btn'>Back to Inventory</a>
    </div>
</body>
</html>
";
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<html>
    <head>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap');
             * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: url('your-image-url-here') no-repeat center center/cover;
            color: #fff;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #ffd700, #ff8c00);
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.5) url('https://storage.googleapis.com/a1aa/image/b748eecf-3ee1-4a78-850f-b0b36d5f0f63.jpeg');
           /* background-image: url(https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcTBCNv6tRD5FLUpdDIWyijBOZ4P8sB2ZJ4x_jaastjz05MWqgIU); */
        }

        form {
            background-color:rgba(255, 255, 255, 0.29);
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 100px 100px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        button {
            background-color: #007bff;
            color:rgb(255, 255, 255);
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        button:active {
            background-color: #003f7f;
        }
        /* Navigation Bar */
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

        /* Footer */
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
    <form action="billing.php" method="POST">
    <button type="submit" name="generate_bill">Generate Bill</button>
</form>
</div>
<footer>
        &copy; 2024 Amazing Jewellery Shop. All rights reserved.
    </footer>
    </body>
</html> 
