<?php
session_start();
require_once '../Modele/ConnexionBDD.php';
require_once '../Modele/Recuperation_Modele.php';

if (isset($_POST['valider_nouveau_mdp']) && !empty($_POST['token']) && !empty($_POST['new_mdp'])) {
    $token = $_POST['token'];
    $nouveauMdp = $_POST['new_mdp'];

    $conn = connecterBDD();

    // 1. Vérifier la validité du token
    $idUtilisateur = verifierToken($conn, $token);

    if ($idUtilisateur) {
        // 2. Hacher le mot de passe
        // ATTENTION : Votre système actuel utilise-t-il password_hash ou un autre hash ?
        // Dans le fichier fourni MDP_Hash.php (brouillon), vous utilisiez password_hash.
        $mdpHash = password_hash($nouveauMdp, PASSWORD_DEFAULT);

        // 3. Mettre à jour
        mettreAJourMotDePasse($conn, $idUtilisateur, $mdpHash);

        // 4. Redirection vers connexion avec message succès (vous pouvez ajouter un param ?success=reset)
        $_SESSION['login_error'] = "Mot de passe modifié avec succès. Veuillez vous connecter.";
        header('Location: ../Vue/Page_De_Connexion.php');
        exit();
    } else {
        // Token invalide ou expiré
        header('Location: ../Vue/Page_Reinitialisation.php?error=invalid');
        exit();
    }
} else {
    header('Location: ../Vue/Page_De_Connexion.php');
}