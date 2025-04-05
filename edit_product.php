<?php
session_start();
include 'db.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Get product ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list_product.php");
    exit();
}

$id = $_GET['id'];
$product_sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($product_sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$product_result = $stmt->get_result();
$product = $product_result->fetch_assoc();

// Redirect if product not found
if (!$product) {
    header("Location: list_product.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Check for new image upload
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "images/";
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image = $product['image']; // Keep old image if not updated
    }

    // Update product in database
    $update_sql = "UPDATE products SET name=?, price=?, description=?, image=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sdssi", $name, $price, $description, $image, $id);

    if ($stmt->execute()) {
        header("Location: list_product.php");
        exit();
    } else {
        echo "Error updating product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h2>Edit Product</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $product['price']; ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

            <label>Current Image:</label>
            <img src="images/<?php echo $product['image']; ?>" width="100">

            <label for="image">Upload New Image (if any):</label>
            <input type="file" id="image" name="image">

            <button type="submit">Update</button>
        </form>
        <a href="list_product.php">Back to Product List</a>
    </div>
</body>
</html>
