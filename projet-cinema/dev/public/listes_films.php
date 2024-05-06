<?php
// Récupérer la liste des étudiants dans la table etudiant

// 1. Connexion à la base de donnée db_intro
/**
 * @var PDO $pdo
 */

require_once '../base.php';
require_once BASE_PROJET . '/src/database/film-db.php';
$films = getFilms();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.cyborg.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <title>Cinema</title>
</head>
<body>

<!--    Navbar-->

<?php require_once BASE_PROJET . '/src/_partials/header.php';
?>

<!--    Contenu-->

<div class="d-flex mt-2">
    <div class=" rounded-4 p-3 flex-fill">
        <div class="container ">
            <h1 class="text-center fw-bold fs-3 mt-3 mb-5 ">Tous les films</h1>
            <!-- Formulaire de recherche -->
            <form action="recherche.php" method="GET" class="mb-5 mt-5 ps-4 pe-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Chercher un film" name="query">
                    <button type="submit" class="btn btn-danger">Chercher</button>
                </div>
            </form>
            <!-- Liste des films -->
            <div class="row text-center" id="filmList">
                <!-- Boucle des films -->
                <?php foreach ($films as $film) : ?>
                    <div class="filmItem d-flex mb-5 mx-sm-auto" style="max-width: 20rem;">
                        <div class="card-body d-flex flex-column">
                            <h4 class="card-title fs-4 fw-bold">
                                <img class="w-100" src="<?= $film["image_film"]?>" alt="">
                            </h4>
                            <p class="card-text mt-3 fw-bold text-white fs-4"><?= ucfirst($film["titre_film"]) ?></p>
                            <p class="fs-6 fst-italic text-white-50 ">
                                <?= floor($film["duree_film"] / 60) ?> h <?= $film["duree_film"] % 60 ?> min
                            </p>
                            <div class="mt-auto">
                                <a class="btn btn-danger align-bottom" role="button"
                                   href="details-films.php?id_film=<?= $film['id_film'] ?>">Détails du film</a>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!--    Pied de page-->
            <?php require_once BASE_PROJET . '/src/_partials/footer.php';
            ?>

            <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>