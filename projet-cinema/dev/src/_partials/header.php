<?php
// Require base.php pour initialiser la session
require_once '../base.php';

// Vérifier si l'utilisateur est connecté
$pseudo_utilisateur = isset($_SESSION['pseudo_utilisateur']) ? $_SESSION['pseudo_utilisateur'] : "";

?>

<header class="navbar navbar-expand-lg bg-dark-subtle border-bottom border-2 border-danger-subtle" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand fs-5" href="../index.php">CineNote</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active fw-bold text-danger" href="../index.php">Accueil
                        <span class="visually-hidden">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../listes_films.php">Films</a>
                </li>

            </ul>
            <?php
            // Affichage du bouton de connexion ou du pseudo de l'utilisateur
            if (!empty($pseudo_utilisateur)) {
                echo '<button class="btn btn-danger me-1">
                    <a class="nav-link" href="../ajouter_films.php">Ajouter un Film</a>
                </button>
                      </div>
<div class="dropdown">
                          <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> <i class="bi bi-person"></i> '  . $pseudo_utilisateur . ' </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <li><a class="dropdown-item" href="../deconnexion.php">Déconnexion</a></li>
                          </ul>
                          ';
            } else {
                echo '<form class="d-flex" role="search">
                          <button class="btn btn-danger me-2" type="submit"><a href="./connexion.php" class="text-decoration-none text-white">Se connecter</a></button>
                          <button class="btn btn-danger" type="submit"><a href="./sinscrire.php" class="text-decoration-none text-white">S inscrire</a></button>
                      </form>';
            }
            ?>
        </div>
    </div>
</header>