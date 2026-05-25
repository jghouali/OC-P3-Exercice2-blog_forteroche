<?php

namespace App\Entities;

use DateTime;

/**
 * Entité Article, un article est défini par les champs
 * id, id_user, title, content, date_creation, date_update
 */
class Article extends AbstractEntity
{
    private int $idUser;
    private string $title = "";
    private string $content = "";
    private ?DateTime $dateCreation = null;
    private ?DateTime $dateUpdate = null;
    private int $viewsCount = 0;
    private int $commentsCount = 0;

    /**
     * Setter pour l'id de l'utilisateur. 
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * Getter pour l'id de l'utilisateur.
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * Setter pour le titre.
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter pour le titre.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Setter pour le contenu.
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Getter pour le contenu.
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateCreation
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setDateCreation(string|DateTime $dateCreation, string $format = 'Y-m-d H:i:s'): void
    {
        if (is_string($dateCreation)) {
            $dateCreation = DateTime::createFromFormat($format, $dateCreation);
        }
        $this->dateCreation = $dateCreation;
    }

    /**
     * Getter pour la date de création.
     * La date est affiché selon la locale definit dans config.php
     * @return string
     */
    public function getDateCreation(): string
    {
        return $this->dateFormat($this->dateCreation);
    }

    /**
     * Setter pour la date de mise à jour. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateUpdate
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé.
     */
    public function setDateUpdate(string|DateTime $dateUpdate, string $format = 'Y-m-d H:i:s'): void
    {
        if (is_string($dateUpdate)) {
            $dateUpdate = DateTime::createFromFormat($format, $dateUpdate);
        }
        $this->dateUpdate = $dateUpdate;
    }

    /**
     * Getter pour la date de mise à jour.
     * La date est affiché selon la locale definit dans config.php
     * @return string|null
     */
    public function getDateUpdate(): string|null
    {
        return $this->dateFormat($this->dateUpdate);
    }

    /**
     * Getter pour le nombre de vue.
     * @return int
     */
    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }

    /**
     * Setter pour le nombre de vue.
     * @param int $viewsCount nombre de vues
     */
    public function setViewsCount(int $viewsCount): void
    {
        $this->viewsCount = $viewsCount;
    }

    /**
     * Setter pour incrémenter le nombre de vue.
     * @return void
     */
    public function incrementViewsCount(): void
    {
        $this->viewsCount += 1;
    }

    /**
     * Getter pour le nombre de vue.
     * @return int
     */
    public function getCommentsCount(): int
    {
        return $this->commentsCount;
    }

    /**
     * Setter pour le nombre de vue.
     * @param $commentsCount int
     */
    public function setCommentsCount(int $commentsCount): void
    {
        $this->commentsCount = $commentsCount;
    }
}
