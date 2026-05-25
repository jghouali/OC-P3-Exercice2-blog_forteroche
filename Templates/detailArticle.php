<?php

/**
 * Ce template affiche un article et ses commentaires.
 * Il affiche également un formulaire pour ajouter un commentaire.
 * @var Article $article send by View
 */
?>

<article class="mainArticle">
    <h2> <?= $article->showFormattedContent($article->getTitle()) ?> </h2>
    <span class="quotation">«</span>
    <p><?= $article->showFormattedContent($article->getContent()) ?></p>

    <div class="footer">
        <span class="info"> Publié le <?= $article->getDateCreation() ?></span>
        <?php if ($article->getDateUpdate() != null) { ?>
            <span class="info"> Modifié le <?= $article->getDateUpdate() ?></span>
        <?php } ?>
    </div>
</article>

<div class="comments">
    <h2 class="commentsTitle">Vos Commentaires</h2>
    <?php
    if (empty($comments)) {
        echo '<p class="info">Aucun commentaire pour cet article.</p>';
    } else {
        echo '<ul>';
        foreach ($comments as $comment) {
            echo '<li>';
            echo '  <div class="smiley">☻</div>';
            echo '  <div class="detailComment">';
            echo '      <h3 class="info">Le ' . $comment->getDateCreation() . ", " . $article->showFormattedContent($comment->getPseudo()) . ' a écrit :</h3>';
            echo '      <p class="content">' . $article->showFormattedContent($comment->getContent()) . '</p>';
            echo '  </div>';
            if (isset($_SESSION['user'])) {
                $articleId = $article->getId();
                $commenId = $comment->getId();
                echo "<div class='delete'><a href=index.php?action=deleteComment&articleId=$articleId&commentId=$commenId >Supprimer</a></div>";
            }
            echo '</li>';
        }
        echo '</ul>';
    }
    ?>

    <form action="index.php" method="post" class="foldedCorner">
        <h2>Commenter</h2>

        <div class="formComment formGrid">
            <label for="pseudo">Pseudonyme</label>
            <input type="text" name="pseudo" id="pseudo" required>

            <label for="content">Commentaire</label>
            <textarea name="content" id="content" required></textarea>

            <input type="hidden" name="action" value="addComment">
            <input type="hidden" name="idArticle" value="<?= $article->getId() ?>">

            <button class="submit">Ajouter un commentaire</button>
        </div>
    </form>
</div>