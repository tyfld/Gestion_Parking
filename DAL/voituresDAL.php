<?php

//projets/app_etudiant/service-annonces/vueAnnonces/vueListeAnnonces.php
//projets/Gestion_Parking/DAL/voituresDAL.php


function DAL_lister_voitures() {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from voitures";
    $requete = $conn->query($sql);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    if ($resultat) {
        return $resultat;
    } else {
        return null;
    }
}

function DAL_info_voiture($id) {
    require __DIR__ . "/bdd.php";
    $sql = "SELECT * from voitures WHERE id_voiture = :id";
    $requete = $conn->prepare($sql);
    $requete->execute(['id' => $id]);
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
}

function DAL_ajouter_voiture($modele, $plaque_immatriculation) {
    require __DIR__ . "/bdd.php";
    $sql = "INSERT INTO voitures (modele, plaque_immatriculation)
            VALUES (:modele, :plaque_immatriculation)";
    $requete = $conn->prepare($sql);
    $requete->execute(
        ['modele' => $modele], 
        ['plaque_immatriculation' => $plaque_immatriculation]);
    $requete->fetchAll(PDO::FETCH_ASSOC);
    return;
}

function DAL_modifier_voiture() {
    require __DIR__ . "/bdd.php";
}

function DAL_supprimer_voiture($id) {
    require __DIR__ . "/bdd.php";
}


echo "<p>DAL Voitures</p>";

?>