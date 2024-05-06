<?php
require_once '../base.php';
require_once BASE_PROJET . '/src/config/db-config.php';

// Fonction permettant de récupérer tous les utilisateurs


function getUser($email_utilisateur): array
{
    $pdo = getConnexion();
    $requete_email = $pdo->prepare("SELECT * FROM utilisateur WHERE email_utilisateur=?");
    $requete_email->execute([$email_utilisateur]);
    $user = $requete_email->fetchAll(PDO::FETCH_ASSOC);
    return $user;
}

function postUser($pseudo_utilisateur, $email_utilisateur, $mdp_utilisateur): void
{
    $pdo = getConnexion();
    $requete = $pdo->prepare(query: "INSERT INTO utilisateur (pseudo_utilisateur, email_utilisateur, mdp_utilisateur) VALUES (?, ?, ?)");

    $requete->bindParam(1, $pseudo_utilisateur);
    $requete->bindParam(2, $email_utilisateur);
    $requete->bindParam(3, password_hash($mdp_utilisateur, PASSWORD_DEFAULT));

    // 3. Exécution de la requête
    $requete->execute();
}

function getMdp($email_utilisateur): array|bool
{
    $pdo = getConnexion();
    $requete_mdp = $pdo->prepare("SELECT mdp_utilisateur FROM utilisateur WHERE email_utilisateur=?");
    $requete_mdp->execute([$email_utilisateur]);
    $mdp = $requete_mdp->fetch(PDO::FETCH_ASSOC);
    return $mdp;
}


function checkPassword($email, $password): bool
{
    $pdo = getConnexion();
    $query = "SELECT mdp_utilisateur FROM utilisateur WHERE email_utilisateur = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $hashedPassword = $stmt->fetchColumn();

    return $hashedPassword !== false && password_verify($password, $hashedPassword);
}

function InscriptionUtilisateur($pseudo_utilisateur, $email_utilisateur, $mdp_utilisateur, $mdp_utilisateurCheck, $pdo) {
    $erreurs = [];

    // Validation des données
    if (empty($pseudo_utilisateur)) {
        $erreurs['pseudo_utilisateur'] = "Le nom est obligatoire";
    }
    if (empty($email_utilisateur)) {
        $erreurs['email_utilisateur'] = "L'email est obligatoire";
    } elseif (!filter_var($email_utilisateur, FILTER_VALIDATE_EMAIL)) {
        $erreurs['email_utilisateur'] = "L'email n'est pas valide";
    }
    if (empty($mdp_utilisateur)) {
        $erreurs['mdp_utilisateur'] = "Le mot de passe est obligatoire";
    }
    if (strlen($mdp_utilisateur) <= 7){
        $erreurs['mdp_utilisateur'] = "Le mot de passe doit faire plus de 7 characters";
    }
    if (empty($mdp_utilisateurCheck)) {
        $erreurs['mdp_utilisateurCheck'] = "Confirmer le mot de passe est obligatoire";
    }
    if ($mdp_utilisateur != $mdp_utilisateurCheck) {
        $erreurs['mdp_utilisateurCheck'] = "Les mots de passe ne correspondent pas";
    }

    if (empty($erreurs)) {
        // Hachage du mot de passe
        $hashedPassword = password_hash($mdp_utilisateur, PASSWORD_DEFAULT);

        // Insertion des données dans la base de données
        $query = "INSERT INTO utilisateur (pseudo_utilisateur, email_utilisateur, mdp_utilisateur) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$pseudo_utilisateur, $email_utilisateur, $hashedPassword]);

        // Redirection après inscription
        header("Location: ./index.php");
        exit();
    }

    return $erreurs;
}

function getPseudoByEmail($email)
{
    $pdo = getConnexion();
    $query = "SELECT pseudo_utilisateur FROM utilisateur WHERE email_utilisateur = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['pseudo_utilisateur'];
}

// Voir si mail deja associé à un compte
function getUserByEmail($email_utilisateur)
{
    $pdo = getConnexion();
    $requete_email = $pdo->prepare("SELECT * FROM utilisateur WHERE email_utilisateur = ?");
    $requete_email->execute([$email_utilisateur]);
    $utilisateur = $requete_email->fetch(PDO::FETCH_ASSOC);
    return $utilisateur;
}

function getUserByPseudo($pseudo_utilisateur)
{
    $pdo = getConnexion();
    $requete_pseudo = $pdo->prepare("SELECT * FROM utilisateur WHERE pseudo_utilisateur = ?");
    $requete_pseudo->execute([$pseudo_utilisateur]);
    $utilisateur = $requete_pseudo->fetch(PDO::FETCH_ASSOC);
    return $utilisateur;
}