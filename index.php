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

require_once __DIR__ . '/Services/ServicesVoitures.php';
require_once __DIR__ . '/Services/ServicesUtilisateurs.php';

// Création des routes:
$routes = [
    'GET' => [
        '/' => 'home',
        '/liste-voitures' => 'listerVoiture',
        '/profil' => 'profilUtilisateur',
    ],
    'POST' => [
        '/exemple' => 'exemplePOST',
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