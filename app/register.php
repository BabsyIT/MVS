<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = htmlspecialchars($_POST['first_name']);
    $lastName = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $verificationToken = bin2hex(random_bytes(16));

    $stmt = $pdo->prepare("INSERT INTO members (first_name, last_name, email, password_hash, verification_token) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$firstName, $lastName, $email, $passwordHash, $verificationToken])) {
        $verificationLink = "http://yourdomain.com/verify.php?token=" . $verificationToken;
        mail($email, "E-Mail-Verifizierung", "Bitte bestätige deine E-Mail: $verificationLink");
        echo "Registrierung erfolgreich! Bitte überprüfe deine E-Mails.";
    } else {
        echo "Fehler bei der Registrierung.";
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrierung</title>
</head>
<body>
    <h1>Registrierung</h1>
    <form method="POST">
        <input type="text" name="first_name" placeholder="Vorname" required><br>
        <input type="text" name="last_name" placeholder="Nachname" required><br>
        <input type="email" name="email" placeholder="E-Mail" required><br>
        <input type="password" name="password" placeholder="Passwort" required><br>
        <button type="submit">Registrieren</button>
    </form>
</body>
</html>
