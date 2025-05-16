<?php
    $hostBdd = 'localhost';
    $bdd = 'gestion_parking';
    $utilisateurBdd = 'root';
    $mdpBdd = '';

    // Connexion à la base de données
    try {
        $conn = new PDO("mysql:host=".$hostBdd.";dbname=".$bdd.";charset=utf8", $utilisateurBdd, $mdpBdd,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    } catch(PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
    ?>