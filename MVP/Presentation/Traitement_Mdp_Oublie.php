<?php
session_start();
require_once '../Modele/ConnexionBDD.php';
require_once '../Modele/Recuperation_Modele.php';
require_once '../../Fonction_mail.php';

if (isset($_POST['demande_recup']) && !empty($_POST['email'])) {
    $email = trim($_POST['email']);
    $conn = connecterBDD();

    // 1. Vérifier si l'email existe
    $infosUtilisateur = verifierEmailEtRecupererInfos($conn, $email);

    if ($infosUtilisateur) {
        // 2. Générer un token unique cryptographique
        $token = bin2hex(random_bytes(32)); // Génère une chaîne aléatoire de 64 caractères

        // 3. Stocker le token en BDD
        stockerToken($conn, $infosUtilisateur['idutilisateur'], $token);

        // 4. Créer le lien (Adaptez 'localhost/...' à votre VRAI chemin URL)
        // Astuce : Utilisez $_SERVER['HTTP_HOST'] pour être dynamique
        $dossierProjet = "/SAE301Nouvelle/MVP/Vue";
        $lien = "http://" . $_SERVER['HTTP_HOST'] . $dossierProjet . "/Page_Reinitialisation.php?token=" . $token;

        // 5. Envoyer le mail (Type 10)
        $nomComplet = $infosUtilisateur['prénom'] . ' ' . $infosUtilisateur['nom'];
        envoyerMail($email, $nomComplet, 10, $lien);
    }

    // Dans tous les cas (même si email introuvable), on affiche le message de succès
    // pour ne pas révéler si un email existe ou non (Sécurité).
    header('Location: ../Vue/Page_Mot_De_Passe_Oublie.php?info=sent');
    exit();
} else {
    header('Location: ../Vue/Page_De_Connexion.php');
}