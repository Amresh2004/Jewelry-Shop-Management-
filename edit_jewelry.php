<?php
require_once 'db_connection.php';

if (!isset($_GET['id'])) {
    header("Location: inventory.php?error=Invalid jewelry ID.");
    exit();
}

$id = $_GET['id'];

try {
    // Fetch the existing jewelry data
    $stmt = $pdo->prepare("SELECT * FROM jewelry WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $jewelry = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$jewelry) {
        header("Location: inventory.php?error=Jewelry item not found.");
        exit();
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $carat = $_POST['carat'];
    $price = $_POST['price'];
    $gst = $_POST['gst'];

    try {
        // Update the jewelry data
        $stmt = $pdo->prepare("UPDATE jewelry SET name = :name, type = :type, quantity = :quantity, carat = :carat, price = :price, gst = :gst WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':carat', $carat, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':gst', $gst, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: inventory.php?success=Jewelry item updated successfully!");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jewelry</title>
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

        .form-container {
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

        .form-container:before {
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

        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #d49300;
            box-shadow: 0 0 10px rgba(212, 147, 0, 0.5);
        }

        input::placeholder {
            color: #aaa;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .cancel-btn {
            background: #ccc;
            color: #333;
        }

        .save-btn {
            background: #d49300;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #bbb;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .save-btn:hover {
            background-color: #b77b00;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 600px) {
            .form-container {
                width: 90%;
                padding: 20px;
            }

            .form-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Jewelry</h2>
        <form action="edit_jewelry.php?id=<?= htmlspecialchars($id) ?>" method="POST">
            <div class="form-group">
                <label for="name">Jewelry Name</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($jewelry['name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" required>
                    <option value="Earing" <?= $jewelry['type'] == 'Earing' ? 'selected' : '' ?>>Earing</option>
                    <option value="Necklace" <?= $jewelry['type'] == 'Necklace' ? 'selected' : '' ?>>Necklace</option>
                    <option value="Ring" <?= $jewelry['type'] == 'Ring' ? 'selected' : '' ?>>Ring</option>
                    <option value="Bracelet" <?= $jewelry['type'] == 'Bracelet' ? 'selected' : '' ?>>Bracelet</option>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="<?= htmlspecialchars($jewelry['quantity']) ?>" required>
            </div>
            <div class="form-group">
                <label for="carat">Carat</label>
                <input type="number" name="carat" id="carat" value="<?= htmlspecialchars($jewelry['carat']) ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" value="<?= htmlspecialchars($jewelry['price']) ?>" required>
            </div>
            <div class="form-group">
                <label for="gst">GST (%)</label>
                <input type="number" name="gst" id="gst" value="<?= htmlspecialchars($jewelry['gst']) ?>" required>
            </div>
            <div class="button-group">
                <button type="button" class="cancel-btn" onclick="window.location.href='inventory.php'">Cancel</button>
                <button type="submit" class="save-btn">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>
