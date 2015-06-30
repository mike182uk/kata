<?php

namespace Mdb\Kata\Console\Command;

use Mdb\Kata\Language;
use Mdb\Kata\LanguageRepository;

class ListLanguagesCommand extends ListFromRepositoryCommand
{
    /**
     * @param LanguageRepository $languageRepository
     */
    public function __construct(LanguageRepository $languageRepository)
    {
        parent::__construct($languageRepository);
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('list:languages')
            ->setDescription('List the available languages')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getTableHeaders()
    {
        return ['Key', 'Name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getTableRows()
    {
        $rows = [];

        /** @var Language $language */
        foreach ($this->repository->findAll() as $language) {
            $rows[] = [
                $language->getKey(),
                $language->getName(),
            ];
        }

        return $rows;
    }
}
