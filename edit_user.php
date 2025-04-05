<?php
session_start();
include 'db.php';

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Get user ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list_product.php");
    exit();
}

$id = $_GET['id'];
$user_sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($user_sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Redirect if user not found
if (!$user) {
    header("Location: list_product.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    // Check if user enters a new password
    if (!empty($password)) {
        // Hash the new password before updating
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $update_sql = "UPDATE users SET username=?, email=?, role=?, password=? WHERE id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssi", $username, $email, $role, $hashed_password, $id);
    } else {
        // If no new password is entered, keep the old one
        $update_sql = "UPDATE users SET username=?, email=?, role=? WHERE id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssi", $username, $email, $role, $id);
    }

    if ($stmt->execute()) {
        header("Location: list_product.php");
        exit();
    } else {
        echo "Error updating user.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h2>Edit User</h2>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>User</option>
            </select>

            <label for="password">New Password (leave blank if not changing):</label>
            <input type="password" id="password" name="password">

            <button type="submit">Update</button>
        </form>
        <a href="list_product.php">Back to Product List</a>
    </div>
</body>
</html>
