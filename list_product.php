<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['delete_product'])) {
    $id = intval($_GET['delete_product']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: list_product.php");
    exit();
}

if (isset($_GET['delete_user'])) {
    $id = $_GET['delete_user'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: list_product.php");
    exit();
}

$product_sql = "SELECT * FROM products";
$product_result = $conn->query($product_sql);

$user_sql = "SELECT * FROM users";
$user_result = $conn->query($user_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Management</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h2>Product Management</h2>
        <a href="product.php" class="btn-add">Add Product</a>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $product_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo number_format($row['price'], 0, ',', '.'); ?>₫</td>
                    <td><img src="images/<?php echo $row['image']; ?>" width="50"></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="list_product.php?delete_product=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">🗑️ Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>User Management</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $user_result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                        <a href="list_product.php?delete_user=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">🗑️ Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</body>
</html>
