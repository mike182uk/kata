<?php

namespace Mdb\Kata;

interface Repository
{
    /**
     * @return array
     */
    public function findAll();

    /**
     * @param mixed $entity
     */
    public function insert($entity);

    public function clear();
}
