<?php
// mettre le bon fuseau horaire parce que sinon on avait 45min de retard environ sur l'heure actuelle
date_default_timezone_set('Europe/Paris');

/**
 * Fonction qui crée et retourne l'objet de connexion PDO.
 */
function connecterBDD() {
    $host = "srv-sae12";
    $dbname = "bddsae301";
    $user = "usersae301";
    $passwordbd = "psae301";

    try {
        $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $passwordbd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        // En cas d'échec de connexion, on arrête tout
        die("Erreur de connexion à la base de données.");
    }
}
?>