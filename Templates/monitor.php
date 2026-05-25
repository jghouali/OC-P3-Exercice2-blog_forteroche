<?php

/** 
 * Affichage de la partie Supervision : liste des articles avec le nombre de vues, 
 * le nombre de commentaires et la date de publication de l'article 
 * @var string $sort indique : le tri à appliquer
 * @var string $colorSelected : le flag pour avoir un style différent si le tri est séléctionné
 * @var array $articles : liste des objets Article
 */

use App\Services\WebHelper;

?>

<h2>liste des articles</h2>

<table class="monitorArticle">
    <thead>
        <tr class="monitorHeader">
            <th class="title">Titre<br><a href="index.php?action=monitor&sort=title-za" <?= ($sort === 'title-za') ? $colorSelected : '' ?>>🠱</a> <a href="index.php?action=monitor&sort=title-az" <?= ($sort === 'title-az') ? $colorSelected : '' ?>>🠳</a></th>
            <th class="content">Contenu</th>
            <th class="content">Création<br><a href="index.php?action=monitor&sort=creation-za" <?= ($sort === 'creation-za') ? $colorSelected : '' ?>>🠱</a> <a href="index.php?action=monitor&sort=creation-az" <?= ($sort === 'creation-az') ? $colorSelected : '' ?>>🠳</a></th>
            <th class="content">Vue(s)<br><a href="index.php?action=monitor&sort=views-za" <?= ($sort === 'views-za') ? $colorSelected : '' ?>>🠱</a> <a href="index.php?action=monitor&sort=views-az" <?= ($sort === 'views-az') ? $colorSelected : '' ?>>🠳</a></th>
            <th class="content">Commentaires<br><a href="index.php?action=monitor&sort=comments-za" <?= ($sort === 'comments-za') ? $colorSelected : '' ?>>🠱</a> <a href="index.php?action=monitor&sort=comments-az" <?= ($sort === 'comments-az') ? $colorSelected : '' ?>>🠳</a></th>
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
                <td class="content"><?= $article->showFormattedContent($article->getContent(), 200) ?></td>
                <td class="contentCenter"> <?= ucfirst($article->getDateCreation()) ?> </td>
                <td class="contentCenter"><?= $article->getViewsCount() ?> </td>
                <td class="contentCenter"> <?= $article->getCommentsCount() ?> </td>
                </tr>
            <?php } ?>
    </tbody>
</table>