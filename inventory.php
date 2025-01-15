




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
    <style>
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
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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

.bill-container tr:nth-child(even) {
    background-color: #f9f9f9;
}

.bill-container tr:hover {
    background-color: #f1f1f1;
}

.bill-container .total-row td {
    font-weight: bold;
    text-align: right;
}

    </style>
</head>
<body>
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
</body>
</html>

