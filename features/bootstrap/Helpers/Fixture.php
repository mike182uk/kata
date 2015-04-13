<?php

namespace Helpers;

use Mdb\Kata\KataRepository;
use Mdb\Kata\LanguageRepository;
use Mdb\Kata\TemplateRepository;

class Fixture
{
    /**
     * @var KataRepository
     */
    private static $kataRepository;

    /**
     * @var LanguageRepository
     */
    private static $languageRepository;

    /**
     * @var TemplateRepository
     */
    private static $templateRepository;

    /**
     * @return KataRepository
     */
    public static function getKataRepository()
    {
        if (!self::$kataRepository instanceof KataRepository) {
            self::$kataRepository = new KataRepository();
        }

        return self::$kataRepository;
    }

    /**
     * @return LanguageRepository
     */
    public static function getLanguageRepository()
    {
        if (!self::$languageRepository instanceof LanguageRepository) {
            self::$languageRepository = new LanguageRepository();
        }

        return self::$languageRepository;
    }

    /**
     * @return TemplateRepository
     */
    public static function getTemplateRepository()
    {
        if (!self::$templateRepository instanceof TemplateRepository) {
            self::$templateRepository = new TemplateRepository();
        }

        return self::$templateRepository;
    }
}
