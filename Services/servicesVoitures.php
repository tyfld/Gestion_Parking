<?php

header('Content-Type: application/json');

function listerVoiture() { // Lister les voitures ainsi que leur disponibilité
    require_once __DIR__ . "/../DAL/voituresDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $voiture = DAL_lister_voitures();
    $emprunt = DAL_lister_emprunts_en_cours();
    $json_voiture = array();

    foreach ($voiture as $v) {
        $disponible = true;
        foreach ($emprunt as $e) {
            if ($v->getId_voiture() == $e->getId_voiture()) {
                $disponible = false;
                break;
            }
        }
        $json_voiture[] = array(
            'id_voiture' => $v->getId_voiture(),
            'modele' => $v-> getModele(),
            'plaque-immatriculation' => $v->getPlaque_immatriculation(),
            'disponible' => $disponible
            );
    }
    echo json_encode($json_voiture);
}

function detailVoiture(){
    //
}

?>