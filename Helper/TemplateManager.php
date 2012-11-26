<?php

namespace Kunstmaan\TemplateBundle\Helper;

class TemplateManager
{
    protected $templates;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->templates = array();
    }

    /**
     * Add a template
     *
     * @param Template $template
     *
     * @return TemplateManager
     */
    public function addTemplate(Template $template)
    {
        $this->templates[$template->getId()] = $template;

        return $this;
    }

    /**
     * Get a template by alias
     *
     * @param $alias string
     *
     * @return null|Template
     */
    public function get($alias)
    {
        return isset($this->templates[$alias]) ? $this->templates[$alias] : null;
    }

    /**
     * Check if a template exists (by alias)
     *
     * @param $alias
     *
     * @return boolean
     */
    public function has($alias)
    {
        return isset($this->templates[$alias]);
    }
}