
<?php
require_once 'db_connection.php';

// Check if a delete request was made
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM jewelry WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: inventory.php?success=Jewelry item deleted successfully!");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Handle bill generation request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_bill'])) {
    try {
        $stmt = $pdo->query("SELECT * FROM jewelry ORDER BY id DESC");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $billDetails = "";
        $grandTotal = 0;

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
                <a href='inventory.php' class='btn'>Back to Inventory</a>
            </div>";
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
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
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600&display=swap');
        /* Include your existing styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            background: rgba(0, 0, 0, 0.5) url('https://storage.googleapis.com/a1aa/image/b748eecf-3ee1-4a78-850f-b0b36d5f0f63.jpeg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0px auto;
            background-color: #ffffff86;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #333;
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

        table {
            width: 100%;
            border-collapse: collapse;
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

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons a {
            padding: 5px 10px;
            margin-right: 5px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            color: white;
        }

        .edit-btn {
            background-color: #007bff;
        }

        .edit-btn:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .delete-btn:hover {
            background-color: #a71d2a;
        }

        .btn {
    background-color: #d49300;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    margin-top: 20px;
    text-align: center;
}

.btn:hover {
    background-color: #b77b00;
}

.bill-container {
    max-width: 800px;
    margin: 20px auto;
    background-color: rgba(255, 255, 255, 0.9);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.bill-container h1 {
    text-align: center;
    color: #333;
}

.bill-container table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.bill-container th, 
.bill-container td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.bill-container th {
    background-color: #d49300;
    color: white;
}

.bill-container tr:nth-child(odd) {
    background-color: #f9f9f9;
}

.bill-container tr:hover {
    background-color: #f5f5f5;
}

.bill-container .total-row td {
    font-weight: bold;
    text-align: right;
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

        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_GET['success']); ?>
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
                    $stmt = $pdo->query("SELECT * FROM jewelry ORDER BY id DESC");
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
                        echo "<td class='action-buttons'>
                                <a href='edit_jewelry.php?id=" . htmlspecialchars($row['id']) . "' class='edit-btn'>Edit</a>
                                <a href='inventory.php?delete=" . htmlspecialchars($row['id']) . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this item?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>

        <!-- Form for Generate Bill -->
        <form method="POST">
        <a href="billing.php" class="btn">Go to Billing Page</a>
        </form>
    </div>
    <footer>
        &copy; 2024 Amazing Jewellery Shop. All rights reserved.
    </footer>
</body>
</html>

