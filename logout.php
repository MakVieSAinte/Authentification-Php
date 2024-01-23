<?php
session_start();

// Déconnexion de l'utilisateur
session_unset();
session_destroy();

header('Location: login.php');
exit;
?>