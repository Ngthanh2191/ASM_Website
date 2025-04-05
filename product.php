<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $price = floatval($_POST["price"]);
    $description = trim($_POST["description"]);
    $image = $_FILES["image"]["name"];
    $target_dir = "images/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $price, $description, $image]);
        header("Location: list_product.php");
        exit();
    } else {
        $error = "Error uploading the image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h2>Add Product</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" enctype="multipart/form-data">
            <label>Product Name:</label>
            <input type="text" name="name" required>

            <label>Price:</label>
            <input type="number" name="price" required>

            <label>Description:</label>
            <textarea name="description" required></textarea>

            <label>Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit">Add Product</button>
        </form>
        <a href="list_product.php">Back to Product List</a>
    </div>
</body>
</html>
