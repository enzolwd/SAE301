<?php
session_start();

// --- 1. Paramètres de connexion à la base de données (À ADAPTER) ---
$serveur = "localhost"; // Ou l'adresse de votre serveur
$utilisateur_db = "root"; // Votre utilisateur BDD
$mot_de_passe_db = ""; // Votre mot de passe BDD
$nom_db = "sae301_absences"; // Le nom de votre base de données

// --- 2. Vérification de la soumission du formulaire ---
// On vérifie que l'utilisateur vient bien du formulaire en testant le 'name' du bouton
if (isset($_POST['identifiants'])) {

    // --- 3. Connexion à la BDD avec PDO (plus sécurisé) ---
    try {
        $bdd = new PDO("mysql:host=$serveur;dbname=$nom_db;charset=utf8", $utilisateur_db, $mot_de_passe_db);
        // Configurer PDO pour qu'il lève des exceptions en cas d'erreur
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // En cas d'erreur de connexion, on redirige avec une erreur
        $_SESSION['erreur_connexion'] = "Erreur de connexion à la base de données.";
        header("Location: Page_De_Connexion.html?erreur=db");
        exit();
    }

    // --- 4. Récupération et nettoyage des données ---
    // On récupère les 'name' des inputs : "UserName" et "mdp"
    $username = $_POST['UserName'];
    $password_saisi = $_POST['mdp'];

    // --- 5. Vérification des identifiants ---
    // On suppose que vous avez une table 'utilisateurs' avec 'nom_utilisateur', 'mot_de_passe' et 'role'
    try {
        // On utilise une REQUÊTE PRÉPARÉE pour éviter les injections SQL
        $requete = $bdd->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ?");
        $requete->execute([$username]);
        $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);

        // $utilisateur contient les infos (ou 'false' si non trouvé)

        // On vérifie si l'utilisateur existe ET si le mot de passe saisi
        // correspond au mot de passe HACHÉ dans la base de données.
        if ($utilisateur && password_verify($password_saisi, $utilisateur['mot_de_passe'])) {

            // --- 6. Succès : Connexion réussie ---
            // On stocke les infos vitales dans la session
            $_SESSION['user_id'] = $utilisateur['id']; // (si vous avez un ID)
            $_SESSION['username'] = $utilisateur['nom_utilisateur'];
            $_SESSION['role'] = $utilisateur['role']; // Ex: 'etudiant', 'responsable', 'secretaire'

            // --- 7. Redirection en fonction du rôle ---
            // (Adaptez les chemins vers vos pages d'accueil)
            switch ($utilisateur['role']) {
                case 'etudiant':
                    // Redirige vers la page vue dans vos dossiers
                    header("Location: Dossiers Perso/Antoine/Page d'accueil étudiante/Page_D'accueil_Etudiant.html");
                    break;
                case 'responsable':
                    // Redirige vers la page vue dans vos dossiers
                    header("Location: Dossiers Perso/Antoine/Page d'accueil responsable/Page_D'accueil_Responsable.html");
                    break;
                case 'secretaire':
                    // Redirige vers la page vue dans vos dossiers
                    header("Location: Dossiers Perso/Antoine/Page d'accueil secrétaire/Page_D'accueil_Secretaire.php");
                    break;
                default:
                    // Rôle non défini
                    $_SESSION['erreur_connexion'] = "Rôle utilisateur non défini.";
                    header("Location: Page_De_Connexion.html?erreur=role");
                    break;
            }
            exit(); // Toujours 'exit()' après un header('Location: ...')

        } else {
            // --- 8. Échec : Mauvais identifiant ou mot de passe ---
            $_SESSION['erreur_connexion'] = "Nom d'utilisateur ou mot de passe incorrect.";
            header("Location: Page_De_Connexion.html?erreur=identifiants");
            exit();
        }

    } catch (PDOException $e) {
        // Gérer les erreurs de requête
        $_SESSION['erreur_connexion'] = "Erreur lors de la vérification des identifiants.";
        header("Location: Page_De_Connexion.html?erreur=requete");
        exit();
    }

} else {
    // Si quelqu'un accède à Connexion_PHP.php directement sans passer par le formulaire
    header("Location: Page_De_Connexion.html");
    exit();
}
?>