<?php

header('Content-Type: application/json');

function profilUtilisateur() {
    require_once __DIR__ . "/../DAL/utilisateursDAL.php";
    require_once __DIR__ . "/../DAL/empruntsDAL.php";

    $utilisateur = DAL_info_utilisateur(1); // 1 pour le test, remplacer plus tard par une route dynamique
    $emprunt = DAL_info_emprunt_utilisateur(1); // idem
    $json_utilisateur = array();

    foreach ($utilisateur as $u) {
        foreach ($emprunt as $e) {
            $json_utilisateur[] = array(
                'id_utilisateur' => $u->getId_utilisateur(),
                'nom' => $u->getNom(),
                'prenom' => $u->getPrenom(),
                'email' => $u->getEmail(),
                'id_emprunt' => $e->getId_emprunt()
                );
        }
    }
    echo json_encode($json_utilisateur);
}

function connexion() {
    //
}

?>