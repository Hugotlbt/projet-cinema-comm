<?php
require_once '../base.php';
require_once BASE_PROJET . '/src/database/utilisateur-db.php';

$erreurs = [];
$email = "";
$motDePasse = "";

// Vérifier si l'utilisateur est connecté
$pseudo_utilisateur = isset($_SESSION['pseudo_utilisateur']) ? $_SESSION['pseudo_utilisateur'] : "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
$email = $_POST['email'];
$motDePasse = $_POST['motDePasse'];

if (empty($email)) {
$erreurs['email'] = "L'email est obligatoire";
}
if (empty($motDePasse)) {
$erreurs['motDePasse'] = "Le mot de passe est obligatoire";
}

if (empty($erreurs)) {
if (checkPassword($email, $motDePasse)) {
// Obtenir le pseudo de l'utilisateur
$pseudo_utilisateur = getPseudoByEmail($email);

// Stocker le pseudo de l'utilisateur dans la session
$_SESSION['pseudo_utilisateur'] = $pseudo_utilisateur;

// Redirection vers la page d'accueil ou autre action après connexion réussie
header("Location: index.php");
exit();
} else {
// Ajouter une erreur générale
$erreurs['connexion'] = "Email ou mot de passe incorrect";
}
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
    <title>Connexion</title>
</head>
<body>

<!-- Navbar -->
<?php require_once BASE_PROJET . '/src/_partials/header.php';?>

<!-- Contenu / page de connexion -->
<div class="container">
    <h1 class="text-center mt-5">Connexion</h1>
    <div class="w-50 mx-auto shadow p-4 bg-gradient my-5">
        <form action="" method="post" novalidate>
            <?php if (isset($erreurs['connexion'])): ?>
                <div class="mb-3">
                    <p class="form-text text-danger"><?= $erreurs['connexion'] ?></p>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="email" class="form-label">Email*</label>
                <input
                        type="email"
                        class="form-control <?= (isset($erreurs['email'])) ? "border border-2 border-danger" : "" ?>"
                        id="email"
                        name="email"
                        value="<?= $email ?>"
                        placeholder="Saisir votre email"
                        aria-describedby="emailHelp">
                <?php if (isset($erreurs['email'])): ?>
                    <p class="form-text text-danger"><?= $erreurs['email'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="motDePasse" class="form-label">Mot de passe*</label>
                <input
                        type="password"
                        class="form-control <?= (isset($erreurs['motDePasse'])) ? "border border-2 border-danger" : "" ?>"
                        id="motDePasse"
                        name="motDePasse"
                        value="<?= $motDePasse ?>"
                        placeholder="Saisir votre mot de passe"
                        aria-describedby="emailHelp">
                <?php if (isset($erreurs['motDePasse'])): ?>
                    <p class="form-text text-danger"><?= $erreurs['motDePasse'] ?></p>
                <?php endif; ?>
            </div>
            <div class="text-end">
                <!-- Afficher le pseudo de l'utilisateur ou le bouton de connexion -->
                <?php if (!empty($pseudo_utilisateur)): ?>
                    <a href="../deconnexion.php" class="btn btn-outline-danger text-decoration-none">Déconnexion</a>
                <?php else: ?>
                    <button type="submit" class="btn btn-outline-danger text-white">Valider</button>
                    <a href="./sinscrire.php" class="btn btn-outline-danger text-decoration-none">S'inscrire</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Footer -->
<?php require_once BASE_PROJET . '/src/_partials/footer.php';?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
