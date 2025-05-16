<?php

function DAL_lister_utilisateurs() {
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
                $utilisateur['prenom'],
                $utilisateur['email'],
                $utilisateur['mot_de_passe'],
                $utilisateur['role_utilisateur'],);
            $liste_utilisateurs[] = $objet_utilisateur;
        }
    }
    return $liste_utilisateurs;
}

function DAL_info_utilisateur($id) {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from utilisateurs WHERE id_utilisateur = :id";
    $requete = $conn->prepare($sql);
    $requete->execute(['id' => $id]);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function DAL_ajouter_utilisateur($nom, $prenom, $email, $mot_de_passe) {
    require __DIR__ . "/bdd.php";
    $hash_mdp = password_hash($mot_de_passe, PASSWORD_DEFAULT); // password_verify
    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role_utilisateur)
            VALUES (:nom, :prenom, :email, :mot_de_passe, 'ROLE_USER')";
    $requete = $conn->prepare($sql);
    $requete->execute(
        ['nom' => $nom], 
        ['prenom' => $prenom],
        ['email' => $email],
        ['mot_de_passe' => $hash_mdp]);
    $requete->fetchAll(PDO::FETCH_ASSOC);
    return;
}

// TODO
function DAL_modifier_utilisateur() {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

// TODO
function DAL_supprimer_utilisateur($id) {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

// TODO
function DAL_connexion_utilisateur($email, $mot_de_passe) {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}


echo "<p>DAL Utilisateurs</p>";

?>