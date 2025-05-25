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
function detailVoiture() { 
    require_once __DIR__ . "/../DAL/voituresDAL.php";

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id_voiture'])) {
        echo json_encode([
            'message' => "Erreur dans l'envoi des données",
            'status' => 400
        ]);
        return;
    }

    $voiture = DAL_info_voiture('id_voiture', $data['id_voiture']);
    $json_voiture = array();

    $json_voiture[] = array(
        'id_voiture' => $voiture[0]->getId_voiture(),
        'modele' => $voiture[0]->getModele(),
        'plaque_immatriculation' => $voiture[0]->getPlaque_immatriculation(),
    );
    echo json_encode($json_voiture);
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
        $voiture = DAL_info_voiture('id_voiture', $e->getId_voiture());
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


// Emprunter une voiture ----------------------------------------------------------------------------------------------
function emprunterVoiture() { 
    require_once __DIR__ . "/../DAL/empruntsDAL.php";
    require_once __DIR__ . "/../Modeles/emprunt.php";

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id_voiture']) || !isset($data['id_utilisateur']) || !isset($data['date_debut'])) {
        echo json_encode([
            'message' => "Erreur dans l'envoi des données",
            'status' => 400
        ]);
        return;
    }

    $id_voiture_formulaire = $data['id_voiture'];
    $id_utilisateur_formulaire = $data['id_utilisateur'];
    $dated_formulaire = $data['date_debut'];

    $nouvel_emprunt = new Emprunt (
        null,
        $id_voiture_formulaire,
        $id_utilisateur_formulaire,
        $dated_formulaire,
        null // date_fin reste vide
    );

    DAL_ajouter_emprunt($nouvel_emprunt);
    $reponse_emprunt[] = array(
        'message' => 'Emprunt réussi',
        'status' => 201
    );
    echo json_encode($reponse_emprunt);
}


// Rendre une voiture
function rendreVoiture() {
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id_emprunt'])) {
        echo json_encode([
            'message' => "Erreur dans l'envoi des données",
            'status' => 400
        ]);
        return;
    }

    $id_emprunt_formulaire = $data['id_emprunt'];
    $date_fin = date('Y-m-d');

    DAL_date_fin_emprunt($id_emprunt_formulaire, $date_fin);
    $reponse_emprunt[] = array(
        'message' => 'Rendu voiture réussie',
        'status' => 201
    );
    echo json_encode($reponse_emprunt);
}

?>