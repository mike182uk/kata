<?php

namespace Mdb\Kata\Console\Command;

use Mdb\Kata\Language;
use Mdb\Kata\LanguageRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListLanguagesCommand extends Command
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

        parent::__construct();
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
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rows = [];

        /** @var Language $language */
        foreach ($this->languageRepository->findAll() as $language) {
            $rows[] = [
                $language->getKey(),
                $language->getName(),
            ];
        }

        $table = new Table($output);

        $table->setHeaders(['Key', 'Name'])
              ->setRows($rows);

        $table->render();
    }
}
