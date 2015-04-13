<?php

namespace Mdb\Kata;

class LanguageRepository
{
    /**
     * @var Language[]
     */
    private $languages;

    /**
     * @param Language $language
     */
    public function insert(Language $language)
    {
        $this->languages[] = $language;
    }

    /**
     * @return Language[]
     */
    public function findAll()
    {
        return $this->languages;
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

    public function clear()
    {
        $this->languages = [];
    }
}
