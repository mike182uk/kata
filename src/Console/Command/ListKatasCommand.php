<?php

namespace Mdb\Kata\Console\Command;

use Mdb\Kata\Kata;
use Mdb\Kata\KataRepository;

class ListKatasCommand extends ListFromRepositoryCommand
{
    /**
     * @param KataRepository $kataRepository
     */
    public function __construct(KataRepository $kataRepository)
    {
        parent::__construct($kataRepository);
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

        /** @var Kata $kata */
        foreach ($this->repository->findAll() as $kata) {
            $rows[] = [
                $kata->getKey(),
                $kata->getName(),
            ];
        }

        return $rows;
    }
}
