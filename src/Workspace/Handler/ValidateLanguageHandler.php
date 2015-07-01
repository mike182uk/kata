<?php

namespace Mdb\Kata\Workspace\Handler;

use Mdb\Kata\Language;
use Mdb\Kata\LanguageRepository;
use Mdb\Kata\Workspace\Command\ValidateLanguageCommand;

class ValidateLanguageHandler
{
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @param LanguageRepository $languageRepository
     */
    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param ValidateLanguageCommand $command
     *
     * @throws \InvalidArgumentException
     */
    public function handle(ValidateLanguageCommand $command)
    {
        $languageKey = $command->getLanguage();
        $language = $this->languageRepository->findOneByKey($languageKey);

        if (!$language instanceof Language) {
            throw new \InvalidArgumentException(
                sprintf('The language "%s" is not a valid language. Please specify a valid language.', $languageKey)
            );
        }
    }
}
