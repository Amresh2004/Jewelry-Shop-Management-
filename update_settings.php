<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to database
    include 'db_connect.php';

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

    // Check password strength (example: at least 8 characters, contains letters and numbers)
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

    // Assuming the current password is stored hashed in the database, check it
    // Fetch the stored password hash from the database
    $sql = "SELECT password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stored_password_hash);
    $stmt->fetch();

    if (!$stored_password_hash || !password_verify($current_password, $stored_password_hash)) {
        echo 'Current password is incorrect.';
        exit();
    }

    // Hash the new password
    $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

    // Update the password and notification preferences in the database
    $update_sql = "UPDATE users SET password = ?, email_notifications = ?, sms_notifications = ? WHERE email = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('siii', $new_password_hash, $email_notifications, $sms_notifications, $email);

    if ($update_stmt->execute()) {
        echo "Settings updated successfully!";
    } else {
        echo "An error occurred. Please try again later.";
    }
}
?>
