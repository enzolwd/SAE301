<?php
session_start();
$errorMessage = "";
if (isset($_SESSION['login_error'])) {
    $errorMessage = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

if (isset($_GET['error']) && $_GET['error'] === 'timeout') {
    $errorMessage = "Vous avez été déconnecté suite à une inactivité de 30 minutes.";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="css/Style_Page_De_Connexion.css">
</head>
<body>

<div class="header-main">
    <div class="logo-section">
        <img src="images/logo_uphf.png" alt="Logo Université Polytechnique">
    </div>
    <div class="header-right">
        <p>ESPACE NUMÉRIQUE DE TRAVAIL</p>
    </div>
</div>

<div class="login-container">
    <div class="login-box">

        <?php
        // afficher une erreur si il y en a une
        if (!empty($errorMessage)) {
            echo '<p class="error-message">' . htmlspecialchars($errorMessage) . '</p>';
        }
        ?>

        <form method="post" action="../Presentation/Connexion_Presenteur.php">

            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input id="UserName" name="UserName" placeholder="Entrez votre nom d'utilisateur..." required>
            </div>

            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" id="mdp" name="mdp" placeholder="Entrez votre mot de passe..." required>
            </div>

            <div style="text-align: right; margin-bottom: 15px;">
                <a href="Page_Mot_De_Passe_Oublie.php" style="color: #004d66; font-size: 0.9em;">Mot de passe oublié ?</a>
            </div>

            <input type="submit" class="login-button" name="identifiants" value="Se connecter">
        </form>

    </div>
</div>

<footer class="main-footer"></footer>

</body>
</html>