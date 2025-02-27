<?php
require_once 'db_connection.php';

// Fetch product details based on ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM jewelry WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            die("Product not found!");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    die("Invalid product ID!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .product-details {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .product-info {
            margin-top: 20px;
        }

        .product-info p {
            margin: 10px 0;
        }

        .btn-buy {
            display: block;
            width: 100%;
            padding: 10px 20px;
            text-align: center;
            background-color: #d49300;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
            text-decoration: none;
        }

        .btn-buy:hover {
            background-color: #b77b00;
        }
    </style>
</head>
<body>
    <div class="product-details">
        <h1><?= htmlspecialchars($product['name']) ?></h1>
        <div class="product-info">
            <p><strong>Type:</strong> <?= htmlspecialchars($product['type']) ?></p>
            <p><strong>Quantity:</strong> <?= htmlspecialchars($product['quantity']) ?></p>
            <p><strong>Carat:</strong> <?= htmlspecialchars($product['carat']) ?></p>
            <p><strong>Price:</strong> ₹<?= number_format($product['price'], 2) ?></p>
            <p><strong>GST:</strong> <?= htmlspecialchars($product['gst']) ?>%</p>
            <p><strong>Total Price:</strong> ₹<?= number_format($product['price'] + ($product['price'] * $product['gst'] / 100), 2) ?></p>
        </div>
        <a href="payment.php?id=<?= htmlspecialchars($product['id']) ?>" class="btn-buy">Buy Now</a>
    </div>
</body>
</html>
