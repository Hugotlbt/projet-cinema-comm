<?php
require_once '../base.php';
require_once BASE_PROJET . '/src/config/db-config.php';
// Fonction permettant de récupérer tous les films
function getFilms(): array
{
$pdo = getConnexion();
$requete = $pdo->query("SELECT * FROM film");
return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function getDetailsFilms($id_film)
{
$pdo = getConnexion();
$requete = $pdo->prepare(query: "SELECT * FROM film WHERE id_film = $id_film");
$requete->execute();
return $requete->fetch(PDO::FETCH_ASSOC);
}

function ajouterFilm($nom_film, $duree_film, $resume_film, $date_de_sortie_film, $pays_film, $image_film)
{
    $pdo = getConnexion();

    try {
        // Préparation de la requête
        $requete = $pdo->prepare("INSERT INTO FILM (titre_film, duree_film, resume_film, date_sortie_film, pays_film, image_film) VALUES (?, ?, ?, ?, ?, ?)");

        // Exécution de la requête avec les valeurs des paramètres
        $requete->execute([$nom_film, $duree_film, $resume_film, $date_de_sortie_film, $pays_film, $image_film]);

        // Renvoie true si l'ajout a réussi
        return true;
    } catch (PDOException $e) {
        // En cas d'erreur, affiche un message d'erreur
        echo "Erreur lors de l'ajout du film : " . $e->getMessage();
        // Renvoie false en cas d'erreur
        return false;
    }
}
