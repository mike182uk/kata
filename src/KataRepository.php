<?php

namespace Mdb\Kata;

class KataRepository implements Repository
{
    /**
     * @var Kata[]
     */
    private $katas = [];

    /**
     * @param Kata $kata
     */
    public function insert($kata)
    {
        if (!$kata instanceof Kata) {
            throw new \InvalidArgumentException();
        }

        $this->katas[] = $kata;
    }

    /**
     * @return Kata[]
     */
    public function findAll()
    {
        return $this->katas;
    }

    public function clear()
    {
        $this->katas = [];
    }

    /**
     * @param string $key
     *
     * @return Kata
     */
    public function findOneByKey($key)
    {
        foreach ($this->katas as $kata) {
            if ($kata->getKey() == $key) {
                return $kata;
            }
        }
    }

    /**
     * @return Kata
     */
    public function findOneByRandom()
    {
        return $this->katas[array_rand($this->katas)];
    }
}
