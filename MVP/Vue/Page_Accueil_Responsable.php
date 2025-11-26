<?php
require_once '../Presentation/Responsable_Accueil_Presenteur.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Responsable</title>
    <link rel="stylesheet" href="css/Style_Page_Accueil_Responsable.css">
</head>

<body>

<?php
// affiche la notification si $notificationMessage existe
if (!empty($notificationMessage)) {
    echo '<div id="toast" class="toast-notification ' . htmlspecialchars($notificationType) . '">';
    echo htmlspecialchars($notificationMessage);
    echo '</div>';
}
?>
<div class="header-main">
    <div class="logo-section">
        <img src="images/logo_uphf.png" alt="Logo Université Polytechnique">
    </div>

    <div class="header-right">
        <p>ESPACE NUMÉRIQUE DE TRAVAIL</p>
        <a href="Page_Statistique_Accueil.php" class="bouton-statistique">Statistique</a>
        <a href="../Presentation/Deconnexion_Presenteur.php" class="bouton-deconnexion">Déconnexion</a>
    </div>
</div>

<div class="container">
    <div class="dashboard-content-wrapper">

        <h1 class="titre-tableau-de-bord">Tableau De Bord</h1>

        <div class="content-tables-container">

            <section class="section-justificatifs">
                <h2>Justificatifs en attente</h2>
                <div class="table-container">
                    <table class="tableau" id="tableauAttente">
                        <thead>
                        <tr>
                            <th data-type="date">Du</th>
                            <th data-type="heure">À</th>
                            <th data-type="date">Au</th>
                            <th data-type="heure">À</th>
                            <th data-type="texte">Nom</th>
                            <th data-type="texte">Prénom</th>
                            <th data-type="texte">Groupe</th>
                            <th data-type="aucun">Consulter</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($lesjustificatifs)) : ?>
                            <tr class="empty-table-message">
                                <td colspan="8">Aucun justificatif en attente.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($lesjustificatifs as $justif) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($justif['datededebut']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['heuredebut']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['datedefin']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['heurefin']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['prénom']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['groupe']); ?></td>
                                    <td>
                                        <a href="Page_Consultation_Justificatif_En_Attente.php?id=<?php echo htmlspecialchars($justif['idjustificatif']); ?>" class="action-button">Consulter</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="section-historique">
                <h2>Historique</h2>

                <div class="table-container">
                    <table class="tableau historique" id="tableauHistorique">
                        <thead>
                        <tr>
                            <th data-type="date">Du</th>
                            <th data-type="heure">À</th>
                            <th data-type="date">Au</th>
                            <th data-type="heure">À</th>
                            <th data-type="texte">Nom</th>
                            <th data-type="texte">Prénom</th>
                            <th data-type="texte">Groupe</th>
                            <th data-type="texte">Statut</th>
                            <th data-type="aucun">Consulter</th>
                            <th data-type="aucun">Déverrouiller</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($lesjustificatifsHisto)) : ?>
                            <tr class="empty-table-message">
                                <td colspan="10">Aucun justificatif dans l'historique.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($lesjustificatifsHisto as $justif) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($justif['datededebut']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['heuredebut']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['datedefin']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['heurefin']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['nom']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['prénom']); ?></td>
                                    <td><?php echo htmlspecialchars($justif['groupe']); ?></td>
                                    <td class="<?php echo getStatusClass($justif['statut']); ?>">
                                        <?php echo htmlspecialchars($justif['statut']); ?></td>
                                    <td>
                                        <a href="Page_Consultation_Justificatif_Historique.php?id=<?php echo htmlspecialchars($justif['idjustificatif']); ?>" class="action-button">Consulter</a>
                                    </td>
                                    <td>
                                        <a href="Page_Confirmation_Deverouillage.php?id=<?php echo htmlspecialchars($justif['idjustificatif']); ?>" class="action-button">Déverrouiller</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>
</div>
<footer class="main-footer"></footer>

<script>
    // gestion des notifications
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(function() {
                toast.classList.add('fade-out');
                setTimeout(function() {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 1000);
            }, 4000);
        }

        // initialisation du tri pour les deux tableaux
        rendreTableauTriable('tableauAttente');
        rendreTableauTriable('tableauHistorique');
    });
    function rendreTableauTriable(idTableau) {
        const tableau = document.getElementById(idTableau);
        // Sécurité : si le tableau n'existe pas, on arrête
        if (!tableau) return;

        const lesEntetes = tableau.querySelectorAll('thead th');
        const corpsDuTableau = tableau.querySelector('tbody');

        lesEntetes.forEach((entete, indexColonne) => {
            // On ajoute le tri seulement si ce n'est pas une colonne "aucun"
            if (entete.getAttribute('data-type') !== 'aucun') {
                entete.addEventListener('click', () => {
                    trierLeTableau(tableau, lesEntetes, corpsDuTableau, indexColonne, entete);
                });
            }
        });
    }

    function trierLeTableau(tableau, lesEntetes, corpsDuTableau, index, enteteClique) {
        const lesLignes = Array.from(corpsDuTableau.querySelectorAll('tr'));

        // On ignore si le tableau est vide
        if (lesLignes.length === 1 && lesLignes[0].classList.contains('empty-table-message')) return;

        // Gestion de l'ordre
        const estActuellementCroissant = enteteClique.getAttribute('data-ordre') === 'asc';
        const nouvelOrdre = estActuellementCroissant ? 'desc' : 'asc';
        const multiplicateur = (nouvelOrdre === 'asc') ? 1 : -1;

        // Reset des autres en-têtes
        lesEntetes.forEach(th => th.removeAttribute('data-ordre'));
        enteteClique.setAttribute('data-ordre', nouvelOrdre);

        const typeDeDonnee = enteteClique.getAttribute('data-type');

        lesLignes.sort((ligneA, ligneB) => {
            const contenuA = ligneA.children[index].innerText.trim();
            const contenuB = ligneB.children[index].innerText.trim();

            if (typeDeDonnee === 'date') {
                return (convertirDateFrancais(contenuA) - convertirDateFrancais(contenuB)) * multiplicateur;
            } else if (typeDeDonnee === 'heure') {
                return contenuA.localeCompare(contenuB) * multiplicateur;
            } else {
                return contenuA.localeCompare(contenuB, 'fr', { numeric: true }) * multiplicateur;
            }
        });

        lesLignes.forEach(ligne => corpsDuTableau.appendChild(ligne));
    }

    function convertirDateFrancais(dateString) {
        if (!dateString) return new Date(0);
        const parties = dateString.split('/');
        return new Date(parties[2], parties[1] - 1, parties[0]);
    }
</script>

</body>
</html>