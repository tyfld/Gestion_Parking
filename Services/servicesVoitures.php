<?php

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');


// Lister les voitures ainsi que leur disponibilité
function listerVoiture() {
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


// Afficher les informations d'une voiture ainsi que sa disponibilité
function detailVoiture(){
    echo json_encode(array('details-voiture' => 'TODO'));
}


// Afficher la liste des voitures qui ont été empruntées par un utilisateur
function empruntHistoriqueUtilisateur() {
    require_once __DIR__ . "/../DAL/voituresDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    session_start();
    $id_session = $_SESSION['id_utilisateur'];

    $emprunts = DAL_emprunt_historique("id_utilisateur", $id_session);
    $json_emprunts = array();

    // liste des voitures pour les emprunt trouvés
    foreach ($emprunts as $e) {
        $voiture = DAL_info_voiture($e->getId_voiture());
        $json_emprunts[] = array(
            'id_voiture' =>$e->getId_voiture(),
            'modele' => $voiture[0]->getModele(),
            'plaque_immatriculation' => $voiture[0]->getPlaque_immatriculation(),
            'date_debut' => $e->getDate_debut(),
            'date_fin' => $e->getDate_fin(),
        );
    }
    echo json_encode($json_emprunts);
}


// Historique des emprunts d'une voiture
function empruntHistoriqueVoiture() {
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $id_voiture = 1;

    $emprunts = DAL_emprunt_historique("id_voiture", $id_voiture);
    $json_emprunts = array();

    // liste des voitures pour les emprunt trouvés
    foreach ($emprunts as $e) {
        $utilisateur = DAL_info_utilisateur("id_utilisateur", $e->getId_utilisateur());
        $json_emprunts[] = array(
            'nom_utilisateur' => $utilisateur[0]->getNom(),
            'date_debut' => $e->getDate_debut(),
            'date_fin' => $e->getDate_fin(),
        );
    }
    echo json_encode($json_emprunts);
}

?>