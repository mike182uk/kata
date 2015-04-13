<?php

namespace Mdb\Kata;

class TemplateRepository
{
    /**
     * @var Template[]
     */
    private $templates;

    /**
     * @param Template $template
     */
    public function insert(Template $template)
    {
        $this->templates[] = $template;
    }

    /**
     * @return Template[]
     */
    public function findAll()
    {
        return $this->templates;
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

    public function clear()
    {
        $this->templates = [];
    }
}
