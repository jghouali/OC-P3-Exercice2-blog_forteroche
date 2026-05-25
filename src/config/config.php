<?php

// En fonction des routes utilisées, il est possible d'avoir besoin de la session ; on la démarre dans tous les cas. 
session_start();

// Ici on met les constantes utiles, 
// les données de connexions à la bdd
// et tout ce qui sert à configurer. 

define('TEMPLATE_VIEW_PATH', '../Templates/'); // Le chemin vers les templates de vues.
define('DATE_FORMATTER_LOCALE', 'fr_FR');
define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php'); // Le chemin vers le template principal.

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'blog_forteroche');
define('DB_USER', 'blog_forteroche');
define('DB_PASS', 'blog_forteroche');
