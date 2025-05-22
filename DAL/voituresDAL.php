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
function DAL_info_voiture($id) {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from voitures WHERE id_voiture = :id";
    $requete = $conn->prepare($sql);
    $requete->execute(['id' => $id]);
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
function DAL_ajouter_voiture($modele, $plaque_immatriculation) {
    require __DIR__ . "/bdd.php";
    $sql = "INSERT INTO voitures (modele, plaque_immatriculation)
            VALUES (:modele, :plaque_immatriculation)";
    $requete = $conn->prepare($sql);
    $requete->execute(
        ['modele' => $modele], 
        ['plaque_immatriculation' => $plaque_immatriculation]);
    return;
}


// TODO
// Doit être utilisé que par un admin
function DAL_modifier_voiture($id, $nouveau_modele, $nouvelle_plaque) {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}


// TODO
// Doit être utilisé que par un admin
function DAL_supprimer_voiture($id) {
    require __DIR__ . "/bdd.php";
    $sql = "";
    $requete = $conn->prepare($sql);
    $requete->execute();
    return;
}

?>