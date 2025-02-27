<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to database
    include 'db_connection.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
    $sms_notifications = isset($_POST['sms_notifications']) ? 1 : 0;

    // Validation
    $errors = [];

    // Check if name, email, and passwords are not empty
    if (empty($name) || empty($email)) {
        $errors[] = 'Name and email are required.';
    }

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $errors[] = 'Current password, new password, and confirmation password are required.';
    }

    // Check if new password and confirmation password match
    if ($new_password !== $confirm_password) {
        $errors[] = 'New password and confirmation password do not match.';
    }

    // Check password strength (at least 8 characters, contains letters and numbers)
    if (strlen($new_password) < 8) {
        $errors[] = 'Password should be at least 8 characters long.';
    }

    if (!preg_match('/[A-Za-z]/', $new_password) || !preg_match('/[0-9]/', $new_password)) {
        $errors[] = 'Password must contain both letters and numbers.';
    }

    // If there are errors, display them and stop the process
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit();
    }

    // Fetch the stored password hash from the database
    $sql = "SELECT id, password FROM userss WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data

    if (!$user) {
        echo "No user found with this email.";
        exit();
    }

    $user_id = $user['id'];  // Get user ID
    $stored_password_hash = $user['password'];  // Get stored password hash

    // Verify current password
    if (!password_verify($current_password, $stored_password_hash)) {
        echo 'Current password is incorrect.';
        exit();
    }

    // Hash the new password
    $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

    // Update the password in the database
    $sql = "UPDATE userss SET password = :password WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':password', $new_password_hash, PDO::PARAM_STR);
    $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "Password updated successfully!";
    } else {
        echo "Failed to update password.";
    }
}
?>
