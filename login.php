<?php
session_start();
include 'db_connection.php'; // Include the database connection

// Admin credentials
$admin_email = "amreshwarad1234@gmail.com";
$admin_password = "@Amresh1234@";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize form inputs
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);

    // Input validation
    if (empty($email) || empty($password) || empty($name)) {
        echo "<script>alert('Please fill in all fields.'); window.history.back();</script>";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit();
    }

    // Check if the user is the admin
    if ($email == $admin_email && $password == $admin_password) {
        // Admin logged in, grant access to all functionality
        $_SESSION['admin'] = true;
        echo "<script>alert('Admin login successful! Redirecting to admin dashboard.'); window.location.href = 'admin_dashboard.php';</script>";
        exit();
    }

    // Check if the user exists in the database
    $stmt = $pdo->prepare("SELECT id, password, name, email FROM userss WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if (password_verify($password, $row['password']) && $row['name'] === $name) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];

            // Check if the user is logging in for the first time (new user)
            if (empty($row['inventory_id'])) { // Assuming an 'inventory_id' or similar column exists to track user's inventory
                // If it's a new user, delete the existing inventory
                $deleteInventoryStmt = $pdo->prepare("DELETE FROM jewelry WHERE user_id = :user_id");
                $deleteInventoryStmt->bindParam(':user_id', $row['id']);
                $deleteInventoryStmt->execute();
            }
            

            // Redirect to the home page
            echo "<script>
                    alert('Login successful! Redirecting to home page.');
                    setTimeout(function() {
                        window.location.href = 'Home.php';
                    }, 1000);
                  </script>";
            exit();
        } else {
            echo "<script>alert('Invalid credentials. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No user found with this email. Please sign up.'); window.history.back();</script>";
    }
}
?>
