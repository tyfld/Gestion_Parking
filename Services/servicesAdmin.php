<?php

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');


function verif_session_admin() {
    session_start();
    if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
        return true; // L'utilisateur est un admin
    } else {
        http_response_code(403);
        echo json_encode(['message' => 'Accès réservé aux administrateurs']);
        return false; // L'utilisateur n'est pas un admin
    }
}


// Gestion des voitures
function ajouter_voiture() {
    if (true) { // remplacer true par verifSessionAdmin()
        require_once __DIR__ . "/../DAL/voituresDAL.php";
        require_once __DIR__ . "/../Modeles/voiture.php";

        /*session_start();
        // s'il y a une session active et qu'il s'agit d'un role admin (1)
        if (!isset($_SESSION['id_utilisateur']) || !isset($_SESSION['role']) || $_SESSION['role'] != 1) {
            echo json_encode(array(
                'message' => 'Aucune session active ou accès interdit',
                'status' => 401
            ));
            return;
        }*/

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['modele']) || !isset($data['plaque_immatriculation'])) {
            echo json_encode([
                'message' => "Plaque d'immatriculation et/ou modèle requis",
                'status' => 400
            ]);
            return;
        }

        $modele_formulaire = $data['modele'];
        $plaque_formulaire = $data['plaque_immatriculation'];

        // Vérification email disponible
        $voiture = DAL_info_voiture('plaque_immatriculation', $plaque_formulaire);
        $reponse_erreur_voiture = array();
        if (isset($voiture[0]) && $plaque_formulaire == $voiture[0]->get_plaque_immatriculation()) {
            $reponse_inscription[] = array(
                'message' => "Plaque d'immatriculation déjà utilisé",
                'status' => 409
            );
            echo json_encode($reponse_erreur_voiture);
            return;
        }

        $nouvelle_voiture = new Voiture (
            null,
            $modele_formulaire,
            $plaque_formulaire
        );

        DAL_ajouter_voiture($nouvelle_voiture);
        $reponse_voiture[] = array(
            'message' => 'Nouvelle voiture créée avec succès',
            'status' => 201
        );
        echo json_encode($reponse_voiture);
    } else return;
}


function modifier_voiture() {
    if (true) { // remplacer true par verifSessionAdmin()
        require_once __DIR__ . "/../DAL/voituresDAL.php";
        require_once __DIR__ . "/../Modeles/voiture.php";

        /*session_start();
        // s'il y a une session active et qu'il s'agit d'un role admin (1)
        if (!isset($_SESSION['id_utilisateur']) || !isset($_SESSION['role']) || $_SESSION['role'] != 1) {
            echo json_encode(array(
                'message' => 'Aucune session active ou accès interdit',
                'status' => 401
            ));
            return;
        }*/

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['id_voiture'])) {
            echo json_encode([
                'message' => "ID de la voiture requis",
                'status' => 400
            ]);
            return;
        }

        $info_voiture_actuelle = DAL_info_voiture("id_voiture", $data['id_voiture']);
        $modele_voiture = $info_voiture_actuelle[0]->get_modele();
        $plaque_voiture = $info_voiture_actuelle[0]->get_plaque_immatriculation();

        if (isset($data['modele'])) {
            $modele_voiture = $data['modele'];
        }
        if (isset($data['plaque_immatriculation'])) {
            $plaque_voiture = $data['plaque_immatriculation'];
        }

        $modification_voiture = new Voiture(
            $data['id_voiture'],
            $modele_voiture,
            $plaque_voiture
        );

        DAL_modifier_voiture($modification_voiture);
            $reponse_modification[] = array(
            'message' => 'Modification réussie',
            'status' => 201
        );
        echo json_encode($reponse_modification);

    } else return;
}


function supprimer_voiture() {
    if (true) { // remplacer true par verifSessionAdmin()
        require_once __DIR__ . "/../DAL/voituresDAL.php";
        require_once __DIR__ . "/../DAL/empruntsDAL.php";

        /*session_start();
        // s'il y a une session active et qu'il s'agit d'un role admin (1)
        if (!isset($_SESSION['id_utilisateur']) || !isset($_SESSION['role']) || $_SESSION['role'] != 1) {
            echo json_encode(array(
                'message' => 'Aucune session active ou accès interdit',
                'status' => 401
            ));
            return;
        }*/

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['id_voiture'])) {
            echo json_encode([
                'message' => "ID de la voiture requis",
                'status' => 400
            ]);
            return;
        }

        $id_voiture = $data['id_voiture'];

        DAL_supprimer_emprunt_voiture($id_voiture); // Suppression des emprunts liés à la voiture

        DAL_supprimer_voiture($id_voiture);
        $reponse_suppression[] = array(
            'message' => 'Suppression réussie',
            'status' => 200
        );

        echo json_encode($reponse_suppression);
    } else return;
}


// Création d'un compte admin -----------------------------------------------------------------------------------------
function nouvel_admin() {
    if (verif_session_admin()) {
        require_once __DIR__ . "/../DAL/utilisateursDAL.php";
        require_once __DIR__ . "/../Modeles/utilisateur.php";

        /*session_start();
        // s'il y a une session active et qu'il s'agit d'un role admin (1)
        if (!isset($_SESSION['id_utilisateur']) || !isset($_SESSION['role']) || $_SESSION['role'] != 1) {
            echo json_encode(array(
                'message' => 'Aucune session active ou accès interdit',
                'status' => 401
            ));
            return;
        }*/

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['nom']) || !isset($data['email']) || !isset($data['mot_de_passe'])) {
            echo json_encode([
                'message' => "Nom d'utilisateur, email et/ou mot de passe requis",
                'status' => 400
            ]);
            return;
        }

        $nom_formulaire = $data['nom'];
        $email_formulaire = $data['email'];
        $mdp_formulaire = $data['mot_de_passe'];
        $mdp_securise = password_hash($mdp_formulaire, PASSWORD_DEFAULT);

        // Vérification email disponible
        $utilisateur = DAL_info_utilisateur("email", $email_formulaire);
        $reponse_inscription = array();
        if (isset($utilisateur[0]) && $email_formulaire == $utilisateur[0]->get_email()) {
            $reponse_inscription[] = array(
                'message' => 'Email déjà utilisé',
                'status' => 409
            );
            echo json_encode($reponse_inscription);
            return;
        }

        $nouvel_utilisateur = new Utilisateur (
            null,
            $nom_formulaire,
            $email_formulaire,
            $mdp_securise,
            1 //admin
        );

        DAL_ajouter_utilisateur($nouvel_utilisateur);
        $reponse_inscription[] = array(
            'message' => 'Nouveau compte administrateur créé avec succès',
            'status' => 201
        );
        echo json_encode($reponse_inscription);
    } else return;
    
}

?>