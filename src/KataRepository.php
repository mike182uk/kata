<?php

namespace Mdb\Kata;

class KataRepository
{
    /**
     * @var Kata[]
     */
    private $katas;

    /**
     * @param Kata $kata
     */
    public function insert(Kata $kata)
    {
        $this->katas[] = $kata;
    }

    /**
     * @return Kata[]
     */
    public function findAll()
    {
        return $this->katas;
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

    public function clear()
    {
        $this->katas = [];
    }
}
