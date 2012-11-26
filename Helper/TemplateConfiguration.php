<?php

namespace Kunstmaan\TemplateBundle\Helper;

/**
 * Template configuration
 *
 * Will be injected with actual template parameters defined in configuration files
 */
class TemplateConfiguration
{
    /**
     * @var array
     */
    private $templates;

    /**
     * @param array $templates
     */
    public function __construct(array $templates = array())
    {
        $this->templates = $templates;
    }

    /**
     * @param string $template
     *
     * @return array
     */
    public function get($template)
    {
        if (empty($this->templates[$template])) {
            new \RuntimeException('Template not defined: ' . $template);
        }

        return $this->templates[$template];
    }

    /**
     * @param string $template
     * @param array $config
     *
     * @return array
     */
    public function set($template, array $config)
    {
        return $this->templates[$template] = $config;
    }
}
