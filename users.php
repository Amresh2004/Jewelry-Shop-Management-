<?php
require_once 'db_connection.php';

// Handle deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: users.php?success=User deleted successfully!");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

// Handle addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, role) VALUES (:name, :email, :role)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        header("Location: users.php?success=User added successfully!");
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
    <title>User Management</title>

   
    <style>
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
    padding: 30px;
    border-radius: 10px;
    width: 100%;
    max-width: 700px;
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

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #007bff;
    color: white;
}

.success-message {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #c3e6cb;
    border-radius: 5px;
}

.btn {
    display: inline-block;
    padding: 8px 16px;
    margin-top: 10px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.btn:hover {
    background-color: #0056b3;
}

.delete-btn {
    background-color: #dc3545;
}

.delete-btn:hover {
    background-color: #a71d2a;
}

/* Style for Form */
form {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 10px;
}

/* Style for Labels */
form label {
    font-size: 16px;
    color: #333;
    font-weight: bold;
}

/* Style for Input Fields */
form input[type="text"], form input[type="email"], form select {
    width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

/* Focus state for inputs */
form input[type="text"]:focus, form input[type="email"]:focus, form select:focus {
    border-color: #007bff;
}

/* Style for the Submit Button */
form button[type="submit"] {
    padding: 12px 20px;
    background-color: #007bff;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

/* Button hover effect */
form button[type="submit"]:hover {
    background-color: #0056b3;
}

/* Error message style (optional) */
.error-message {
    color: #dc3545;
    font-size: 14px;
    margin-top: -10px;
}


    </style>

    <!-- Link to JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>User Management</h1>

        <br>

        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                <?= htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <h2>Add New User</h2>
        <br>
        <form method="POST">
            <label>Name:</label>
            <input type="text" name="name" required>
            <br>
            <label>Email:</label>
            <input type="email" name="email" required>
            <br>
            <label>Role:</label>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="editor">Editor</option>
                <option value="viewer">Viewer</option>
            </select>
            <button type="submit" name="add_user" class="btn">Add User</button>
        </form>
        <br>

        <h2>All Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "<td>
                                <a href='edit_user.php?id=" . htmlspecialchars($row['id']) . "' class='btn'>Edit</a>
                                <a href='users.php?delete=" . htmlspecialchars($row['id']) . "' class='btn delete-btn'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- JQuery Script for Deletion Confirmation -->
    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function(e) {
                e.preventDefault();  // Prevent default action
                var deleteLink = $(this).attr('href');
                if (confirm("Are you sure you want to delete this user?")) {
                    window.location.href = deleteLink;
                }
            });
        });
    </script>
</body>
</html>
