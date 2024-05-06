<?php

// Définition du paramètre de langue français pour strftime()
setlocale(LC_TIME, 'fr_FR.UTF-8');

$id_film = null;
if (isset($_GET['id_film'])) {
    $id_film = $_GET['id_film'];
}
$id_commentaire = null;
if (isset($_GET['id_commentaire'])) {
    $id_commentaire = $_GET['id_commentaire'];
}

if (isset($_POST['titre_commentaire'])) {
}

require_once '../base.php';
require_once BASE_PROJET . '/src/database/film-db.php';
require_once BASE_PROJET . '/src/database/commentaire-db.php';

$erreurs=[];
$titre_commentaire="";
$avis="";
$note="";
$date_commentaire=date("m.d.y");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titre_commentaire = $_POST['titre_commentaire'];
    $avis = $_POST['avis'];
    $note = $_POST['note'];

    if (empty($titre_commentaire)) {
        $erreurs['titre_commentaire'] = "Le titre est obligatoire";
    }
    if (empty($avis)) {
        $erreurs['avis'] = "Un avis est obligatoire";
    }
    if (empty($note)){
        $erreurs['note'] = "Une note est obligatoire";
    }

    if (empty($erreurs)) {
        if (ajouterCommentaire($titre_commentaire, $avis, $note, $date_commentaire)) {
            // Redirection vers la page d'accueil après l'ajout réussi
            header("Location: details-films.php?id_film=".$id_film);
            exit();
        } else {
            echo "Erreur lors de l'ajout du film.";
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
    <link href="./assets/css/bootstrap.min.cyborg.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <title>Détail film</title>
</head>
<!-- Menu en français -->
<?php require_once BASE_PROJET . '/src/_partials/header.php'; ?>

<?php if ($id_film): ?>
    <?php $film = getDetailsFilms($id_film); ?>
    <?php if ($film != null):
        $commentaires = getCommentaireFilms($id_film);
        foreach ($commentaires as $commentaire ){
            $avis_film=$commentaire['avis'];
            $note_film=$commentaire['note'];
            $commentaire_film=$commentaire[''];
            $date_commentaire_film=$commentaire['note'];
        }
        ?>
        <div class="container">
            <div>
                <div class="card mb-3 mt-5">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <?php echo "<img src='{$film['image_film']}' alt='' class='img-fluid mt-5 mb-5 w-100 ps-5' />"; ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo "<p class='fs-1 fw-bold pt-4 ms-4 text-capitalize'>{$film['titre_film']}</p>"; ?>
                                </h5>
                                <p class="card-text">
                                    <?php echo "<i class='bi bi-flag text-danger ms-4 fs-5'></i> <span class='fs-5 pt-4 ms-2 text-capitalize'>Pays : {$film['pays_film']}</span>"; ?>
                                </p>
                                <p class="card-text">
                                    <?php
                                    // Utilisation de strftime() pour formater la date en français
                                    $date_fr = strftime("%d %B %Y", strtotime($film['date_sortie_film']));
                                    echo "<i class='bi bi-calendar text-danger ms-4 fs-5'></i>";
                                    echo "<span class='fs-5 pt-5 ms-2 fst-italic text-capitalize'>Date de sortie : {$date_fr}</span>";
                                    ?>
                                </p>
                                <p class="card-text fs-3"><?php
                                    $duree_minutes = $film['duree_film'];
                                    $heures = floor($duree_minutes / 60);
                                    $minutes = $duree_minutes % 60;
                                    echo "<i class='bi bi-clock-history text-danger ms-4 fs-5'></i>";
                                    echo "<span class='fs-5 pt-4 ms-2 fw-bold text-capitalize'>Durée du film : {$heures} heures {$minutes} minutes</span>";
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="fw-bold fs-3 text-white">Synopsis</p>
            <div class="col-md-12 row-cols-md-auto">
                <?php echo "<p class='fs-5 mb-5'>{$film['resume_film']}</p>"; ?>
            </div>
            <div class="navbar navbar-expand-lg border-bottom border-2 border-danger ">
            </div>
            <div class="container text-center mt-4">
                <div class="row">
                    <div class="col">
                        <p class="fs-3 text-white text-start">Commentaires</p>
                    </div>
                    <div class="col text-end">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-lg btn-danger fw-bold" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Ajouter commentaire
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Votre évaluation</h1>
                                        <!-- Close button en haut a droite -->
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Forms -->
                                        <form action="" method="post" novalidate>
                                            <div class="mb-3 text-start">
                                                <label for="titre_commentaire" class="form-label">Titre</label>
                                                <input type="text"
                                                       class="form-control <?= (isset($erreurs['titre_commentaire'])) ? "border border-2 border-danger" : "" ?>"
                                                       id="titre_commentaire"
                                                       name="titre_commentaire"
                                                       value="<?=$titre_commentaire?>"
                                                       placeholder="Saisir un titre"
                                                       aria-describedby="emailHelp">
                                                <?php if (isset($erreurs['titre_commentaire'])): ?>
                                                    <p class="form-text text-danger"><?= $erreurs['titre_commentaire'] ?></p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3 text-start">
                                                <label for="avis" class="form-label">Avis</label>
                                                <textarea type="text"
                                                       class="form-control <?= (isset($erreurs['avis'])) ? "border border-2 border-danger" : "" ?>"
                                                       id="avis"
                                                       name="avis"
                                                       value="<?=$avis?>"
                                                       placeholder="Saisir votre avis"
                                                       aria-describedby="emailHelp"></textarea>
                                                <?php if (isset($erreurs['avis'])): ?>
                                                    <p class="form-text text-danger"><?= $erreurs['avis'] ?></p>
                                                <?php endif; ?>
                                                <div class="mb-3 text-start mt-3">
                                                    <label for="note" class="form-label">Votre note</label>
                                                    <input type="number" min="0" max="5"
                                                           class="form-control <?= (isset($erreurs['note'])) ? "border border-2 border-danger" : "" ?>"
                                                           id="note"
                                                           name="note"
                                                           value="<?=$note?>"
                                                           placeholder="Saisir votre note"
                                                           aria-describedby="emailHelp">
                                                    <?php if (isset($erreurs['note'])): ?>
                                                        <p class="form-text text-danger"><?= $erreurs['note'] ?></p>
                                                    <?php endif; ?>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button  id="submit" class="btn btn-danger">Envoyer</button>
                                                    </div>
                                                </div>
                                        </form>
                                    <!-- Footer -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="card mt-5">
                        <div class="container text-center pt-3">
                            <div class="row">
                                <div class="col">
                                    <p class="text-start fw-bold text-danger fs-6 mt-2 ps-3">Pseudo</p>
                                </div>
                                <div class="col">
                                    <p class="text-end fst-italic text-secondary fs-5 pe-5">Date</p>
                                </div>
                            </div>
                        <div class="card-body">
                                    <p class="text-start fw-bold fs-5 text-white">Titre commentaire</p>
                                </div>
                            <div class="row">
                                <div class="col-10">
                                    <p class="text-start ps-3 text-white-50 fs-6">Commentaire</p>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-secondary text-end mb-5 ms-5 fs-5 text-danger">1 <i class="bi bi-star-fill fs-5 text-danger"></i></button>
                                </div>

                            </div>
                        </div>
                        </div>
                    </div>
                </div>
        </div>
    <?php else : ?>
        <div class="container">
            <p class='fs-1 text-center mt-5'><i class="bi bi-exclamation-circle text-danger"></i>Aucun film trouvé</p>
        </div>
    <?php endif; ?>
<?php else : ?>
    <div class="container">
        <p class='fs-1 text-center mt-5'><i class="bi bi-exclamation-circle text-danger"></i> Aucun film trouvé</p>
    </div>
<?php endif; ?>

<!-- Pied de page -->
<?php require_once BASE_PROJET . '/src/_partials/footer.php'; ?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
