<?php
require_once '../base.php';
require_once BASE_PROJET . '/src/database/utilisateur-db.php';
require_once BASE_PROJET . '/src/config/db-config.php';

$pdo = getConnexion(); // Initialise PDO en utilisant la fonction getConnexion() du fichier db-config.php

$erreurs = [];
$pseudo_utilisateur = "";
$email_utilisateur = "";
$mdp_utilisateur = "";
$mdp_utilisateurCheck = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pseudo_utilisateur = $_POST['pseudo_utilisateur'];
    $email_utilisateur = $_POST['email_utilisateur'];
    $mdp_utilisateur = $_POST['mdp_utilisateur'];
    $mdp_utilisateurCheck = $_POST['mdp_utilisateurCheck'];

    // Vérification si l'utilisateur existe déjà avec le même pseudo ou email
    $existingUser = getUserByPseudo($pseudo_utilisateur);
    if ($existingUser) {
        $erreurs['pseudo_utilisateur'] = "Ce pseudo est déjà utilisé.";
    }

    $existingUser = getUserByEmail($email_utilisateur);
    if ($existingUser) {
        $erreurs['email_utilisateur'] = "Cet email est déjà associé à un compte.";
    }

    // Si aucune erreur, on peut procéder à l'inscription
    if (empty($erreurs)) {
        $erreurs = InscriptionUtilisateur($pseudo_utilisateur, $email_utilisateur, $mdp_utilisateur, $mdp_utilisateurCheck, $pdo);
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.cyborg.css">
    <title>Inscription</title>
</head>
<body>

<!-- Navbar -->
<?php require_once BASE_PROJET . '/src/_partials/header.php'; ?>

<div class="container">
    <h1 class="text-center mt-5">Inscription</h1>
    <div class="w-50 mx-auto shadow p-4 bg-gradient my-5">
        <form action="" method="post" novalidate>
            <div class="mb-3">
                <label for="pseudo_utilisateur" class="form-label">Définir un pseudo*</label>
                <input type="text"
                       class="form-control <?= (isset($erreurs['pseudo_utilisateur'])) ? "border border-2 border-danger" : "" ?>"
                       id="pseudo_utilisateur"
                       name="pseudo_utilisateur"
                       value="<?= $pseudo_utilisateur ?>"
                       placeholder="Saisir votre pseudo"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['pseudo_utilisateur'])): ?>
                    <p class="form-text text-danger"><?= $erreurs['pseudo_utilisateur'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="email_utilisateur" class="form-label">Renseigner votre email*</label>
                <input type="email"
                       class="form-control <?= (isset($erreurs['email_utilisateur'])) ? "border border-2 border-danger" : "" ?>"
                       id="email_utilisateur"
                       name="email_utilisateur"
                       value="<?= $email_utilisateur ?>"
                       placeholder="Saisir votre email"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['email_utilisateur'])): ?>
                    <p class="form-text text-danger"><?= $erreurs['email_utilisateur'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="mdp_utilisateur" class="form-label">Définir un mot de passe*</label>
                <input type="password"
                       class="form-control <?= (isset($erreurs['mdp_utilisateur'])) ? "border border-2 border-danger" : "" ?>"
                       id="mdp_utilisateur"
                       name="mdp_utilisateur"
                       placeholder="Saisir un mot de passe"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['mdp_utilisateur'])): ?>
                    <p class="form-text text-danger"><?= $erreurs['mdp_utilisateur'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="mdp_utilisateurCheck" class="form-label">Confirmer le mot de passe*</label>
                <input type="password"
                       class="form-control <?= (isset($erreurs['mdp_utilisateurCheck'])) ? "border border-2 border-danger" : "" ?>"
                       id="mdp_utilisateurCheck"
                       name="mdp_utilisateurCheck"
                       placeholder="Ressaisir un mot de passe"
                       aria-describedby="emailHelp">
                <?php if (isset($erreurs['mdp_utilisateurCheck'])): ?>
                    <p class="form-text text-danger"><?= $erreurs['mdp_utilisateurCheck'] ?></p>
                <?php endif; ?>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-outline-danger">Valider</button>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<?php require_once BASE_PROJET . '/src/_partials/footer.php'; ?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
