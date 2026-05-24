<?php

/** 
 * Affichage de la partie Supervision : liste des articles avec le nombre de vues, 
 * le nombre de commentaires et la date de publication de l'article 
 */
?>

<h2>liste des articles</h2>

<table class="monitorArticle">
    <thead>
        <tr class="monitorHeader">
            <th class="title">Titre<br><a href="index.php?action=monitor&sort=title-za">🠱</a> <a href="index.php?action=monitor&sort=title-az">🠳</a></th>
            <th class="content">Contenu</th>
            <th class="content">Création<br><a href="index.php?action=monitor&sort=creation-za">🠱</a> <a href="index.php?action=monitor&sort=creation-az">🠳</a></th>
            <th class="content">Vue(s)<br><a href="index.php?action=monitor&sort=views-za">🠱</a> <a href="index.php?action=monitor&sort=views-az">🠳</a></th>
            <th class="content">Commentaires<br><a href="index.php?action=monitor&sort=comments-za">🠱</a> <a href="index.php?action=monitor&sort=comments-az">🠳</a></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $toggleMonitorLine2 = -1;
        foreach ($articles as $article) {
            $toggleMonitorLine2 *= -1;
            if ($toggleMonitorLine2 === 1) {
        ?>
                <tr class="monitorLine">
                <?php } else { ?>
                <tr class="monitorLine monitorLine2">
                <?php } ?>
                <td class="title"><?= $article->getTitle() ?></td>
                <td class="content"><?= $article->getContent(200) ?></td>
                <td class="contentCenter"> <?= ucfirst(Utils::convertDateToFrenchFormat($article->getDateCreation())) ?> </td>
                <td class="contentCenter"><?= $article->getViewsCount() ?> </td>
                <td class="contentCenter"> <?= $article->getCommentsCount() ?> </td>
                </tr>
            <?php } ?>
    </tbody>
</table>