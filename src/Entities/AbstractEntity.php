<?php

namespace App\Entities;

use App\Services\ContentFormatter;
use App\Services\DateFormatter;
use DateTime;

abstract class AbstractEntity
{
    // Par défaut l'id vaut -1, ce qui permet de vérifier facilement si l'entité est nouvelle ou pas. 
    protected int $id = -1;
    private ?DateFormatter $dateFormater = null;
    private ?ContentFormatter $contentFormatter = null;

    /**
     * Constructeur de la classe.
     * Si un tableau associatif est passé en paramètre, on hydrate l'entité.
     * 
     * @param array $data
     */
    public function __construct(array $data = [])
    {

        $this->dateFormater = new DateFormatter();
        $this->contentFormatter = new ContentFormatter();
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    /**
     * Système d'hydratation de l'entité.
     * Permet de transformer les données d'un tableau associatif.
     * Les noms de champs de la table doivent correspondre aux noms des attributs de l'entité.
     * Les underscore sont transformés en camelCase (ex: date_creation devient setDateCreation).
     * @return void
     */
    protected function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . str_replace('_', '', ucwords($key, '_'));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /** 
     * Setter pour l'id.
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * Getter pour l'id.
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function dateFormat(Datetime $dateTime): string
    {
        return $this->dateFormater->format($dateTime);
    }

    public function showFormattedContent(string $content, ?int $lenght = -1): string
    {

        return $this->contentFormatter->format($content, $lenght);
    }
}
