<?php
session_start();
include 'db_connection.php'; // Include the database connection

// Check if the user is an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo "<script>alert('Access Denied. Only admins can access this page.'); window.location.href = 'login.php';</script>";
    exit();
}

// Admin has logged in
echo "<h1>Welcome, Admin</h1>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-align: center;
            margin: 10px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #45a049;
        }
        .logout {
            background-color: #f44336;
        }
        .logout:hover {
            background-color: #e53935;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Dashboard</h2>
    <p><strong>Welcome, Admin! You have full access to manage the jewelry and generate bills.</strong></p>

    <!-- Links for adding, editing, deleting jewelry, and generating bills -->
    <a href="add_jewelry.html" class="button">Add New Jewelry</a>
    <a href="edit_jewelry.php" class="button">Edit Jewelry</a>
    <a href="delete_jewelry.php" class="button">Delete Jewelry</a>
    <a href="billing.php" class="button">Generate Bill</a>
    
    <h3>Jewelry Inventory</h3>
    <?php
    // Fetch all jewelry items from the database
    $stmt = $pdo->prepare("SELECT id, name, price FROM jewelry");
    $stmt->execute();
    $jewelryItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any jewelry is available
    if (count($jewelryItems) > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th>412<th>Price</th><th>Actions</th></tr>";
        
        // Display jewelry items in a table
        foreach ($jewelryItems as $item) {
            echo "<tr>";
            echo "<td>" . $item['id'] . "</td>";
            echo "<td>" . $item['name'] . "</td>";
            echo "<td>" . $item['price'] . "</td>";
            echo "<td>
                    <a href='edit_jewelry.php?id=" . $item['id'] . "' class='button'>Edit</a>
                    <a href='delete_jewelry.php?id=" . $item['id'] . "' class='button'>Delete</a>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No jewelry items available.</p>";
    }
    ?>

    <br>
    <!-- Logout button -->
    <a href="logout.php" class="button logout">Logout</a>
</div>

</body>
</html>
