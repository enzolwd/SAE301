<?php
/*
 * Fichier Presentation
 * Gère le refus d'un justificatif.
*/
session_start();

require_once 'Gestion_Session.php';

// On inclut les fichiers Modele
require_once '../Modele/ConnexionBDD.php';
require_once '../Modele/Responsable_Modele.php';
require_once '../../Fonction_mail.php';

// Vérifier si l'utilisateur s'est connecté
if (!isset($_SESSION['idUtilisateur']) || $_SESSION['role'] != 'Responsable Pedagogique') {
    header('Location: ../Vue/Page_De_Connexion.php');
    exit();
}

// vérifier si le formulaire de refus a été soumis
if (isset($_POST['refuser']) && isset($_POST['justificatifID'])) {

    $justificatifID = filter_input(INPUT_POST, 'justificatifID', FILTER_VALIDATE_INT);
    $motifSelect = trim($_POST['motifRefus']);
    $motifPerso = trim($_POST['motifPerso']);
    $commentaireRefus = trim($_POST['commentaireRefus']);

    if ($justificatifID === false || $justificatifID <= 0) {
        header('Location: ../Vue/Page_Accueil_Responsable.php');
        exit();
    }

    $motifSelectRempli = !empty($motifSelect);
    $motifPersoRempli = !empty($motifPerso);

    if (($motifSelectRempli + $motifPersoRempli) !== 1) {
        header('Location: ../Vue/Page_De_Refus.php?id=' . $justificatifID . '&error=xor');
        exit();
    }

    $motifFinal = $motifSelectRempli ? $motifSelect : $motifPerso;
    $commentaireFinal = !empty($commentaireRefus) ? $commentaireRefus : null;

    // 1. On crée la connexion
    $conn1 = connecterBDD();

    try {
        $succes = refuserJustificatif($conn1, $justificatifID, $motifFinal, $commentaireFinal);

        $email = recupererMailEtudiant($conn1, $justificatifID);
        $utilisateur = recupererNomEtudiant($conn1, $justificatifID);
        $nomComplet = $utilisateur['prénom'] . ' ' . $utilisateur['nom'];

        envoyerMail($email, $nomComplet,  3);

        header('Location: ../Vue/Page_Accueil_Responsable.php?traitement=refuse');
        exit();

    } catch(Exception $e) { // Changé de PDOException
        header('Location: ../Vue/Page_Accueil_Responsable.php');
        exit();
    }

    // 3. On ferme la connexion
    $conn1 = null;

} else {
    header('Location: ../Vue/Page_Accueil_Responsable.php');
    exit();
}
?>