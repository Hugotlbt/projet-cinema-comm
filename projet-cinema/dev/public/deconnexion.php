<?php
require_once '../base.php';

// Vérifie si l'utilisateur est connecté
if (isset($_SESSION['pseudo_utilisateur'])) {
    // Détruit toutes les données de session
    session_unset();

    // Détruit la session
    session_destroy();
}

// Redirige vers la page de connexion
header("Location: connexion.php");
exit(); // Assurez-vous qu'aucun code HTML ne soit envoyé après la redirection
?>
