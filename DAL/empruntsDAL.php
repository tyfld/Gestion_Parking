<?php

function DAL_lister_emprunts() {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from emprunst";
    $requete = $conn->query($sql);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $liste_emprunts = [];
    if ($resultat) {
        require_once __DIR__ . "/../Modeles/emprunt.php";
        foreach ($resultat as $emprunt) {
            $objet_emprunt = new Emprunt(
                $emprunt['id_emprunt'],
                $emprunt['id_voiture'],
                $emprunt['id_utilisateur'],
                $emprunt['date_debut'],
                $emprunt['date_fin']);
            $liste_emprunts[] = $objet_emprunt;
        }
    }
    return $liste_emprunts;
}

function DAL_lister_emprunts_en_cours() {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from emprunts WHERE date_fin IS NULL";
    $requete = $conn->query($sql);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $liste_emprunts = [];
    if ($resultat) {
        require_once __DIR__ . "/../Modeles/emprunt.php";
        foreach ($resultat as $emprunt) {
            $objet_emprunt = new Emprunt(
                $emprunt['id_emprunt'],
                $emprunt['id_voiture'],
                $emprunt['id_utilisateur'],
                $emprunt['date_debut'],
                $emprunt['date_fin']);
            $liste_emprunts[] = $objet_emprunt;
        }
    }
    return $liste_emprunts;
}

function DAL_info_emprunt_utilisateur($id) {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from emprunts WHERE id_utilisateur = :id AND date_fin IS NULL";
    $requete = $conn->prepare($sql);
    $requete->execute(['id' => $id]);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $liste_emprunts = [];
    if ($resultat) {
        require_once __DIR__ . "/../Modeles/emprunt.php";
        foreach ($resultat as $emprunt) {
            $objet_emprunt = new Emprunt(
                $emprunt['id_emprunt'],
                $emprunt['id_voiture'],
                $emprunt['id_utilisateur'],
                $emprunt['date_debut'],
                $emprunt['date_fin']);
            $liste_emprunts[] = $objet_emprunt;
        }
    }
    return $liste_emprunts;
}

function DAL_ajouter_emprunt($id_utilisateur, $id_voiture, $date_debut) {
    require __DIR__ . "/bdd.php";
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

// TODO
function DAL_date_fin_emprunt($date_fin) {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

// TODO
function DAL_modifier_emprunt() {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

// TODO
function DAL_supprimer_emprunt($id) {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

?>