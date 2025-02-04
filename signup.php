<?php
include 'db_connection.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim and sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $address = htmlspecialchars(trim($_POST['address']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            alert('Invalid email format.');
            window.history.back();
        </script>";
        exit;
    }

    // Password validation
    if (
        strlen($password) < 8 || // At least 8 characters
        !preg_match('/[A-Z]/', $password) || // At least one uppercase letter
        !preg_match('/[0-9]/', $password) || // At least one number
        !preg_match('/[\W]/', $password) // At least one special character
    ) {
        echo "<script>
            alert('Password must be at least 8 characters long, include one uppercase letter, one number, and one special character.');
            window.history.back();
        </script>";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "<script>
            alert('Passwords do not match.');
            window.history.back();
        </script>";
        exit;
    }

    try {
        // Check if the email already exists in the database
        $stmt = $pdo->prepare("SELECT id FROM userss WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "<script>
                alert('Email already exists! Redirecting to the login page.');
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 1000);
            </script>";
            exit;
        }

        // Hash the password securely using BCRYPT
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insert the new user into the database
        $stmt = $pdo->prepare("INSERT INTO userss (name, email, phone, address, password) VALUES (:name, :email, :phone, :address, :password)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->execute();
        

        // Success message and redirect
        echo "<script>
            alert('Account created successfully! Redirecting to the login page.');
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 1000);
        </script>";
        exit;
    } catch (Exception $e) {
        // Catch any database-related errors
        error_log($e->getMessage(), 3, "error_log.log"); // Log the error for debugging
        echo "<script>
            alert('An error occurred while creating your account. Please try again.');
            window.history.back();
        </script>";
        exit;
    }
}
?>
