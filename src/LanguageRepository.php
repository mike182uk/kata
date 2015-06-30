<?php

namespace Mdb\Kata;

class LanguageRepository implements Repository
{
    /**
     * @var Language[]
     */
    private $languages;

    /**
     * @param Language $language
     */
    public function insert($language)
    {
        if (!$language instanceof Language) {
            throw new \InvalidArgumentException();
        }

        $this->languages[] = $language;
    }

    /**
     * @return Language[]
     */
    public function findAll()
    {
        return $this->languages;
    }

    public function clear()
    {
        $this->languages = [];
    }

    /**
     * @param string $key
     *
     * @return Language
     */
    public function findOneByKey($key)
    {
        foreach ($this->languages as $language) {
            if ($language->getKey() == $key) {
                return $language;
            }
        }
    }

    /**
     * @return Kata
     */
    public function findOneByRandom()
    {
        return $this->languages[array_rand($this->languages)];
    }
}
