<?php

/**
 * Système d'autoload. 
 * A chaque fois que PHP va avoir besoin d'une classe, il va appeler cette fonction 
 * et mappera le namespace App dans le répertoire src
 * Tout les sous-namespaces correspndent aux sous-dossier de src 
 * (ici Entities, Controllers, Databases, Repositories, Services, Views) 
 * s'il trouve un fichier avec le bon nom, il l'inclut avec require_once.
 */
spl_autoload_register(function ($className) {
    $file = str_replace(['App\\', '\\'], ['../src/', '/'], $className) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
