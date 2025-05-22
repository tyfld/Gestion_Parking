<?php

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');


// Vérifier pour le front si une session est active -------------------------------------------------------------------
function verif_session() {
    session_start();
    if (isset($_SESSION['id_utilisateur']))  {
        echo json_encode(array(
            'session' => true,
            'id_utilisateur' => $_SESSION['id_utilisateur'],
            'role' => $_SESSION['role_utilisateur'],
            'token' => $_SESSION['csrf_token'],
        ));
    } else {
        echo json_encode(array(
            'session' => false,
        ));
    }
}


// Inscription d'un utilisateur ---------------------------------------------------------------------------------------
function inscription() { 
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";
    require_once __DIR__ . "/../Modeles/utilisateur.php";

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
    if (isset($utilisateur[0]) && $email_formulaire == $utilisateur[0]->getEmail()) {
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
        0
    );

    DAL_ajouter_utilisateur($nouvel_utilisateur);
    $reponse_inscription[] = array(
        'message' => 'Inscription réussie',
        'status' => 201
    );
    echo json_encode($reponse_inscription);
}


// Connexion de l'utilisateur -----------------------------------------------------------------------------------------
// TODO : récupérer les infos à partir du formulaire du front
function connexion() { 
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['email']) || !isset($data['mot_de_passe'])) {
        echo json_encode([
            'message' => 'Email et mot de passe requis',
            'status' => 400
        ]);
        return;
    }

    $email_formulaire = $data['email'];
    $mdp_formulaire = $data['mot_de_passe'];

    $utilisateur = DAL_info_utilisateur("email", $email_formulaire);
    $reponse_connexion = array();

    //Gestion de la session
    if ($email_formulaire == $utilisateur[0]->getEmail() && password_verify($mdp_formulaire, $utilisateur[0]->getMdp())) {
    //if (isset($utilisateur[0]) && $email_formulaire == $utilisateur[0]->getEmail() && $mdp_formulaire == $utilisateur[0]->getMdp()) { // Sécurité mdp
        session_start();
        $_SESSION['id_utilisateur'] = $utilisateur[0]->getId_utilisateur();
        $_SESSION['role_utilisateur'] = $utilisateur[0]->getRole();
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


function connexion_test() { 
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $email_formulaire = "mail1@gmail.com"; // TODO : remplacer par données formulaire
    $mdp_formulaire = "mot2passe"; // TODO : remplacer par données formulaire

    $utilisateur = DAL_info_utilisateur("email", $email_formulaire);
    $reponse_connexion = array();

    // if ($emailTest == $utilisateur[0]->getEmail() && password_verify($mdpTest, $utilisateur[0]->getMdp())) {
    if ($email_formulaire == $utilisateur[0]->getEmail() && $mdp_formulaire == $utilisateur[0]->getMdp()) {
        session_start();
        $_SESSION['id_utilisateur'] = $utilisateur[0]->getId_utilisateur();
        $_SESSION['role_utilisateur'] = $utilisateur[0]->getRole();
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
    session_start();
    session_unset();
    session_destroy();

    echo json_encode(array(
        'message' => 'Déconnexion réussie',
        'status' => 200
    ));
}


// Gestion des tokens -------------------------------------------------------------------------------------------------
// TODO : finir gestion des tokens
function getTokenCSRF() {
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

function verifTokenCSRF() {
    // TODO
}


// Envoi des information de l'utilisateur connecté --------------------------------------------------------------------
function profilUtilisateur() { 
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";

    session_start();
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
        'id_utilisateur' => $utilisateur[0]->getId_utilisateur(),
        'nom' => $utilisateur[0]->getNom(),
        'email' => $utilisateur[0]->getEmail(),
    );
    echo json_encode($json_utilisateur);
}


?>