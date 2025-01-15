<?php
session_start();
include 'db_connection.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Input validation
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all fields.'); window.history.back();</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit();
    }

    if (strlen($password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long.'); window.history.back();</script>";
        exit();
    }

    // Check if the user exists in the database
    $stmt = $pdo->prepare("SELECT id, password FROM userss WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];

            // Redirect to the home page
            echo "<script>
                    alert('Login successful! Redirecting to home page.');
                    setTimeout(function() {
                        window.location.href = 'Home.html';
                    }, 1000);
                  </script>";
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No user found with this email. Please sign up.'); window.history.back();</script>";
    }
}
?>
