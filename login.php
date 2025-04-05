<?php
session_start();
require_once "db.php";

$usernameError = $passwordError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) && empty($password)) {
        $usernameError = "Please enter your username!";
        $passwordError = "Please enter your password!";
    } elseif (empty($username)) {
        $usernameError = "Please enter your username!";
    } elseif (empty($password)) {
        $passwordError = "Please enter your password!";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            header("Location: " . ($user["role"] === "admin" ? "list_product.php" : "index.php"));
            exit();
        } else {
            $passwordError = "Incorrect username or password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Enter your username" value="<?= htmlspecialchars($username ?? '') ?>">
                <p class="warning"><?= $usernameError ?></p>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Enter your password">
                <p class="warning"><?= $passwordError ?></p>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Sign up</a></p>
    </div>
</body>
</html>
