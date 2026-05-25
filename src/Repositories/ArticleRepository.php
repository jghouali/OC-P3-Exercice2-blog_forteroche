<?php

namespace App\Repositories;

use App\Entities\Article;
use App\Repositories\AbstractRepository;

/**
 * Classe qui gère les articles.
 */
class ArticleRepository extends AbstractRepository
{
    /**
     * Récupère tous les articles.
     * @return array : un tableau d'objets Article.
     */
    public function getAllArticles(): array
    {
        $sql = "SELECT * FROM article";
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }

    public function getAllArticlesWithCommentsCount(string $sort): array
    {
        $sql = "SELECT article.*,
                    COUNT(comment.id_article) as comments_count
                    FROM article
                    LEFT JOIN comment
                    ON article.id = comment.id_article
                    GROUP BY article.id ";
        switch ($sort) {
            case 'title-az':
                $sql = $sql . "ORDER BY title ASC";
                break;

            case 'title-za':
                $sql = $sql . "ORDER BY title DESC";
                break;

            case 'creation-az':
                $sql = $sql . "ORDER BY date_creation ASC";
                break;

            case 'creation-za':
                $sql = $sql . "ORDER BY date_creation DESC";
                break;

            case 'views-az':
                $sql = $sql . "ORDER BY views_count ASC";
                break;

            case 'views-za':
                $sql = $sql . "ORDER BY views_count DESC";
                break;

            case 'comments-az':
                $sql = $sql . "ORDER BY comments_count ASC";
                break;

            case 'comments-za':
                $sql = $sql . "ORDER BY comments_count DESC";
                break;
        }
        $result = $this->db->query($sql);
        $articles = [];

        while ($article = $result->fetch()) {
            $articles[] = new Article($article);
        }
        return $articles;
    }

    /**
     * Récupère un article par son id.
     * @param int $id : l'id de l'article.
     * @return Article|null : un objet Article ou null si l'article n'existe pas.
     */
    public function getArticleById(int $id): ?Article
    {
        $sql = "SELECT * FROM article WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $article = $result->fetch();
        if ($article) {
            return new Article($article);
        }
        return null;
    }

    /**
     * Ajoute ou modifie un article.
     * On sait si l'article est un nouvel article car son id sera -1.
     * @param Article $article : l'article à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateArticle(Article $article): void
    {
        if ($article->getId() == -1) {
            $this->addArticle($article);
        } else {
            $this->updateArticle($article);
        }
    }

    /**
     * Ajoute un article.
     * @param Article $article : l'article à ajouter.
     * @return void
     */
    public function addArticle(Article $article): void
    {
        $sql = "INSERT INTO article (id_user, title, content, date_creation, date_update, views_count) VALUES (:id_user, :title, :content, NOW(), NOW(), 0)";
        $this->db->query($sql, [
            'id_user' => $article->getIdUser(),
            'title' => $article->getTitle(),
            'content' => $article->getContent()
        ]);
    }

    /**
     * Modifie un article.
     * @param Article $article : l'article à modifier.
     * @return void
     */
    public function updateArticle(Article $article): void
    {
        $sql = "UPDATE article SET title = :title, content = :content, date_update = NOW(), views_count = :views_count WHERE id = :id";
        $this->db->query($sql, [
            'title' => $article->getTitle(),
            'content' => $article->getContent(),
            'views_count' => $article->getViewsCount(),
            'id' => $article->getId()
        ]);
    }

    /**
     * Supprime un article.
     * @param int $id : l'id de l'article à supprimer.
     * @return void
     */
    public function deleteArticle(int $id): void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }
}
