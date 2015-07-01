<?php

namespace Mdb\Kata\CommandBus;

use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;

class ClassNameWithoutSuffixExtractor implements CommandNameExtractor
{
    /**
     * @var string
     */
    private $suffix;

    /**
     * @param string $suffix
     */
    public function __construct($suffix)
    {
        $this->suffix = $suffix;
    }

    /**
     * {@inheritdoc}
     */
    public function extract($command)
    {
        $fqcn = get_class($command);
        $fqcnParts = explode('\\', $fqcn);

        return preg_replace(
            sprintf('/%s/', $this->suffix),
            '',
            array_pop($fqcnParts)
        );
    }
}
