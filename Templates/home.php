<?php

/**
 * Affichage de Liste des articles. 
 * @var array $articles send by View
 */
?>

<div class="articleList">
    <?php foreach ($articles as $article) { ?>
        <article class="article">
            <h2><?= $article->showFormattedContent($article->getTitle()) ?></h2>
            <span class="quotation">«</span>
            <p><?= $article->showFormattedContent($article->getContent(), 400) ?></p>

            <div class="footer">
                <span class="info"> <?= $article->getDateCreation() ?></span>
                <a class="info" href="index.php?action=showArticle&id=<?= $article->getId() ?>">Lire +</a>
            </div>
        </article>
    <?php } ?>
</div>