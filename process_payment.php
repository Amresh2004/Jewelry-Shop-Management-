<?php
// Simulate database and payment processing
session_start();

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$amount = $_POST['amount'] ?? 0;
$payment_method = $_POST['payment_method'] ?? '';

if (empty($name) || empty($email) || empty($amount) || empty($payment_method)) {
    die("Invalid payment details.");
}

// Simulate storing in the database and generating a transaction ID
$transaction_id = uniqid('TX'); // Example: TX647db3a9c5
$_SESSION['payment_details'] = [
    'name' => $name,
    'email' => $email,
    'amount' => $amount,
    'payment_method' => $payment_method,
    'transaction_id' => $transaction_id,
    'payment_date' => date('Y-m-d H:i:s')
];
// Include PHPMailer for sending emails (use the previous setup with PHPMailer)
require 'vendor/autoload.php'; // Adjust path as needed
require 'receipt_template.php'; // Receipt email template

sendReceipt(
    $email,
    $name,
    $transaction_id,
    $amount,
    date('Y-m-d H:i:s'),
    $payment_method
);

// Redirect to confirmation page
header("Location: payment_success.php");
exit;
?>

