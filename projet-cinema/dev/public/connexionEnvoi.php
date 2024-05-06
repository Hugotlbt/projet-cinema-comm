<?php
// 1. Connexion à la base de donnée db_intro
/**
 * @var PDO $pdo
 */
require 'db-config.php';
//test utilisateur
$entreeUtilisateur="utilisateur1";
$pseudoUtilisateur="pseudo";
$entreeMotdepasseUtilisateur="1223";
// 2. Préparation de la requête
$requete = $pdo->prepare(query: "INSERT INTO `utilisateur` (`id_utilisateur`, `pseudo_utilisateur`, `email_utilisateur`, `mdp_utilisateur`) VALUES (2, '$pseudoUtilisateur', '$entreeUtilisateur', '$entreeMotdepasseUtilisateur')");

// 3. Exécution de la requête
$requete->execute();

// 4. Récupération des enregistrements
// Un enregistrement = un tableau associatif
$utilisateurs = $requete->fetchAll(PDO::FETCH_ASSOC);

//PRENDRE
$connexionPDO = new PDO('mysql:host=127.0.0.1;dbname=bdd_cs1;charset=UTF8', "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

echo "\nPseudo :";
$pseudo = readline();

echo "\nMot de passe :";
$motDePasse = readline();

echo "\nType de compte :";
$typeCompte = readline();

$requetePreparee = $connexionPDO->prepare(
    'INSERT INTO `utilisateur` ( `pseudo`, `motDePasse`, `typeCompte`)
        VALUES (:parampseudo, :parammotDePasse, :paramtypeCompte);');

$requetePreparee->bindParam('parampseudo', $pseudo);
$motDePasseHaché = md5($motDePasse);
$requetePreparee->bindParam('parammotDePasse', $motDePasseHaché);
$requetePreparee->bindParam('paramtypeCompte', $typeCompte);
$reponse = $requetePreparee->execute(); //$reponse boolean sur l'état de la requête
$idUtilisateur = $connexionPDO->lastInsertId();
echo "\nL'utilisateur porte le numéro $idUtilisateur";

//TESTER

echo "\nPseudo :";
$pseudo = readline();

echo "\nMot de passe :";
$motDePasseProposé = readline();

// connexion a la BDD
$connexionPDO = new PDO('mysql:host=127.0.0.1;dbname=bdd_cs1;charset=UTF8', "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

$requetePreparee = $connexionPDO->prepare('select * from `utilisateur` where pseudo = :paramPseudo');
$requetePreparee->bindParam('paramPseudo', $pseudo);
$reponse = $requetePreparee->execute(); //$reponse boolean sur l'état de la requête
$utilisateur = $requetePreparee->fetch(PDO::FETCH_ASSOC);

if ($utilisateur <> null) {
    echo "Utilisateur n°$utilisateur[idUser] trouvé";
    if (md5($motDePasseProposé) == $utilisateur["motDePasse"]) {
        echo "\n connexion OK";
    } else {
        echo "\n Echec connexion";
    }
} else{// mdp pas mis }