<?php
/*
 * Fichier Presentation
 * Gère l'acceptation d'un justificatif.
*/
session_start();

require_once 'Gestion_Session.php';

// On inclut les fichiers Modele
require_once '../Modele/ConnexionBDD.php';
require_once '../Modele/Responsable_Modele.php';
require_once '../../Fonction_mail.php';

// vérifier si l'utilisateur s'est connecté
if (!isset($_SESSION['idUtilisateur']) || $_SESSION['role'] != 'Responsable Pedagogique') {
    header('Location: ../Vue/Page_De_Connexion.php');
    exit();
}

// vérifier si le formulaire a été soumis
if (isset($_POST['valider']) && isset($_POST['justificatifID'])) {
    $justificatifID = filter_input(INPUT_POST, 'justificatifID', FILTER_VALIDATE_INT);
    $commentaireResponsable = trim($_POST['commentaireValider']);
    $motifrespon = $_POST['motifAccepter'];

    if (empty($commentaireResponsable)) {
        $commentaireResponsable = null;
    }
    if (empty($motifrespon)) {
        $motifrespon = null;
    }

    if ($justificatifID === false || $justificatifID <= 0) {
        header('Location: ../Vue/Page_Accueil_Responsable.php?error=invalid_id');
        exit();
    }

    $conn1 = connecterBDD();

    try {
        $succes = accepterJustificatif($conn1, $justificatifID, $commentaireResponsable, $motifrespon);

        // il faut le mail de l'étudiant
        $email = recupererMailEtudiant($conn1, $justificatifID);
        $utilisateur = recupererNomEtudiant($conn1, $justificatifID);
        $nomComplet = $utilisateur['prénom'] . ' ' . $utilisateur['nom'];

        envoyerMail($email, $nomComplet,  2);

        header('Location: ../Vue/Page_Accueil_Responsable.php?traitement=succes');
        exit();

    } catch(Exception $e) {
        header('Location: ../Vue/Page_Accueil_Responsable.php');
        exit();
    }

    $conn1 = null;

} else {
    header('Location: ../Vue/Page_Accueil_Responsable.php');
    exit();
}
?>