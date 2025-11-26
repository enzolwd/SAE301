<?php
require_once '../Presentation/Professeur_Accueil_Presenteur.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Professeur</title>
    <link rel="stylesheet" href="css/Style_Page_Accueil_Professeur.css">
</head>
<body>

<div class="header-main">
    <div class="logo-section">
        <img src="images/logo_uphf.png" alt="Logo Université Polytechnique">
    </div>
    <div class="header-right">
        <p>ESPACE NUMÉRIQUE DE TRAVAIL</p>
        <a href="../Presentation/Deconnexion_Presenteur.php" class="bouton-deconnexion">Déconnexion</a>
    </div>
</div>

<div class="container">

    <h1 class="titre-principal">Liste des rattrapages</h1>

    <section class="tableau-wrapper">
        <div class="table-container">
            <table class="tableau" id="tableauRattrapages">
                <thead>
                <tr>
                    <th data-type="date">Date</th>
                    <th data-type="heure">Heure</th>
                    <th data-type="heure">Durée</th>
                    <th data-type="texte">Matière</th>
                    <th data-type="texte">Nom</th>
                    <th data-type="texte">Prénom</th>
                    <th data-type="texte">Groupe</th>
                    <th data-type="texte">Email</th>
                    <th data-type="texte">Rattrapage autorisé</th>
                </tr>
                </thead>

                <tbody>
                <?php if (empty($lesRattrapages)) : ?>
                    <tr class="empty-table-message">
                        <td colspan="9">Aucun rattrapage n'est à venir.</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($lesRattrapages as $ratrapage) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($ratrapage['date']); ?></td>
                            <td><?php echo htmlspecialchars($ratrapage['heure']); ?></td>
                            <td><?php echo htmlspecialchars($ratrapage['duree']); ?></td>
                            <td><?php echo htmlspecialchars($ratrapage['matiere']); ?></td>
                            <td><?php echo htmlspecialchars($ratrapage['nom']); ?></td>
                            <td><?php echo htmlspecialchars($ratrapage['prénom']); ?></td>
                            <td><?php echo htmlspecialchars($ratrapage['groupe']); ?></td>
                            <td><?php echo htmlspecialchars($ratrapage['email']); ?></td>
                            <?php
                            if ($ratrapage['statut'] === 'accepté') {
                                $classe_statut = 'status-oui';
                                $texte_statut = 'OUI';
                            } else {
                                $classe_statut = 'status-non';
                                $texte_statut = 'NON';
                            }
                            ?>

                            <td class="<?php echo $classe_statut; ?>">
                                <?php echo $texte_statut; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</div>

<footer class="main-footer"></footer>

<script>
    // On attend que le DOM soit chargé avant de lancer le script
    document.addEventListener('DOMContentLoaded', function () {

        // récupération les éléments
        const tableau = document.getElementById('tableauRattrapages');
        const lesEntetes = tableau.querySelectorAll('thead th');
        const corpsDuTableau = tableau.querySelector('tbody');

        // ajout des écouteurs d'événements
        lesEntetes.forEach((entete, indexColonne) => {
            entete.addEventListener('click', () => {
                trierLeTableau(indexColonne, entete);
            });
        });

        function trierLeTableau(index, enteteClique) {
            // On transforme la NodeList des lignes en un vrai tableau Array pour pouvoir utiliser .sort()
            const lesLignes = Array.from(corpsDuTableau.querySelectorAll('tr'));

            // si le tableau est vide, on arrête.
            if (lesLignes.length === 1 && lesLignes[0].classList.contains('empty-table-message')) {
                return;
            }
            // On regarde si la colonne est déjà triée en ascendant
            const estActuellementCroissant = enteteClique.getAttribute('data-ordre') === 'asc';

            // Si c'est déjà croissant, on va trier en décroissant, sinon en croissant
            const nouvelOrdre = estActuellementCroissant ? 'desc' : 'asc';

            // On nettoie l'attribut 'data-ordre' sur toutes les colonnes pour éviter les confusions
            lesEntetes.forEach(th => th.removeAttribute('data-ordre'));

            // On applique le nouvel ordre à la colonne cliquée
            enteteClique.setAttribute('data-ordre', nouvelOrdre);

            // 1 = normal, -1 = inverse l'ordre
            const multiplicateur = (nouvelOrdre === 'asc') ? 1 : -1;

            // On récupère le type de donnée (date, heure, texte)
            const typeDeDonnee = enteteClique.getAttribute('data-type');


            // --- L'ALGORITHME DE TRI ---
            lesLignes.sort((ligneA, ligneB) => {
                // On récupère le texte contenu dans la cellule de la colonne concernée
                const contenuA = ligneA.children[index].innerText.trim();
                const contenuB = ligneB.children[index].innerText.trim();

                if (typeDeDonnee === 'date') {
                    const dateA = convertirDateFrancais(contenuA);
                    const dateB = convertirDateFrancais(contenuB);
                    // On soustrait les dates pour savoir laquelle est la plus grande
                    return (dateA - dateB) * multiplicateur;
                }
                else if (typeDeDonnee === 'heure') {
                    // Pour des heures
                    return contenuA.localeCompare(contenuB) * multiplicateur;
                }
                else {
                    // localeCompare gère bien les accents (ex: "Éléphant" vs "Eponge") et les chiffres
                    return contenuA.localeCompare(contenuB, 'fr', { numeric: true }) * multiplicateur;
                }
            });
            lesLignes.forEach(ligne => corpsDuTableau.appendChild(ligne));
        }

        function convertirDateFrancais(dateString) {
            if (!dateString) return new Date(0);

            const parties = dateString.split('/');

            const jour = parseInt(parties[0], 10);
            const mois = parseInt(parties[1], 10) - 1;
            const annee = parseInt(parties[2], 10);

            return new Date(annee, mois, jour);
        }
    });
</script>

</body>
</html>