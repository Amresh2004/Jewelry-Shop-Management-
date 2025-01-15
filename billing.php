<?php
require_once 'db_connection.php';

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
                <a href='billing.php' class='btn'>Generate Another Bill</a>
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
    <title>Billing Form</title>
    <style>
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
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
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


        .bill-container {
    max-width: 900px;
    margin: 20px auto;
    background-color: rgba(255, 255, 255, 0.95);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
}

.bill-container h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

.bill-container table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.bill-container th, 
.bill-container td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
    font-size: 16px;
}

.bill-container th {
    background-color: #d49300;
    color: white;
    text-transform: uppercase;
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
    font-size: 18px;
}

.bill-container .btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #d49300;
    text-decoration: none;
    text-align: center;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.bill-container .btn:hover {
    background-color: #b77b00;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Generate Bill</h1>
        <form method="POST">
            <button type="submit" name="generate_bill" class="btn">Generate Bill</button>
        </form>
        <a href="inventory.php" class="btn">Back to Inventory</a>
    </div>
</body>
</html>
