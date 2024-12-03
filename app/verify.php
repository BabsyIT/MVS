<?php
require 'db_connection.php';

if (isset($_GET['token'])) {
    $token = htmlspecialchars($_GET['token']);
    $stmt = $pdo->prepare("UPDATE members SET is_verified = 1, verification_token = NULL WHERE verification_token = ?");
    if ($stmt->execute([$token]) && $stmt->rowCount() > 0) {
        echo "E-Mail erfolgreich verifiziert! <a href='login.php'>Zum Login</a>";
    } else {
        echo "Ungültiger oder abgelaufener Token.";
    }
} else {
    echo "Kein Token angegeben.";
}
