<?php
require_once '../Presentation/Statistique_Accueil_Presenteur.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page Statistique Accueil</title>
    <link rel="stylesheet" href="css/Style_Page_Statistique_Accueil.css">
</head>

<body>

<div class="header-main">
    <div class="logo-section">
        <img src="images/logo_uphf.png" alt="Logo Université Polytechnique">
    </div>

    <div class="header-right">
        <p>ESPACE NUMÉRIQUE DE TRAVAIL</p>
        <a href="Page_Accueil_Responsable.php" class="bouton-statistique">Tableau de bord</a>
        <a href="../Presentation/Deconnexion_Presenteur.php" class="bouton-deconnexion">Déconnexion</a>
    </div>
</div>

<div class="container">

    <?php if (!empty($errorMessage)) : ?>
        <div class="message-erreur">
            <?php echo htmlspecialchars($errorMessage); ?>
        </div>
    <?php endif; ?>

    <h1 class="titre-principal">Liste des Absences</h1>

    <div class="content-wrapper">

        <section class="tableau-wrapper">
            <div class="table-container">
                <table class="tableau">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Durée</th>
                        <th>Matière</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Groupe</th>
                        <th>Email</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if (empty($lesRattrapages)) : ?>
                        <tr class="empty-table-message">
                            <td colspan="8">Aucune absence non justifiée à ce jour.</td>
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
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="sidebar-section">
            <div class="stats-box">
                <h3>Nombre d'absences par ressource</h3>

                <form action="Page_Statistique_Accueil.php" method="get" id="form-ressource">
                    <select name="ressource" id="ressource-select" onchange="this.form.submit();">
                        <option value="" <?php if ($ressource_selectionnee == '') echo 'selected'; ?>>Choisir une ressource</option>
                        <option value="TOUT" <?php if ($ressource_selectionnee == 'TOUT') echo 'selected'; ?>>TOUT</option>

                        <optgroup label="Semestre 1">
                            <option value="P1.01" <?php if ($ressource_selectionnee == 'P1.01') echo 'selected'; ?>>P1.01</option>
                            <option value="R1.01" <?php if ($ressource_selectionnee == 'R1.01') echo 'selected'; ?>>R1.01</option>
                            <option value="R1.02" <?php if ($ressource_selectionnee == 'R1.02') echo 'selected'; ?>>R1.02</option>
                            <option value="R1.03" <?php if ($ressource_selectionnee == 'R1.03') echo 'selected'; ?>>R1.03</option>
                            <option value="R1.04" <?php if ($ressource_selectionnee == 'R1.04') echo 'selected'; ?>>R1.04</option>
                            <option value="R1.05" <?php if ($ressource_selectionnee == 'R1.05') echo 'selected'; ?>>R1.05</option>
                            <option value="R1.06" <?php if ($ressource_selectionnee == 'R1.06') echo 'selected'; ?>>R1.06</option>
                            <option value="R1.07" <?php if ($ressource_selectionnee == 'R1.07') echo 'selected'; ?>>R1.07</option>
                            <option value="R1.08" <?php if ($ressource_selectionnee == 'R1.08') echo 'selected'; ?>>R1.08</option>
                            <option value="R1.09" <?php if ($ressource_selectionnee == 'R1.09') echo 'selected'; ?>>R1.09</option>
                            <option value="R1.10" <?php if ($ressource_selectionnee == 'R1.10') echo 'selected'; ?>>R1.10</option>
                            <option value="R1.11" <?php if ($ressource_selectionnee == 'R1.11') echo 'selected'; ?>>R1.11</option>
                            <option value="R1.12" <?php if ($ressource_selectionnee == 'R1.12') echo 'selected'; ?>>R1.12</option>
                            <option value="S1.01" <?php if ($ressource_selectionnee == 'S1.01') echo 'selected'; ?>>S1.01</option>
                            <option value="S1.02" <?php if ($ressource_selectionnee == 'S1.02') echo 'selected'; ?>>S1.02</option>
                            <option value="S1.03" <?php if ($ressource_selectionnee == 'S1.03') echo 'selected'; ?>>S1.03</option>
                            <option value="S1.04" <?php if ($ressource_selectionnee == 'S1.04') echo 'selected'; ?>>S1.04</option>
                            <option value="S1.05" <?php if ($ressource_selectionnee == 'S1.05') echo 'selected'; ?>>S1.05</option>
                            <option value="S1.06" <?php if ($ressource_selectionnee == 'S1.06') echo 'selected'; ?>>S1.06</option>
                        </optgroup>
                        <optgroup label="Semestre 2">
                            <option value="P2.01" <?php if ($ressource_selectionnee == 'P2.01') echo 'selected'; ?>>P2.01</option>
                            <option value="R2.01" <?php if ($ressource_selectionnee == 'R2.01') echo 'selected'; ?>>R2.01</option>
                            <option value="R2.02" <?php if ($ressource_selectionnee == 'R2.02') echo 'selected'; ?>>R2.02</option>
                            <option value="R2.03" <?php if ($ressource_selectionnee == 'R2.03') echo 'selected'; ?>>R2.03</option>
                            <option value="R2.04" <?php if ($ressource_selectionnee == 'R2.04') echo 'selected'; ?>>R2.04</option>
                            <option value="R2.05" <?php if ($ressource_selectionnee == 'R2.05') echo 'selected'; ?>>R2.05</option>
                            <option value="R2.06" <?php if ($ressource_selectionnee == 'R2.06') echo 'selected'; ?>>R2.06</option>
                            <option value="R2.07" <?php if ($ressource_selectionnee == 'R2.07') echo 'selected'; ?>>R2.07</option>
                            <option value="R2.08" <?php if ($ressource_selectionnee == 'R2.08') echo 'selected'; ?>>R2.08</option>
                            <option value="R2.09" <?php if ($ressource_selectionnee == 'R2.09') echo 'selected'; ?>>R2.09</option>
                            <option value="R2.10" <?php if ($ressource_selectionnee == 'R2.10') echo 'selected'; ?>>R2.10</option>
                            <option value="R2.11" <?php if ($ressource_selectionnee == 'R2.11') echo 'selected'; ?>>R2.11</option>
                            <option value="R2.12" <?php if ($ressource_selectionnee == 'R2.12') echo 'selected'; ?>>R2.12</option>
                            <option value="R2.13" <?php if ($ressource_selectionnee == 'R2.13') echo 'selected'; ?>>R2.13</option>
                            <option value="R2.14" <?php if ($ressource_selectionnee == 'R2.14') echo 'selected'; ?>>R2.14</option>
                            <option value="S2.01" <?php if ($ressource_selectionnee == 'S2.01') echo 'selected'; ?>>S2.01</option>
                            <option value="S2.02" <?php if ($ressource_selectionnee == 'S2.02') echo 'selected'; ?>>S2.02</option>
                            <option value="S2.03" <?php if ($ressource_selectionnee == 'S2.03') echo 'selected'; ?>>S2.03</option>
                            <option value="S2.04" <?php if ($ressource_selectionnee == 'S2.04') echo 'selected'; ?>>S2.04</option>
                            <option value="S2.05" <?php if ($ressource_selectionnee == 'S2.05') echo 'selected'; ?>>S2.05</option>
                            <option value="S2.06" <?php if ($ressource_selectionnee == 'S2.06') echo 'selected'; ?>>S2.06</option>
                        </optgroup>
                        <optgroup label="Semestre 3">
                            <option value="P3.01" <?php if ($ressource_selectionnee == 'P3.01') echo 'selected'; ?>>P3.01</option>
                            <option value="R3.01" <?php if ($ressource_selectionnee == 'R3.01') echo 'selected'; ?>>R3.01</option>
                            <option value="R3.02" <?php if ($ressource_selectionnee == 'R3.02') echo 'selected'; ?>>R3.02</option>
                            <option value="R3.03" <?php if ($ressource_selectionnee == 'R3.03') echo 'selected'; ?>>R3.03</option>
                            <option value="R3.04.1" <?php if ($ressource_selectionnee == 'R3.04.1') echo 'selected'; ?>>R3.04.1</option>
                            <option value="R3.04.2" <?php if ($ressource_selectionnee == 'R3.04.2') echo 'selected'; ?>>R3.04.2</option>
                            <option value="R3.05" <?php if ($ressource_selectionnee == 'R3.05') echo 'selected'; ?>>R3.05</option>
                            <option value="R3.06" <?php if ($ressource_selectionnee == 'R3.06') echo 'selected'; ?>>R3.06</option>
                            <option value="R3.07" <?php if ($ressource_selectionnee == 'R3.07') echo 'selected'; ?>>R3.07</option>
                            <option value="R3.08" <?php if ($ressource_selectionnee == 'R3.08') echo 'selected'; ?>>R3.08</option>
                            <option value="R3.09" <?php if ($ressource_selectionnee == 'R3.09') echo 'selected'; ?>>R3.09</option>
                            <option value="R3.10" <?php if ($ressource_selectionnee == 'R3.10') echo 'selected'; ?>>R3.10</option>
                            <option value="R3.11" <?php if ($ressource_selectionnee == 'R3.11') echo 'selected'; ?>>R3.11</option>
                            <option value="R3.12" <?php if ($ressource_selectionnee == 'R3.12') echo 'selected'; ?>>R3.12</option>
                            <option value="R3.13" <?php if ($ressource_selectionnee == 'R3.13') echo 'selected'; ?>>R3.13</option>
                            <option value="R3.14" <?php if ($ressource_selectionnee == 'R3.14') echo 'selected'; ?>>R3.14</option>
                            <option value="S3.A.01-B.01" <?php if ($ressource_selectionnee == 'S3.A.01-B.01') echo 'selected'; ?>>S3.A.01-B.01</option>
                            <option value="S3.A.01-B.01.GP" <?php if ($ressource_selectionnee == 'S3.A.01-B.01.GP') echo 'selected'; ?>>S3.A.01-B.01.GP</option>
                        </optgroup>
                        <optgroup label="Semestre 4">
                            <option value="P4.01" <?php if ($ressource_selectionnee == 'P4.01') echo 'selected'; ?>>P4.01</option>
                            <option value="R4.01" <?php if ($ressource_selectionnee == 'R4.01') echo 'selected'; ?>>R4.01</option>
                            <option value="R4.02" <?php if ($ressource_selectionnee == 'R4.02') echo 'selected'; ?>>R4.02</option>
                            <option value="R4.03" <?php if ($ressource_selectionnee == 'R4.03') echo 'selected'; ?>>R4.03</option>
                            <option value="R4.04" <?php if ($ressource_selectionnee == 'R4.04') echo 'selected'; ?>>R4.04</option>
                            <option value="R4.05" <?php if ($ressource_selectionnee == 'R4.05') echo 'selected'; ?>>R4.05</option>
                            <option value="R4.06" <?php if ($ressource_selectionnee == 'R4.06') echo 'selected'; ?>>R4.06</option>
                            <option value="R4.07" <?php if ($ressource_selectionnee == 'R4.07') echo 'selected'; ?>>R4.07</option>
                            <option value="R4.13" <?php if ($ressource_selectionnee == 'R4.13') echo 'selected'; ?>>R4.13</option>
                            <option value="R4.A.08-B.08" <?php if ($ressource_selectionnee == 'R4.A.08-B.08') echo 'selected'; ?>>R4.A.08-B.08</option>
                            <option value="R4.A.09-B.09" <?php if ($ressource_selectionnee == 'R4.A.09-B.09') echo 'selected'; ?>>R4.A.09-B.09</option>
                            <option value="R4.A.10" <?php if ($ressource_selectionnee == 'R4.A.10') echo 'selected'; ?>>R4.A.10</option>
                            <option value="R4.A.11" <?php if ($ressource_selectionnee == 'R4.A.11') echo 'selected'; ?>>R4.A.11</option>
                            <option value="R4.A.12" <?php if ($ressource_selectionnee == 'R4.A.12') echo 'selected'; ?>>R4.A.12</option>
                            <option value="R4.B.10" <?php if ($ressource_selectionnee == 'R4.B.10') echo 'selected'; ?>>R4.B.10</option>
                            <option value="R4.B.11" <?php if ($ressource_selectionnee == 'R4.B.11') echo 'selected'; ?>>R4.B.11</option>
                            <option value="R4.B.12" <?php if ($ressource_selectionnee == 'R4.B.12') echo 'selected'; ?>>R4.B.12</option>
                            <option value="S4.A.01" <?php if ($ressource_selectionnee == 'S4.A.01') echo 'selected'; ?>>S4.A.01</option>
                            <option value="S4.A.01-B.01" <?php if ($ressource_selectionnee == 'S4.A.01-B.01') echo 'selected'; ?>>S4.A.01-B.01</option>
                            <option value="S4.B.01" <?php if ($ressource_selectionnee == 'S4.B.01') echo 'selected'; ?>>S4.B.01</option>
                        </optgroup>
                        <optgroup label="Semestre 5">
                            <option value="P5.A.01-B.01" <?php if ($ressource_selectionnee == 'P5.A.01-B.01') echo 'selected'; ?>>P5.A.01-B.01</option>
                            <option value="R5.01" <?php if ($ressource_selectionnee == 'R5.01') echo 'selected'; ?>>R5.01</option>
                            <option value="R5.03" <?php if ($ressource_selectionnee == 'R5.03') echo 'selected'; ?>>R5.03</option>
                            <option value="R5.A.02-B.02" <?php if ($ressource_selectionnee == 'R5.A.02-B.02') echo 'selected'; ?>>R5.A.02-B.02</option>
                            <option value="R5.A.04" <?php if ($ressource_selectionnee == 'R5.A.04') echo 'selected'; ?>>R5.A.04</option>
                            <option value="R5.A.05" <?php if ($ressource_selectionnee == 'R5.A.05') echo 'selected'; ?>>R5.A.05</option>
                            <option value="R5.A.06" <?php if ($ressource_selectionnee == 'R5.A.06') echo 'selected'; ?>>R5.A.06</option>
                            <option value="R5.A.07-B.05" <?php if ($ressource_selectionnee == 'R5.A.07-B.05') echo 'selected'; ?>>R5.A.07-B.05</option>
                            <option value="R5.A.08" <?php if ($ressource_selectionnee == 'R5.A.08') echo 'selected'; ?>>R5.A.08</option>
                            <option value="R5.A.09-B.07" <?php if ($ressource_selectionnee == 'R5.A.09-B.07') echo 'selected'; ?>>R5.A.09-B.07</option>
                            <option value="R5.A.10" <?php if ($ressource_selectionnee == 'R5.A.10') echo 'selected'; ?>>R5.A.10</option>
                            <option value="R5.A.11" <?php if ($ressource_selectionnee == 'R5.A.11') echo 'selected'; ?>>R5.A.11</option>
                            <option value="R5.A.12" <?php if ($ressource_selectionnee == 'R5.A.12') echo 'selected'; ?>>R5.A.12</option>
                            <option value="R5.A.13-B.11" <?php if ($ressource_selectionnee == 'R5.A.13-B.11') echo 'selected'; ?>>R5.A.13-B.11</option>
                            <option value="R5.A.14-B.12" <?php if ($ressource_selectionnee == 'R5.A.14-B.12') echo 'selected'; ?>>R5.A.14-B.12</option>
                            <option value="R5.A.15" <?php if ($ressource_selectionnee == 'R5.A.15') echo 'selected'; ?>>R5.A.15</option>
                            <option value="R5.A.16" <?php if ($ressource_selectionnee == 'R5.A.16') echo 'selected'; ?>>R5.A.16</option>
                            <option value="R5.B.04" <?php if ($ressource_selectionnee == 'R5.B.04') echo 'selected'; ?>>R5.B.04</option>
                            <option value="R5.B.06" <?php if ($ressource_selectionnee == 'R5.B.06') echo 'selected'; ?>>R5.B.06</option>
                            <option value="R5.B.08" <?php if ($ressource_selectionnee == 'R5.B.08') echo 'selected'; ?>>R5.B.08</option>
                            <option value="R5.B.09" <?php if ($ressource_selectionnee == 'R5.B.09') echo 'selected'; ?>>R5.B.09</option>
                            <option value="R5.B.10" <?php if ($ressource_selectionnee == 'R5.B.10') echo 'selected'; ?>>R5.B.10</option>
                            <option value="R5.B.13" <?php if ($ressource_selectionnee == 'R5.B.13') echo 'selected'; ?>>R5.B.13</option>
                            <option value="R5.B.14" <?php if ($ressource_selectionnee == 'R5.B.14') echo 'selected'; ?>>R5.B.14</option>
                            <option value="R5.MP" <?php if ($ressource_selectionnee == 'R5.MP') echo 'selected'; ?>>R5.MP</option>
                            <option value="S5.A.01" <?php if ($ressource_selectionnee == 'S5.A.01') echo 'selected'; ?>>S5.A.01</option>
                            <option value="S5.A.02" <?php if ($ressource_selectionnee == 'S5.A.02') echo 'selected'; ?>>S5.A.02</option>
                            <option value="S5.B.01" <?php if ($ressource_selectionnee == 'S5.B.01') echo 'selected'; ?>>S5.B.01</option>
                        </optgroup>
                        <optgroup label="Semestre 6">
                            <option value="P6.A.01-B.01" <?php if ($ressource_selectionnee == 'P6.A.01-B.01') echo 'selected'; ?>>P6.A.01-B.01</option>
                            <option value="R6.01" <?php if ($ressource_selectionnee == 'R6.01') echo 'selected'; ?>>R6.01</option>
                            <option value="R6.02" <?php if ($ressource_selectionnee == 'R6.02') echo 'selected'; ?>>R6.02</option>
                            <option value="R6.03" <?php if ($ressource_selectionnee == 'R6.03') echo 'selected'; ?>>R6.03</option>
                            <option value="R6.07" <?php if ($ressource_selectionnee == 'R6.07') echo 'selected'; ?>>R6.07</option>
                            <option value="R6.A.04-B.04" <?php if ($ressource_selectionnee == 'R6.A.04-B.04') echo 'selected'; ?>>R6.A.04-B.04</option>
                            <option value="R6.A.05" <?php if ($ressource_selectionnee == 'R6.A.05') echo 'selected'; ?>>R6.A.05</option>
                            <option value="R6.A.06" <?php if ($ressource_selectionnee == 'R6.A.06') echo 'selected'; ?>>R6.A.06</option>
                            <option value="R6.B.05" <?php if ($ressource_selectionnee == 'R6.B.05') echo 'selected'; ?>>R6.B.05</option>
                            <option value="R6.B.06" <?php if ($ressource_selectionnee == 'R6.B.06') echo 'selected'; ?>>R6.B.06</option>
                            <option value="S6.A.01" <?php if ($ressource_selectionnee == 'S6.A.01') echo 'selected'; ?>>S6.A.01</option>
                            <option value="S6.A.01-B.01" <?php if ($ressource_selectionnee == 'S6.A.01-B.01') echo 'selected'; ?>>S6.A.01-B.01</option>
                            <option value="S6.B.01" <?php if ($ressource_selectionnee == 'S6.B.01') echo 'selected'; ?>>S6.B.01</option>
                        </optgroup>
                    </select>
                </form>

                <p class="stats-result">Il y a <?php echo htmlspecialchars($nbrRattrapages) ?> absences(s).</p>
            </div>

            <a href="Page_Selection_Etudiant_Statistique.php" class="action-button-stat-etu">Consulter les statistiques d'un étudiant</a>
        </aside>

    </div>

</div>

<footer class="main-footer"></footer>

</body>
</html>