<?php
require_once "db.php";

$usernameError = $passwordError = $emailError = "";
$username = $password = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);

    // Validate username
    if (empty($username)) {
        $usernameError = "Please enter a username!";
    }

    // Validate password
    if (empty($password)) {
        $passwordError = "Please enter a password!";
    } elseif (strlen($password) < 6) {
        $passwordError = "Password must be at least 6 characters long!";
    }

    // Validate email
    if (empty($email)) {
        $emailError = "Please enter an email!";
    } elseif ($email == "@") {
        $emailError = "Invalid email! Please enter a valid format (e.g., example@gmail.com)";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "Invalid email! Please enter a valid format (e.g., example@gmail.com)";
    }

    // If no errors, save to database
    if (empty($usernameError) && empty($passwordError) && empty($emailError)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, 'user')");
        $stmt->bind_param("sss", $username, $hashed_password, $email);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $usernameError = "Username already exists!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($username) ?>">
                <p class="warning"><?= $usernameError ?></p>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password">
                <p class="warning"><?= $passwordError ?></p>
            </div>
            <div class="form-group">
                <input type="text" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>">
                <p class="warning"><?= $emailError ?></p>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
