<?php

namespace Mdb\Kata\Workspace\Handler;

use Mdb\Kata\Kata;
use Mdb\Kata\KataRepository;
use Mdb\Kata\Workspace\Command\ValidateKataCommand;

class ValidateKataHandler
{
    /**
     * @var KataRepository
     */
    private $kataRepository;

    /**
     * @param KataRepository $kataRepository
     */
    public function __construct(KataRepository $kataRepository)
    {
        $this->kataRepository = $kataRepository;
    }

    /**
     * @param ValidateKataCommand $command
     *
     * @throws \InvalidArgumentException
     */
    public function handle(ValidateKataCommand $command)
    {
        $kataKey = $command->getKata();
        $kata = $this->kataRepository->findOneByKey($kataKey);

        if (!$kata instanceof Kata) {
            throw new \InvalidArgumentException(
                sprintf('The kata "%s" is not a valid kata. Please specify a valid kata.', $kataKey)
            );
        }
    }
}
