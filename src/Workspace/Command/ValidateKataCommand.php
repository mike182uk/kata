<?php

namespace Mdb\Kata\Workspace\Command;

class ValidateKataCommand
{
    /**
     * @var string
     */
    private $kata;

    /**
     * @param string $kata
     */
    public function __construct($kata)
    {
        $this->kata = $kata;
    }

    /**
     * @return string
     */
    public function getKata()
    {
        return $this->kata;
    }
}
