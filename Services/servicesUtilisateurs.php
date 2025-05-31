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


// Vérifier pour le front si une session est active -------------------------------------------------------------------
function verif_session() {
    $session = array();
    if (isset($_SESSION['id_utilisateur']))  {
        $session[] = array(
            'session' => true,
            'id_utilisateur' => $_SESSION['id_utilisateur'],
            'role' => $_SESSION['role_utilisateur'],
            'token' => $_SESSION['csrf_token'],
        );
    } else {
        $session[] = array(
            'session' => false,
        );
    }
    echo json_encode($session[0]);
}



// Inscription d'un utilisateur ---------------------------------------------------------------------------------------
function inscription() { 
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";
    require_once __DIR__ . "/../Modeles/utilisateur.php";

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['nom']) || !isset($data['email']) || !isset($data['mot_de_passe'])) {
        echo json_encode([
            'message' => "Nom d'utilisateur, email et/ou mot de passe requis",
            'success' => false,
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
        echo json_encode($reponse_inscription[0]);
        return;
    }

    $nouvel_utilisateur = new Utilisateur (
        null,
        $nom_formulaire,
        $email_formulaire,
        $mdp_securise,
        0
    );

    DAL_ajouter_utilisateur($nouvel_utilisateur);
    $reponse_inscription[] = array(
        'message' => 'Inscription réussie',
        'success' => true,
        'status' => 201
    );
    echo json_encode($reponse_inscription[0]);
}


// Connexion de l'utilisateur -----------------------------------------------------------------------------------------
function connexion() { 
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['email']) || !isset($data['mot_de_passe'])) {
        echo json_encode([
            'message' => 'Email et mot de passe requis',
            'success' => false,
            'status' => 400
        ]);
        return;
    }

    $email_formulaire = $data['email'];
    $mdp_formulaire = $data['mot_de_passe'];

    $utilisateur = DAL_info_utilisateur("email", $email_formulaire);
    $reponse_connexion = array();

    //Gestion de la session
    if (isset($utilisateur[0]) && $email_formulaire == $utilisateur[0]->get_email() && password_verify($mdp_formulaire, $utilisateur[0]->get_mdp())) {
        $_SESSION['id_utilisateur'] = $utilisateur[0]->get_id_utilisateur();
        $_SESSION['role_utilisateur'] = $utilisateur[0]->get_role();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $reponse_connexion[] = array(
            'message' => 'Connexion réussie',
            'success' => true,
            'status' => 200
        );
        
    } else {
        $reponse_connexion[] = array(
            'message' => 'Identifiants incorrects',
            'success' => false,
            'status' => 401
        );
    }
    echo json_encode($reponse_connexion[0]);
}


function connexion_test() { 
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $email_formulaire = "mail1@gmail.com";
    $mdp_formulaire = "mot2passe";

    $utilisateur = DAL_info_utilisateur("email", $email_formulaire);
    $reponse_connexion = array();

    // if ($emailTest == $utilisateur[0]->getEmail() && password_verify($mdpTest, $utilisateur[0]->getMdp())) {
    if ($email_formulaire == $utilisateur[0]->get_email() && $mdp_formulaire == $utilisateur[0]->get_mdp()) {
        $_SESSION['id_utilisateur'] = $utilisateur[0]->get_id_utilisateur();
        $_SESSION['role_utilisateur'] = $utilisateur[0]->get_role();
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $reponse_connexion[] = array(
            'message' => 'Connexion réussie',
            'status' => 200
        );
        
    } else {
        $reponse_connexion[] = array(
            'message' => 'Idntifiants incorrects',
            'status' => 401
        );
    }
    echo json_encode($reponse_connexion);
}


function deconnexion() {
    session_unset();
    session_destroy();

    $message_deconnexion = array();

    $message_deconnexion[] = array(
        'message' => 'Déconnexion réussie',
        'status' => 200
    );

    echo json_encode($message_deconnexion[0]);
}


// Gestion des tokens -------------------------------------------------------------------------------------------------
// TODO : gestion des tokens
function get_token_CSRF() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    //renvoyer token
    echo json_encode(array(
        'csrf_token' => $_SESSION['csrf_token'],
        'status' => 200
    ));
}

function verif_token_CSRF() {
    // TODO
}


// Envoi des information de l'utilisateur connecté --------------------------------------------------------------------
function profil_utilisateur() { 
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";

    if (!isset($_SESSION['id_utilisateur'])) {
        echo json_encode(array(
            'message' => 'Aucune session active',
            'status' => 401
        ));
        return;
    }

    $id_session = $_SESSION['id_utilisateur'];

    $utilisateur = DAL_info_utilisateur("id_utilisateur", $id_session);
    $json_utilisateur = array();

    $json_utilisateur[] = array(
        'id_utilisateur' => $utilisateur[0]->get_id_utilisateur(),
        'nom' => $utilisateur[0]->get_nom(),
        'email' => $utilisateur[0]->get_email(),
    );
    echo json_encode($json_utilisateur[0]);
}


function modifier_profil_utilisateur() { // ajouter une vérification du mot de passe actuel
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";
    require_once __DIR__ . "/../Modeles/utilisateur.php";

    $data = json_decode(file_get_contents('php://input'), true);

    //recup ancien profil
    if (!isset($_SESSION['id_utilisateur'])) {
        echo json_encode(array(
            'message' => 'Aucune session active',
            'status' => 401
        ));
        return;
    }

    $info_profil_actuel = DAL_info_utilisateur("id_utilisateur", $_SESSION['id_utilisateur']);
    $nom_utilisateur = $info_profil_actuel[0]->get_nom();
    $email_utilisateur = $info_profil_actuel[0]->get_email();
    $ancien_mdp_utilisateur = $info_profil_actuel[0]->get_mdp();

    if (isset($data['nom'])) {
            $nom_utilisateur = $data['nom'];
        }
        if (isset($data['email'])) {
            $email_utilisateur = $data['email'];
    }

    $ancien_mdp_formulaire;
    $nouveau_mdp_formulaire;
    $nouveau_mdp_securise = $ancien_mdp_utilisateur; // par défaut

    // Vérification pour modification mot de passe
    if (isset($data['nouveau_mot_de_passe'])) { // s'il y a un nouveau mdp
        $nouveau_mdp_formulaire = $data['nouveau_mot_de_passe'];
        $ancien_mdp_formulaire = $data['ancien_mot_de_passe'] ?? null;
        if ($ancien_mdp_utilisateur && password_verify($ancien_mdp_formulaire, $ancien_mdp_utilisateur)) {
            // s'il y a un ancien mdp ET qu'il est correct: securise nouveau mdp
            $nouveau_mdp_securise = password_hash($nouveau_mdp_formulaire, PASSWORD_DEFAULT);
        } else { // sinon renvoi erreur
            echo json_encode(array( 
                'message' => 'Mot de passe actuel incorrect',
                'status' => 403
            ));
            return;
        }
    }
    
    $modification_utilisateur = new Utilisateur(
        $_SESSION['id_utilisateur'],
        $nom_utilisateur,
        $email_utilisateur,
        $nouveau_mdp_securise, // mdp securisé
        null
    );

    DAL_modifier_utilisateur($modification_utilisateur);
    $reponse_modification[] = array(
        'message' => 'Modification réussie',
        'status' => 201
    );
    echo json_encode($reponse_modification);
}


// Suppression d'un utilisateur
function supprimer_profil_ptilisateur() {
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";

    if (!isset($_SESSION['id_utilisateur'])) {
        echo json_encode(array(
            'message' => 'Aucune session active',
            'status' => 401
        ));
        return;
    }

    //$id_session = $_SESSION['id_utilisateur'];
    $data = json_decode(file_get_contents('php://input'), true);
    $id_session = $data['id_utilisateur'];// ?? $_SESSION['id_utilisateur']; // si id_utilisateur dans le body, sinon session
    DAL_supprimer_utilisateur($id_session);
    $reponse_suppression[] = array(
        'message' => 'Suppression réussie',
        'status' => 200
    );

    deconnexion();
    echo json_encode($reponse_suppression);
}


?>