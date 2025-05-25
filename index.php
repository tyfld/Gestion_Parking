<?php

header('Content-Type: application/json');

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];


// A modifier en fonction de l'emplacement de ton projet 
// remplacer par ce qui est juste après le localhost
$basePath = '/projets/Gestion_Parking'; 
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}
if ($requestUri === '') {
    $requestUri = '/';
}

require_once __DIR__ . '/Services/servicesVoitures.php';
require_once __DIR__ . '/Services/servicesUtilisateurs.php';
require_once __DIR__ . '/Services/servicesAdmin.php';

// Création des routes:
$routes = [
    'GET' => [
        '/' => 'home',
        
        '/profil' => 'profil_utilisateur',
        '/session' => 'verif_session',
        '/connexion-test' => 'connexion_test', // à suppr, pour dev
        '/deconnexion' => 'deconnexion',

        '/liste-voitures' => 'lister_voiture',
        '/emprunts-historique-utilisateur' => 'emprunt_historique_utilisateur',
        '/emprunts-historique-voiture' => 'emprunt_historique_voiture',

    ],
    'POST' => [
        '/connexion' => 'connexion',
        '/inscription' => 'inscription',

        '/modifier-profil' => 'modifier_profil_utilisateur',
        '/supprimer-profil'=> 'supprimer_profil_utilisateur',
        
        '/emprunter-voiture' => 'emprunter_voiture',
        '/rendre-voiture' => 'rendre_voiture',
        
        '/details-voiture' => 'detail_voiture',

        // routes pour admin
        '/ajouter-voiture' => 'ajouter_voiture',
        '/modifier-voiture' => 'modifier_voiture',
        '/supprimer-voiture' => 'supprimer_voiture',

        '/inscription-admin' => 'nouvel_admin',

    ]
];

function home() {
    echo json_encode(['message' => 'API de Gestion Parking']);
}

function exemplePOST() {
    echo json_encode(["message" => "Exemple requête POST"]);
}

if (isset($routes[$method][$requestUri])) {
    call_user_func($routes[$method][$requestUri]);
} else {
    header("HTTP/1.0 404 Not Found");
    echo json_encode(["message" => "Erreur 404: route non trouvée"]);
}

?>