<?php
require_once '../base.php';

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
            header("Location: index.php");
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
    <link rel="stylesheet" href="./assets/css/bootstrap.min.cyborg.css">
    <title>Ajouter un film</title>
</head>
<body>
<?php require_once BASE_PROJET . '/src/_partials/header.php'; ?>

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
                                    <label for="titre" class="form-label">Titre</label>
                                    <input type="text"
                                           class="form-control <?= (isset($erreurs['titre_commentaire'])) ? "border border-2 border-danger" : "" ?>"
                                           id="titre"
                                           name="titre"
                                           value="<?= $titre_commentaire ?>"
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
                                              value="<?= $avis ?>"
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
                                               value="<?= $note ?>"
                                               placeholder="Saisir votre note"
                                               aria-describedby="emailHelp">
                                        <?php if (isset($erreurs['note'])): ?>
                                            <p class="form-text text-danger"><?= $erreurs['note'] ?></p>
                                        <?php endif; ?>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                            <button id="submit" class="btn btn-danger" >Envoyer</button>
                                        </div>
                                    </div>
                            </form>
                                </div>

                        </div>
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


     <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
