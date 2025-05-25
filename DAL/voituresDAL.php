<?php

function DAL_lister_voitures() {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from voitures";
    $requete = $conn->query($sql);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $liste_voitures = [];
    if ($resultat) {
        require_once __DIR__ . "/../Modeles/voiture.php";
        foreach ($resultat as $voiture) {
            $objet_voiture = new Voiture(
                $voiture['id_voiture'],
                $voiture['modele'],
                $voiture['plaque_immatriculation']);
            $liste_voitures[] = $objet_voiture;
        }
    }
    return $liste_voitures;
}

// Récupère les infos d'une voiture (par son id)
function DAL_info_voiture($colonne, $valeur) {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from voitures WHERE $colonne = :valeur";
    $requete = $conn->prepare($sql);
    $requete->execute(['valeur' => $valeur]);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    $liste_voitures = [];
    if ($resultat) {
        require_once __DIR__ . "/../Modeles/voiture.php";
        foreach ($resultat as $voiture) {
            $objet_voiture = new Voiture(
                $voiture['id_voiture'],
                $voiture['modele'],
                $voiture['plaque_immatriculation']);
            $liste_voitures[] = $objet_voiture;
        }
    }
    return $liste_voitures;
}


// TODO
// Doit être utilisé que par un admin
function DAL_ajouter_voiture($voiture) {
    require __DIR__ . "/bdd.php";
    $sql = "INSERT INTO voitures (modele, plaque_immatriculation)
            VALUES (:modele, :plaque_immatriculation)";
    $requete = $conn->prepare($sql);
    $requete->execute([
        'modele' => $voiture->getModele(),
        'plaque_immatriculation' => $voiture->getPlaque_immatriculation()
    ]);
    return;
}


// TODO
// Doit être utilisé que par un admin
function DAL_modifier_voiture($modif_voiture) {
    require __DIR__ . "/bdd.php";
    
    $sql = "UPDATE voitures
            SET modele = :modele, plaque_immatriculation = :plaque_immatriculation
            WHERE id_voiture = :id_voiture";
    $requete = $conn->prepare($sql);
    $requete->execute([
        'modele' => $modif_voiture->getModele(),
        'plaque_immatriculation' => $modif_voiture->getPlaque_immatriculation(),
        'id_voiture' => $modif_voiture->getId_voiture()
    ]);
    return;
}


// TODO
// Doit être utilisé que par un admin
function DAL_supprimer_voiture($id_voiture) {
    require __DIR__ . "/bdd.php";
    $sql = "DELETE FROM voitures WHERE id_voiture = :id_voiture";
    $requete = $conn->prepare($sql);
    $requete->execute(['id_voiture' => $id_voiture]);
    return;
}

?>