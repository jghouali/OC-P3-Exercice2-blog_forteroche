<?php

/** 
 * Affichage de la partie Supervision : liste des articles avec le nombre de vues, 
 * le nombre de commentaires et la date de publication de l'article 
 */
?>

<h2>liste des articles</h2>

<div class="adminArticle">
    <?php
    $toggleArticleLine2 = -1;
    foreach ($articles as $article) {
        $toggleArticleLine2 *= -1;
        if ($toggleArticleLine2 === 1) {
    ?>
            <div class="articleLine">
            <?php } else { ?>
                <div class="articleLine articleLine2">
                <?php } ?>
                <div class="title"><?= $article->getTitle() ?></div>
                <div class="content"><?= $article->getContent(200) ?></div>
                <div class="content"><?= $article->getViewsCount() ?> vue(s)</div>
                <div class="content"> créé le <?= ucfirst(Utils::convertDateToFrenchFormat($article->getDateCreation())) ?> </div>
                <div class="content"> <?= $commentsCount[$article->getId()] ?> commentaires</div>
                </div>
            <?php } ?>
            </div>