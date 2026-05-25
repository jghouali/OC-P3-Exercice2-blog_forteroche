<?php

namespace App\Services;

class ContentFormatter
{

    /**
     * Cette méthode protège une chaine de caractères contre les attaques XSS.
     * @param string $string : la chaine à protéger.
     * @return string : la chaine protégée.
     */
    public function sanitize(string $string): string
    {
        // Etape 1, on protège le texte avec htmlspecialchars.
        //$finalString = htmlspecialchars($string, ENT_QUOTES);
        $finalString = trim(strip_tags($string));

        return $finalString;
    }

    /**
     * Cette méthode  transforme les retours à la ligne en balises <p> pour un affichage plus agréable. 
     * @param string $string : la chaine à paragraphiser.
     * @return string : la chaine paragraphisée.
     */
    public function paragraphize(string $string): string
    {
        // le texte va être découpé par rapport aux retours à la ligne, 
        $lines = explode("\n", $string);

        // On reconstruit en mettant chaque ligne dans un paragraphe (et en sautant les lignes vides).
        $finalString = "";
        foreach ($lines as $line) {
            if (trim($line) != "") {
                $finalString .= "<p>$line</p>";
            }
        }

        return $finalString;
    }

    /**
     * Affiche les $length premiers caractères du contenu.
     * @param int $length : le nombre de caractères à retourner.
     * Si $length n'est pas défini (ou vaut -1), on retourne tout le contenu.
     * Si le contenu est plus grand que $length, on retourne les $length premiers caractères avec "..." à la fin.
     * @return string
     */
    public function format(string $content, ?int $length = -1): string
    {
        if ($length > 0) {
            // Ici, on utilise mb_substr et pas substr pour éviter de couper un caractère en deux (caractère multibyte comme les accents).
            $content = mb_substr($content, 0, $length);
            if (strlen($content) > $length) {
                $content .= "...";
            }
        }

        return $this->paragraphize($this->sanitize($content));
    }
}
