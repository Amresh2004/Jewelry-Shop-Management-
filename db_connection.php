<?php
// Database credentials
$host = "localhost";       // Server host
$dbname = "jeweller"; // Database name
$user = "postgres";        // PostgreSQL username
$pass = "8624807723";    // PostgreSQL password

try {
    // Connect to PostgreSQL
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}
?>
