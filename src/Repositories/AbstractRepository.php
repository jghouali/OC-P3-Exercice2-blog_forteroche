<?php

namespace App\Repositories;

use App\Databases\Database;

/**
 * Classe abstraite qui représente un manager. Elle récupère automatiquement le gestionnaire de base de données. 
 */
abstract class AbstractRepository
{

    protected $db;

    /**
     * Constructeur de la classe.
     * Il récupère automatiquement l'instance de DBManager. 
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
