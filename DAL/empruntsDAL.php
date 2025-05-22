<?php

// Liste de tous les emprunts
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


// Récupère la liste des emprunts en cours de tout les utilisateurs
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


// Récupère l'emprunt en cours d'un utilisateur
function DAL_emprunt_en_cours_utilisateur($id_utilisateur) {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * FROM emprunts WHERE id_utilisateur = :id AND date_fin IS NULL";
    $requete = $conn->prepare($sql);
    $requete->execute(['id' => $id_utilisateur]);
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


// Récupère tous les emprunts d'un utilisateur (anciens et actuel)
function DAL_emprunt_historique($colonne, $valeur) {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * FROM emprunts WHERE $colonne = :valeur";
    $requete = $conn->prepare($sql);
    $requete->execute(['valeur' => $valeur]);
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


// Ajout d'un emprunt à la bdd
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


// Fin d'un emprunt en ajoutant une date de fin
function DAL_date_fin_emprunt($date_fin) {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}


// Modification d'un emprunt (normalement non utilisé dans le code)
function DAL_modifier_emprunt() {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

// Suppression d'un emprunt (normalement non utilisé dans le code car sauvegarde historique des emprunts)
function DAL_supprimer_emprunt() {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

?>