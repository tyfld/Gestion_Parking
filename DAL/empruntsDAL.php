<?php

function DAL_lister_emprunts() {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from empruns";
    $requete = $conn->query($sql);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    if ($resultat) {
        return $resultat;
    } else {
        return null;
    }
}

function DAL_info_emprunt($id) {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from emprunts WHERE id_emprunt = :id";
    $requete = $conn->prepare($sql);
    $requete->execute(['id' => $id]);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function DAL_ajouter_emprunt($id_utilisateur, $id_voiture, $date_debut) {
    require __DIR__ . "/bdd.php";
    $hash_mdp = password_hash($mot_de_passe, PASSWORD_DEFAULT); // password_verify
    $sql = "INSERT INTO emprunts (id_utilisateur, id_voiture, date_debut)
            VALUES (:id_utilisateur, :id_voiture, :date_debut)";
    $requete = $conn->prepare($sql);
    $requete->execute(
        ['id_utilisateur' => $id_utilisateur], 
        ['id_voiture' => $id_voiture],
        ['date_debut' => $date_debut]);
    $requete->fetchAll(PDO::FETCH_ASSOC);
    return;
}

function DAL_date_fin_emprunt($date_fin) {
    require __DIR__ . "/bdd.php";
}

function DAL_modifier_emprunt() {
    require __DIR__ . "/bdd.php";
}

function DAL_supprimer_emprunt($id) {
    require __DIR__ . "/bdd.php";
}


echo "<p>DAL Emprunts</p>";

?>