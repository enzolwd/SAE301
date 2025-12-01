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

    <div class="filtres-container">
        <input type="text" id="filtreDate" placeholder="Date (jj/mm/aaaa)">
        <input type="text" id="filtreEtudiant" placeholder="Étudiant (Nom ou Prénom)">
        <input type="text" id="filtreMatiere" placeholder="Matière">
    </div>
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

        // === AJOUT : LOGIQUE DE FILTRAGE ===
        const inputDate = document.getElementById('filtreDate');
        const inputEtudiant = document.getElementById('filtreEtudiant');
        const inputMatiere = document.getElementById('filtreMatiere');

        function appliquerFiltres() {
            const valeurDate = inputDate.value.toLowerCase();
            const valeurEtudiant = inputEtudiant.value.toLowerCase();
            const valeurMatiere = inputMatiere.value.toLowerCase();

            const lignes = corpsDuTableau.querySelectorAll('tr');

            lignes.forEach(ligne => {
                // Ignore la ligne "tableau vide"
                if(ligne.classList.contains('empty-table-message')) return;

                // Récupération des données (Indices basés sur l'ordre des <th>)
                // 0: Date, 3: Matière, 4: Nom, 5: Prénom
                const dateTexte = ligne.children[0].innerText.toLowerCase();
                const matiereTexte = ligne.children[3].innerText.toLowerCase();
                const nomTexte = ligne.children[4].innerText.toLowerCase();
                const prenomTexte = ligne.children[5].innerText.toLowerCase();
                const etudiantComplet = nomTexte + " " + prenomTexte;

                // Vérification des conditions
                const matchDate = dateTexte.includes(valeurDate);
                const matchMatiere = matiereTexte.includes(valeurMatiere);
                // On cherche dans Nom OU Prénom OU la concaténation
                const matchEtudiant = nomTexte.includes(valeurEtudiant) ||
                    prenomTexte.includes(valeurEtudiant) ||
                    etudiantComplet.includes(valeurEtudiant);

                if (matchDate && matchMatiere && matchEtudiant) {
                    ligne.style.display = '';
                } else {
                    ligne.style.display = 'none';
                }
            });
        }

        // Écouteurs d'événements sur les inputs
        inputDate.addEventListener('input', appliquerFiltres);
        inputEtudiant.addEventListener('input', appliquerFiltres);
        inputMatiere.addEventListener('input', appliquerFiltres);
        // === FIN AJOUT ===


        // ajout des écouteurs d'événements (EXISTANT)
        lesEntetes.forEach((entete, indexColonne) => {
            entete.addEventListener('click', () => {
                trierLeTableau(indexColonne, entete);
            });
        });

        function trierLeTableau(index, enteteClique) {
            // ... Code de tri existant inchangé ...
            // (Je ne répète pas tout le code de tri existant pour gagner de la place,
            // mais il reste ici tel quel)
            const lesLignes = Array.from(corpsDuTableau.querySelectorAll('tr'));
            if (lesLignes.length === 1 && lesLignes[0].classList.contains('empty-table-message')) return;
            const estActuellementCroissant = enteteClique.getAttribute('data-ordre') === 'asc';
            const nouvelOrdre = estActuellementCroissant ? 'desc' : 'asc';
            lesEntetes.forEach(th => th.removeAttribute('data-ordre'));
            enteteClique.setAttribute('data-ordre', nouvelOrdre);
            const multiplicateur = (nouvelOrdre === 'asc') ? 1 : -1;
            const typeDeDonnee = enteteClique.getAttribute('data-type');

            lesLignes.sort((ligneA, ligneB) => {
                // Important : Si une ligne est masquée par le filtre, on la trie quand même
                // pour que l'ordre soit correct si on efface le filtre ensuite.
                const contenuA = ligneA.children[index].innerText.trim();
                const contenuB = ligneB.children[index].innerText.trim();

                if (typeDeDonnee === 'date') {
                    const dateA = convertirDateFrancais(contenuA);
                    const dateB = convertirDateFrancais(contenuB);
                    return (dateA - dateB) * multiplicateur;
                }
                else if (typeDeDonnee === 'heure') {
                    return contenuA.localeCompare(contenuB) * multiplicateur;
                }
                else {
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