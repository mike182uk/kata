<?php

namespace Mdb\Kata\Console\Command;

use Mdb\Kata\Repository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class ListFromRepositoryCommand extends Command
{
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);

        $table
            ->setHeaders($this->getTableHeaders())
            ->setRows($this->getTableRows())
        ;

        $table->render();
    }

    /**
     * @return array
     */
    abstract public function getTableHeaders();

    /**
     * @return array
     */
    abstract public function getTableRows();
}
