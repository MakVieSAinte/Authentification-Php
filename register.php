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

// Traitement du formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération des valeurs du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification si l'utilisateur existe déjà
    $sql = "SELECT id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Ce nom d'utilisateur existe déjà.";
    } else {
        // Hashage du mot de passe
        $option = [
            'cost' => 12,
        ];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $option);

        // Insertion de l'utilisateur dans la base de données
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashedPassword);
        $stmt->execute();

        // Redirection vers la page de connexion après l'inscription réussie
        header('Location: login.php');
        exit;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
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
            <input type="submit" value="S'inscrire" name="register">
        </div>
    </form>

    <br><br>

    <a href="login.php">Se connecter</a>

</body>
</html>