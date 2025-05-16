<?php

function DAL_lister_utilisateurs() {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from utilisateurs";
    $requete = $conn->query($sql);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    if ($resultat) {
        return $resultat;
    } else {
        return null;
    }
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

function DAL_modifier_utilisateur() {
    require __DIR__ . "/bdd.php";
}

function DAL_supprimer_utilisateur($id) {
    require __DIR__ . "/bdd.php";
}

function DAL_connexion_utilisateur($email, $mot_de_passe) {
    require __DIR__ . "/bdd.php";
}


echo "<p>DAL Utilisateurs</p>";

?>