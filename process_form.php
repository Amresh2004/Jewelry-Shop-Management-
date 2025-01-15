<?php
// Include database connection
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Prepare SQL statement
        $stmt = $pdo->prepare("INSERT INTO jewelry (name, type, quantity, carat, price, gst) 
                              VALUES (:name, :type, :quantity, :carat, :price, :gst)");
        
        // Bind parameters
        $stmt->execute([
            ':name' => $_POST['name'],
            ':type' => $_POST['type'],
            ':quantity' => $_POST['quantity'],
            ':carat' => $_POST['carat'],
            ':price' => $_POST['price'],
            ':gst' => $_POST['gst']
        ]);
        
        // Redirect to view page with success message
        header("Location: view_jewelry.php?success=1");
        exit();
        
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>