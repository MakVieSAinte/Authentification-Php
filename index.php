<?php
session_start();

// Connexion à la base de données
require"db.php";

// Pour afficher les erreurs php
include "Errors-display.php";

// Rediriger l'utilisateur vers la page de connexion s'il n'est pas déjà connecté
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page sécurisée</title>
</head>
<body>
    <h1>Bienvenue, <?php echo $_SESSION['username']; ?>!</h1>
    <p>C'est une page sécurisée.</p><br>
    <a href="logout.php">Déconnexion</a>
</body>
</html>