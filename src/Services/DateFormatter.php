<?php

namespace App\Services;

use DateTime;
use IntlDateFormatter;

class DateFormatter
{
    private ?string $locale;

    public function __construct(?string $locale = DATE_FORMATTER_LOCALE)
    {
        $this->locale = $locale;
    }

    /**
     * Convertit une date vers le format de type "Samedi 15 juillet 2023" en francais.
     * @return string : la date convertie.
     */
    public function format(DateTime $dateTime): string
    {

        // Attention, s'il y a un soucis lié à IntlDateFormatter c'est qu'il faut
        // activer l'extention intl_date_formater (ou intl) au niveau du serveur apache. 
        // Ca peut se faire depuis php.ini ou parfois directement depuis votre utilitaire (wamp/mamp/xamp)
        $dateFormatter = new IntlDateFormatter($this->locale, IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $dateFormatter->setPattern('EEEE d MMMM Y');
        return $dateFormatter->format($dateTime);
    }
}
