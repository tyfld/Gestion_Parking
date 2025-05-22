<?php

function DAL_lister_utilisateurs() { // liste des utilisateurs
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from utilisateurs";
    $requete = $conn->query($sql);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $liste_utilisateurs = [];
    if ($resultat) {
        require_once __DIR__ . "/../Modeles/utilisateur.php";
        foreach ($resultat as $utilisateur) {
            $objet_utilisateur = new Utilisateur(
                $utilisateur['id_utilisateur'],
                $utilisateur['nom'],
                $utilisateur['email'],
                $utilisateur['mot_de_passe'],
                $utilisateur['role_utilisateur'],);
            $liste_utilisateurs[] = $objet_utilisateur;
        }
    }
    return $liste_utilisateurs;
}

function DAL_info_utilisateur($colonne, $valeur) { // info d'un utilisateur (par id)
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from utilisateurs WHERE $colonne = :valeur";
    $requete = $conn->prepare($sql);
    $requete->execute(['valeur' => $valeur]);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $liste_utilisateurs = [];
    if ($resultat) {
        require_once __DIR__ . "/../Modeles/utilisateur.php";
        foreach ($resultat as $utilisateur) {
            $objet_utilisateur = new Utilisateur(
                $utilisateur['id_utilisateur'],
                $utilisateur['nom'],
                $utilisateur['email'],
                $utilisateur['mot_de_passe'],
                $utilisateur['role_utilisateur'],);
            $liste_utilisateurs[] = $objet_utilisateur;
        }
    }
    return $liste_utilisateurs;
}

function DAL_ajouter_utilisateur($nouvel_utilisateur) { // ajout d'un utilisateur à la bdd
    require __DIR__ . "/bdd.php";
    require_once __DIR__ . "/../Modeles/utilisateur.php";

    $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, role_utilisateur)
            VALUES (:nom, :email, :mot_de_passe, 0)";
    $requete = $conn->prepare($sql);
    $requete->execute([
        'nom' => $nouvel_utilisateur->getNom(),
        'email' => $nouvel_utilisateur->getEmail(),
        'mot_de_passe' => $nouvel_utilisateur->getMdp()
    ]);
    $requete->fetchAll(PDO::FETCH_ASSOC);
    return;
}

// TODO
function DAL_modifier_utilisateur() { // modification d'un utilisateur
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

// TODO
function DAL_supprimer_utilisateur($id) { // suppression d'un utilisateur
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

// TODO pas besoin, géré par le sevice
function DAL_connexion_utilisateur($email, $mot_de_passe) {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

?>