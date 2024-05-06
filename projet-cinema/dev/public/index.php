<?php require_once '../base.php';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.cyborg.css">
    <title>Cinema</title>
</head>
<body>

<!--    Navbar-->
<?php require_once BASE_PROJET . '/src/_partials/header.php';
?>
<!--    Presentation top films-->
<div>
    <h1 class="text-center fs-4 mt-5 mb-5">Bienvenue sur CineNote
    </h1>
    <p class="mt-5 mb-5 text-center fs-5 text-white-25">A l'affiche :</p>
</div>
<div id="carouselExampleCaptions" class="carousel slide">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <a href="details-films.php?id_film=1">
            <img src="./assets/images/fight-club-caroussel.png" class="d-block w-50 mx-auto" alt="...">
            <div class="carousel-caption d-none d-md-block">
            </a>
                <p class="text-white-75 fs-4">Fight Club</p>
            </div>
        </div>
        <div class="carousel-item">
            <a href="details-films.php?id_film=5">
            <img src="./assets/images/pulp-fiction-carousel.png" class="d-block w-50 mx-auto" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <p class="text-white-75 fs-4">Pulp Fiction</p
                </a>
            </div>
        </div>
        <div class="carousel-item">
            <a href="details-films.php?id_film=17">
            <img src="./assets/images/shutter-carousel.png" class="d-block w-50 mx-auto" alt="...">
            <div class="carousel-caption d-none d-md-block"></a>
                <p class="text-white-75 fs-4">Shutter Island</p
                </a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!--    Contenu-->



<!--    Pied de page-->

<?php require_once BASE_PROJET . '/src/_partials/footer.php';
?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>