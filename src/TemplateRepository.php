<?php

namespace Mdb\Kata;

class TemplateRepository implements Repository
{
    /**
     * @var Template[]
     */
    private $templates = [];

    /**
     * @param Template $template
     */
    public function insert($template)
    {
        if (!$template instanceof Template) {
            throw new \InvalidArgumentException();
        }

        $this->templates[] = $template;
    }

    /**
     * @return Template[]
     */
    public function findAll()
    {
        return $this->templates;
    }

    public function clear()
    {
        $this->templates = [];
    }

    /**
     * @param string $language
     *
     * @return Template[]
     */
    public function findAllByLanguage($language)
    {
        return array_filter($this->templates, function (Template $template) use ($language) {
            return $template->getLanguage() == $language;
        });
    }
}
