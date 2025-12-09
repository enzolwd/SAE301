<?php
// mettre le bon fuseau horaire parce que sinon on avait 45min de retard environ sur l'heure actuelle
date_default_timezone_set('Europe/Paris');

function connecterBDD(){
    $host = "ep-purple-resonance-agsgo68u-pooler.c-2.eu-central-1.aws.neon.tech";
    $dbname = "neondb";
    $user = "neondb_owner";
    $passwordbd = "npg_nXhoB0G6mfTJ";

    try {
        $conn = new PDO("pgsql:host=$host;dbname=$dbname", $user, $passwordbd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Erreur SQL : " . $e->getMessage());
    }
}
?>