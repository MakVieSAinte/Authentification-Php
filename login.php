<?php
session_start();

// Connexion à la base de données
require"db.php";

// Pour afficher les erreurs php
include "Errors-display.php";

// Rediriger l'utilisateur vers la page d'accueil s'il est déjà connecté
if (isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération des valeurs du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification des informations d'identification
    $sql = "SELECT username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Authentification réussie
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            header('Location: index.php');
            exit;
        }
    }

    // Authentification échouée
    $error = "Nom d'utilisateur ou mot de passe incorrect.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <?php if (isset($error)) { ?>
        <div><?php echo $error; ?></div>
    <?php } ?>
    <form method="post" action="">
        <div>
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>
        </div><br>
        <div>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div><br>
        <div>
            <input type="submit" value="Se connecter" name="login">
        </div>
    </form>

    <br><br>

    <a href="register.php">S'inscrire</a>

</body>
</html>