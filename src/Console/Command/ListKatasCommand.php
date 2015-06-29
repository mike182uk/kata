<?php

namespace Mdb\Kata\Console\Command;

use Mdb\Kata\Kata;
use Mdb\Kata\KataRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListKatasCommand extends Command
{
    /**
     * @var KataRepository
     */
    private $kataRepository;

    /**
     * @param KataRepository $languageRepository
     */
    public function __construct(KataRepository $languageRepository)
    {
        $this->kataRepository = $languageRepository;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('list:katas')
            ->setDescription('List the available katas')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rows = [];

        /** @var Kata $kata */
        foreach ($this->kataRepository->findAll() as $kata) {
            $rows[] = [
                $kata->getKey(),
                $kata->getName(),
                $kata->getSummary(),
            ];
        }

        $table = new Table($output);

        $table->setHeaders(['Key', 'Name', 'Summary'])
              ->setRows($rows);

        $table->render();
    }
}
