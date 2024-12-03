<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Willkommen</title>
</head>
<body>
    <h1>Willkommen!</h1>
    <p><a href="login.php">Login</a> oder <a href="register.php">Registrieren</a></p>
</body>
</html>
