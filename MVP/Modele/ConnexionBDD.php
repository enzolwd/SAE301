<?php
// mettre le bon fuseau horaire parce que sinon on avait 45min de retard environ sur l'heure actuelle
date_default_timezone_set('Europe/Paris');

/**
 * Fonction qui crée et retourne l'objet de connexion PDO.
 */
function connecterBDD() {
    $host = "ep-purple-resonance-agsgo68u-pooler.c-2.eu-central-1.aws.neon.tech";
    $dbname = "neondb";
    $user = "neondb_owner";
    $passwordbd = "npg_nXhoB0G6mfTJ";

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