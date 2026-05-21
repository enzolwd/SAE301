<?php

session_start();

require_once '../Modele/ConnexionBDD.php';
require_once '../Modele/Connexion_Modele.php';

if (isset($_POST['identifiants'])) {

    try {

        $username = $_POST['UserName'];
        $password = $_POST['mdp'];
        $ip = $_SERVER['REMOTE_ADDR'];

        $conn = connecterBDD();
        
        $req = $conn->prepare("
            SELECT tentatives, date_blocage
            FROM TentativesConnexionIP
            WHERE adresse_ip = :ip
        ");
        $req->bindParam(':ip', $ip);
        $req->execute();
        $ipData = $req->fetch(PDO::FETCH_ASSOC);

        if ($ipData && $ipData['date_blocage'] && strtotime($ipData['date_blocage']) > time()) {

            $min = floor((strtotime($ipData['date_blocage']) - time()) / 60);

            $_SESSION['login_error'] =
                "Trop de tentatives depuis cette IP. Réessayez dans {$min} min.";

            header('Location: ../Vue/Page_De_Connexion.php');
            exit();
        }

        $utilisateur = trouverUtilisateurParNom($conn, $username);

        if ($utilisateur && password_verify($password, $utilisateur['hash'])) {

            $resetUser = $conn->prepare("
                UPDATE Utilisateur
                SET tentatives_echouees = 0,
                    date_fin_blocage = NULL,
                    derniere_tentative = NULL
                WHERE idutilisateur = :id
            ");
            $resetUser->bindParam(':id', $utilisateur['idUtilisateur']);
            $resetUser->execute();

            $resetIP = $conn->prepare("
                DELETE FROM TentativesConnexionIP
                WHERE adresse_ip = :ip
            ");
            $resetIP->bindParam(':ip', $ip);
            $resetIP->execute();

            session_regenerate_id(true);

            $_SESSION['idUtilisateur'] = $utilisateur['idUtilisateur'];
            $_SESSION['role'] = $utilisateur['role'];

            switch ($utilisateur['role']) {
                case "Etudiant":
                    header('Location: ../Vue/Page_Accueil_Etudiant.php');
                    break;
                case "Professeur":
                    header('Location: ../Vue/Page_Accueil_Professeur.php');
                    break;
                case "ADMIN":
                    header('Location: ../Vue/ADMIN.php');
                    break;
                case "Responsable Pedagogique":
                    header('Location: ../Vue/Page_Accueil_Responsable.php');
                    break;
                case "Secretaire":
                    header('Location: ../Vue/Page_Accueil_Secretaire.php');
                    break;
            }

            exit();
        }

        if ($utilisateur) {

            $newTentatives = $utilisateur['tentatives'] + 1;

            if ($newTentatives >= 5) {

                $blocage = date('Y-m-d H:i:s', time() + 900);

                $conn->prepare("
                    UPDATE Utilisateur
                    SET tentatives_echouees = :t,
                        date_fin_blocage = :b,
                        derniere_tentative = NOW()
                    WHERE idutilisateur = :id
                ")->execute([
                    ':t' => $newTentatives,
                    ':b' => $blocage,
                    ':id' => $utilisateur['idUtilisateur']
                ]);

                $_SESSION['login_error'] =
                    "Compte bloqué 15 minutes.";

            } else {

                $conn->prepare("
                    UPDATE Utilisateur
                    SET tentatives_echouees = :t,
                        derniere_tentative = NOW()
                    WHERE idutilisateur = :id
                ")->execute([
                    ':t' => $newTentatives,
                    ':id' => $utilisateur['idUtilisateur']
                ]);

                $_SESSION['login_error'] =
                    "Identifiants incorrects.";
            }
        }

        if ($ipData) {

            $newIP = $ipData['tentatives'] + 1;

            if ($newIP >= 5) {

                $blocageIP = date('Y-m-d H:i:s', time() + 900);

                $conn->prepare("
                    UPDATE TentativesConnexionIP
                    SET tentatives = :t,
                        date_blocage = :b,
                        derniere_tentative = NOW()
                    WHERE adresse_ip = :ip
                ")->execute([
                    ':t' => $newIP,
                    ':b' => $blocageIP,
                    ':ip' => $ip
                ]);

            } else {

                $conn->prepare("
                    UPDATE TentativesConnexionIP
                    SET tentatives = :t,
                        derniere_tentative = NOW()
                    WHERE adresse_ip = :ip
                ")->execute([
                    ':t' => $newIP,
                    ':ip' => $ip
                ]);
            }

        } else {

            $conn->prepare("
                INSERT INTO TentativesConnexionIP (adresse_ip, tentatives)
                VALUES (:ip, 1)
            ")->execute([
                ':ip' => $ip
            ]);
        }

        header('Location: ../Vue/Page_De_Connexion.php');
        exit();

    } catch (Exception $e) {

        $_SESSION['login_error'] =
            "Erreur serveur.";

        header('Location: ../Vue/Page_De_Connexion.php');
        exit();
    }
}
?>
