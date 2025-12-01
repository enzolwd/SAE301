<?php

function verifierEmailEtRecupererInfos($conn, $email) {
    try {
        $sql = "SELECT idUtilisateur, nom, prénom FROM Utilisateur WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function stockerToken($conn, $idUtilisateur, $token) {
    try {
        // Le token expire dans 1 heure (NOW() + interval '1 hour' pour PostgreSQL)
        $sql = "UPDATE Utilisateur 
                SET token_recuperation = :token, 
                    date_expiration_token = NOW() + INTERVAL '1 hour' 
                WHERE idUtilisateur = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':token' => $token, ':id' => $idUtilisateur]);
    } catch (PDOException $e) {
        return false;
    }
}

function verifierToken($conn, $token) {
    try {
        // On cherche un user avec ce token ET dont la date d'expiration n'est pas passée
        $sql = "SELECT idUtilisateur FROM Utilisateur 
                WHERE token_recuperation = :token 
                AND date_expiration_token > NOW()";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':token' => $token]);
        return $stmt->fetchColumn(); // Renvoie l'ID ou false
    } catch (PDOException $e) {
        return false;
    }
}

function mettreAJourMotDePasse($conn, $idUtilisateur, $nouveauMdpHash) {
    try {
        // On change le MDP et on supprime le token pour qu'il ne soit plus réutilisable
        $sql = "UPDATE Utilisateur 
                SET motDePasse = :mdp, 
                    token_recuperation = NULL, 
                    date_expiration_token = NULL 
                WHERE idUtilisateur = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':mdp' => $nouveauMdpHash, ':id' => $idUtilisateur]);
    } catch (PDOException $e) {
        return false;
    }
}
?>