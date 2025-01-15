<?php
require_once 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jewelry Inventory</title>
    <style>
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
        
        tr:nth-child(even) {
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
    </style>
</head>
<body>
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
</body>
</html>
