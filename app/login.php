<?php
require 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $stmt = $pdo->prepare("SELECT id, password_hash, is_verified FROM members WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        if ($user['is_verified']) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Bitte verifiziere deine E-Mail-Adresse.";
        }
    } else {
        echo "Ungültige Anmeldedaten.";
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        <input type="email" name="email" placeholder="E-Mail" required><br>
        <input type="password" name="password" placeholder="Passwort" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
