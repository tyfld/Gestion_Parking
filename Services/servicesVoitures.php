<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: http://localhost:5173');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    http_response_code(200);
    exit();
}

require_once __DIR__ . "/session.php";


// Lister les voitures ainsi que leur disponibilité
function lister_voiture() {
    require_once __DIR__ . "/../DAL/voituresDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $voiture = DAL_lister_voitures();
    $emprunt = DAL_lister_emprunts_en_cours();
    $json_voiture = array();

    foreach ($voiture as $v) {
        $disponible = true;
        $id_utilisateur;
        foreach ($emprunt as $e) {
            $id_utilisateur = $e->get_id_utilisateur();
            if ($v->get_id_voiture() == $e->get_id_voiture()) {
                $disponible = false;
                break;
            }
        }
        $json_voiture[] = array(
            'id_voiture' => $v->get_id_voiture(),
            'id_utilisateur' => $id_utilisateur,
            'modele' => $v-> get_modele(),
            'plaque_immatriculation' => $v->get_plaque_immatriculation(),
            'disponible' => $disponible
            );
    }
    echo json_encode($json_voiture);
}

// idem mais pour une voiture précise
function disponible_voiture() {
    require_once __DIR__ . "/../DAL/voituresDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $data = json_decode(file_get_contents('php://input'), true);

    $voiture = DAL_lister_voitures();
    $emprunt = DAL_lister_emprunts_en_cours();
    $json_voiture = array();

    foreach ($voiture as $v) {

        if ($v->get_id_voiture() == $data['id_voiture']) {
            $disponible = true;
            $id_utilisateur = null;
            $id_emprunt = null;
            foreach ($emprunt as $e) {
                $id_utilisateur = $e->get_id_utilisateur();
                $id_emprunt = $e->get_id_emprunt();
                if ($v->get_id_voiture() == $e->get_id_voiture()) {
                    $disponible = false;
                    break;
                }
            }
            $json_voiture[] = array(
                'id_emprunt' => $id_emprunt,
                'id_voiture' => $v->get_id_voiture(),
                'id_utilisateur' => $id_utilisateur,
                'modele' => $v-> get_modele(),
                'plaque_immatriculation' => $v->get_plaque_immatriculation(),
                'disponible' => $disponible
                );
        }
    }
    echo json_encode($json_voiture[0]);
}


// Afficher les informations d'une voiture ainsi que sa disponibilité
function detail_voiture() { 
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
        'id_voiture' => $voiture[0]->get_id_voiture(),
        'modele' => $voiture[0]->get_modele(),
        'plaque_immatriculation' => $voiture[0]->get_plaque_immatriculation(),
    );
    echo json_encode($json_voiture[0]);
}



// Afficher la liste des voitures qui ont été empruntées par un utilisateur
function emprunt_historique_utilisateur() {
    require_once __DIR__ . "/../DAL/voituresDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $id_session = $_SESSION['id_utilisateur'];

    $emprunts = DAL_emprunt_historique("id_utilisateur", $id_session);
    $json_emprunts = array();

    // liste des voitures pour les emprunt trouvés
    foreach ($emprunts as $e) {
        $voiture = DAL_info_voiture('id_voiture', $e->get_id_voiture());
        $json_emprunts[] = array(
            'id_voiture' =>$e->get_id_voiture(),
            'modele' => $voiture[0]->get_modele(),
            'plaque_immatriculation' => $voiture[0]->get_plaque_immatriculation(),
            'date_debut' => $e->get_date_debut(),
            'date_fin' => $e->get_date_fin(),
        );
    }
    echo json_encode($json_emprunts);
}


// Historique des emprunts d'une voiture
function emprunt_historique_voiture() {
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $data = json_decode(file_get_contents('php://input'), true);

    $emprunts = DAL_emprunt_historique("id_voiture", $data['id_voiture']);
    $json_emprunts = array();

    // liste des voitures pour les emprunt trouvés
    foreach ($emprunts as $e) {
        $utilisateur = DAL_info_utilisateur("id_utilisateur", $e->get_id_utilisateur());
        $json_emprunts[] = array(
            'nom_utilisateur' => $utilisateur[0]->get_nom(),
            'date_debut' => $e->get_date_debut(),
            'date_fin' => $e->get_date_fin(),
        );
    }
    echo json_encode($json_emprunts);
}


// Emprunter une voiture ----------------------------------------------------------------------------------------------
function emprunter_voiture() { 
    require_once __DIR__ . "/../DAL/empruntsDAL.php";
    require_once __DIR__ . "/../Modeles/emprunt.php";

    $data = json_decode(file_get_contents('php://input'), true);

    $reponse_emprunt = array();

    if (!isset($data['id_voiture']) || !isset($data['id_utilisateur'])) {
        $reponse_emprunt[] = array(
            'message' => "Erreur dans l'envoi des données",
            'success' => false,
            'status' => 400
        );
        echo json_encode($reponse_emprunt[0]);
        return;
    }

    $id_voiture_formulaire = $data['id_voiture'];
    $id_utilisateur_formulaire = $data['id_utilisateur'];
    $date_debut = date('Y-m-d');

    $nouvel_emprunt = new Emprunt (
        null,
        $id_voiture_formulaire,
        $id_utilisateur_formulaire,
        $date_debut,
        null // date_fin reste vide
    );

    DAL_ajouter_emprunt($nouvel_emprunt);
    $reponse_emprunt[] = array(
        'message' => 'Emprunt réussi',
        'success' => true,
        'status' => 201
    );
    echo json_encode($reponse_emprunt[0]);
}


// Rendre une voiture
function rendre_voiture() {
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['id_emprunt'])) {
        echo json_encode([
            'message' => "Erreur dans l'envoi des données",
            'success' => false,
            'status' => 400
        ]);
        return;
    }

    $id_emprunt_formulaire = $data['id_emprunt'];
    $date_fin = date('Y-m-d');

    DAL_date_fin_emprunt($id_emprunt_formulaire, $date_fin);
    $reponse_emprunt[] = array(
        'message' => 'La voiture à été rendue',
        'success' => true,
        'status' => 201
    );
    echo json_encode($reponse_emprunt[0]);
}

?>