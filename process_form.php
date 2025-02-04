<?php
session_start();
require_once 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is a new user
$user_id = $_SESSION['user_id'];

// Query to check if the user has any jewelry in the inventory
$stmt = $pdo->prepare("SELECT COUNT(*) FROM jewelry WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$userInventoryCount = $stmt->fetchColumn();

if ($userInventoryCount === 0) {
    // If it's a new user, clear any data (for example, clear the inventory table for this user)
    // Here you can reset any data in the jewelry table or any user-specific data
    // For example, clearing any old data related to the user (if needed)
    $stmt = $pdo->prepare("DELETE FROM jewelry WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

// Handle form submission for adding new jewelry
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Prepare SQL statement to insert jewelry with user_id
        $stmt = $pdo->prepare("INSERT INTO jewelry (name, type, quantity, carat, price, gst, user_id) 
                               VALUES (:name, :type, :quantity, :carat, :price, :gst, :user_id)");

        // Bind parameters and include user_id from session
        $stmt->execute([
            ':name' => $_POST['name'],
            ':type' => $_POST['type'],
            ':quantity' => $_POST['quantity'],
            ':carat' => $_POST['carat'],
            ':price' => $_POST['price'],
            ':gst' => $_POST['gst'],
            ':user_id' => $_SESSION['user_id']  // Store the logged-in user's ID
        ]);

        // Redirect to view page with success message
        header("Location: view_jewelry.php?success=1");
        exit();

    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Fetch user's inventory if they are an existing user
$stmt = $pdo->prepare("SELECT * FROM jewelry WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HTML to display form and user's inventory -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Jewelry Inventory</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assuming you have some external styles -->
</head>
<body>
    <h1>Your Jewelry Inventory</h1>

    <!-- Form for adding new jewelry -->
    <form action="inventory.php" method="POST">
        <label for="name">Jewelry Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="type">Type:</label>
        <input type="text" id="type" name="type" required>
        
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>
        
        <label for="carat">Carat:</label>
        <input type="number" id="carat" name="carat" required>
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required>
        
        <label for="gst">GST:</label>
        <input type="number" id="gst" name="gst" required>

        <button type="submit">Add Jewelry</button>
    </form>

    <!-- Display the user's inventory -->
    <h2>Your Existing Inventory</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Carat</th>
            <th>Price</th>
            <th>GST</th>
        </tr>
        <?php foreach ($inventory as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= htmlspecialchars($item['type']) ?></td>
                <td><?= htmlspecialchars($item['quantity']) ?></td>
                <td><?= htmlspecialchars($item['carat']) ?></td>
                <td><?= htmlspecialchars($item['price']) ?></td>
                <td><?= htmlspecialchars($item['gst']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
