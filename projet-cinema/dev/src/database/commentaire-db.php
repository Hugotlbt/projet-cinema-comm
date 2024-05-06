<?php
require_once '../base.php';
require_once BASE_PROJET . '/src/config/db-config.php';

function getCommentaire(): array
{
    $pdo = getConnexion();
    $requete = $pdo->query("SELECT * FROM commentaire");
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function getCommentaireFilms($id_film)
{
    $pdo = getConnexion();
    $requete = $pdo->prepare(query: "SELECT * FROM film, commentaire WHERE film.id_film=commentaire.id_film  = $id_film");
    $requete->execute();

    return $requete->fetch(PDO::FETCH_ASSOC);
}
function ajouterCommentaire($titre_commentaire, $avis, $note, $date_commentaire)
{
    $pdo = getConnexion();
    try {
        // Préparation de la requête
        $requete = $pdo->prepare("INSERT INTO COMMENTAIRE (titre_commentaire, avis, note, date_commentaire) VALUES (?, ?, ?, ?)");

        // Exécution de la requête avec les valeurs des paramètres
        $requete->execute([$titre_commentaire, $avis, $note, $date_commentaire]);

        // Renvoie true si l'ajout a réussi
        return true;
    } catch (PDOException $e) {
        // En cas d'erreur, affiche un message d'erreur
        echo "Erreur lors de l'ajout du commentaire : " . $e->getMessage();
        // Renvoie false en cas d'erreur
        return false;
    }
}
