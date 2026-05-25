<?php

/**
 * Contrôleur de la partie admin.
 */

namespace App\Controllers;

use App\Entities\Article;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Views\View;
use App\Services\WebHelper;
use App\Services\ContentFormatter;
use Exception;

class AdminController
{

    /**
     * Affiche la page d'administration.
     * @return void
     */
    public function showAdmin(): void
    {
        // On vérifie que l'utilisateur est connecté.
        $this->checkIfUserIsConnected();

        // On récupère les articles.
        $articleRepository = new ArticleRepository();
        $articles = $articleRepository->getAllArticles();

        // On affiche la page d'administration.
        $view = new View("Administration");
        $view->render("admin", [
            'articles' => $articles
        ]);
    }

    /**
     * Affiche la page de Supervision.
     * @return void
     */
    public function showMonitor(): void
    {
        // On vérifie que l'utilisateur est connecté.
        $this->checkIfUserIsConnected();

        // On récupère le parametre de tri s'il existe.
        $sort = WebHelper::request("sort", -1);

        // On récupère les articles avec le nombre de commentaire.
        $articleRepository = new ArticleRepository();
        $articles = $articleRepository->getAllArticlesWithCommentsCount($sort);

        // On affiche la page d'administration.
        $view = new View("Supervision des Articles");
        $view->render("monitor", [
            'articles' => $articles,
            'sort' => $sort,
            'colorSelected' => 'style="color: var(--commentColor)"'
        ]);
    }

    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    private function checkIfUserIsConnected(): void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            WebHelper::redirect("connectionForm");
        }
    }

    /**
     * Affichage du formulaire de connexion.
     * @return void
     */
    public function displayConnectionForm(): void
    {
        $view = new View("Connexion");
        $view->render("connectionForm");
    }

    /**
     * Connexion de l'utilisateur.
     * @return void
     */
    public function connectUser(): void
    {
        // On récupère les données du formulaire.
        $login = WebHelper::request("login");
        $password = WebHelper::request("password");

        // On vérifie que les données sont valides.
        if (empty($login) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires. 1");
        }

        // On vérifie que l'utilisateur existe.
        $userRepository = new UserRepository();
        $user = $userRepository->getUserByLogin($login);
        if (!$user) {
            throw new Exception("L'utilisateur demandé n'existe pas.");
        }

        // On vérifie que le mot de passe est correct.
        if (!password_verify($password, $user->getPassword())) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            throw new Exception("Le mot de passe est incorrect : $hash");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page d'administration.
        WebHelper::redirect("admin");
    }

    /**
     * Déconnexion de l'utilisateur.
     * @return void
     */
    public function disconnectUser(): void
    {
        // On déconnecte l'utilisateur.
        unset($_SESSION['user']);

        // On redirige vers la page d'accueil.
        WebHelper::redirect("home");
    }

    /**
     * Affichage du formulaire d'ajout d'un article.
     * @return void
     */
    public function showUpdateArticleForm(): void
    {
        $this->checkIfUserIsConnected();

        // On récupère l'id de l'article s'il existe.
        $id = WebHelper::request("id", -1);

        // On récupère l'article associé.
        $articleRepository = new ArticleRepository();
        $article = $articleRepository->getArticleById($id);

        // Si l'article n'existe pas, on en crée un vide. 
        if (!$article) {
            $article = new Article();
        }

        // On affiche la page de modification de l'article.
        $view = new View("Edition d'un article");
        $view->render("updateArticleForm", [
            'article' => $article
        ]);
    }

    /**
     * Ajout et modification d'un article. 
     * On sait si un article est ajouté car l'id vaut -1.
     * @return void
     */
    public function updateArticle(): void
    {
        $this->checkIfUserIsConnected();

        // On récupère les données du formulaire.
        $id = WebHelper::request("id", -1);
        $title = WebHelper::request("title");
        $content = WebHelper::request("content");

        // On vérifie que les données sont valides.
        if (empty($title) || empty($content)) {
            throw new Exception("Tous les champs sont obligatoires. 2");
        }

        // On sanitize les données
        $contentFormatter = new ContentFormatter();
        $content = $contentFormatter->sanitize($content);
        $title = $contentFormatter->sanitize($title);

        // On crée l'objet Article.
        $article = new Article([
            'id' => $id, // Si l'id vaut -1, l'article sera ajouté. Sinon, il sera modifié.
            'title' => $title,
            'content' => $content,
            'id_user' => $_SESSION['idUser']
        ]);

        // On ajoute l'article.
        $articleRepository = new ArticleRepository();
        $articleRepository->addOrUpdateArticle($article);

        // On redirige vers la page d'administration.
        WebHelper::redirect("admin");
    }


    /**
     * Suppression d'un article.
     * @return void
     */
    public function deleteArticle(): void
    {
        $this->checkIfUserIsConnected();

        $id = WebHelper::request("id", -1);

        // On supprime l'article.
        $articleRepository = new ArticleRepository();
        $articleRepository->deleteArticle($id);

        // On redirige vers la page d'administration.
        WebHelper::redirect("admin");
    }


    /**
     * Suppression d'un commentaire.
     * @return void
     */
    public function deleteComment(): void
    {
        $this->checkIfUserIsConnected();

        $commentId = WebHelper::request("commentId", -1);
        $articleId = WebHelper::request("articleId", -1);

        // On supprime le commentaire.
        $commentRepository = new CommentRepository();
        $comment = $commentRepository->getCommentById($commentId);
        $commentRepository->deleteComment($comment);

        // On redirige vers la page d'administration.
        WebHelper::redirect("showArticle", ['id' => $articleId]);
    }
}
