<?php
require_once 'db_connection.php';

// Check if an ID is provided
if (!isset($_GET['id'])) {
    header('Location: users.php');
    exit();
}

$id = $_GET['id'];

// Fetch user details
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists
    if (!$user) {
        die("User not found.");
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Handle form submission to update user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, role = :role WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: users.php?success=User updated successfully!");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        /* Include your existing styles here */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: rgba(0, 0, 0, 0.5) url('https://storage.googleapis.com/a1aa/image/b748eecf-3ee1-4a78-850f-b0b36d5f0f63.jpeg');
            background-size: cover;
            background-position: center;
        }

        .container {
            background: #ffffff86;
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border: 5px solid transparent;
            background-clip: padding-box;
            position: relative;
            overflow: hidden;
        }

        .container:before {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            z-index: -1;
            border-radius: 15px;
            background: linear-gradient(45deg, rgb(0, 255, 4), rgb(192, 153, 255), #fe0008, #ffd700);
            animation: gradientMove 3s infinite linear;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .btn {
            background-color: #d49300;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            text-align: center;
        }

        .btn:hover {
            background-color: #b77b00;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="email"], select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit User</h1>

    <form method="POST">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']); ?>" required>
        </div>

      
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>

       
        
        <div class="form-group">
            <label for="role">Role:</label>
            <select name="role" id="role">
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="editor" <?= $user['role'] == 'editor' ? 'selected' : ''; ?>>Editor</option>
                <option value="viewer" <?= $user['role'] == 'viewer' ? 'selected' : ''; ?>>Viewer</option>
            </select>
        </div>
        
        <button type="submit" name="edit_user">Update User</button>
        <br>
    </form>

    <a href="users.php" class="btn">Back to User Management</a>
</div>

</body>
</html>
