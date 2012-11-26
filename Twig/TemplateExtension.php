<?php

namespace Kunstmaan\TemplateBundle\Twig;

use Kunstmaan\TemplateBundle\Helper\TemplateConfiguration;

/**
 * Extension to render templates
 */
class TemplateExtension extends \Twig_Extension
{

    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @var TemplateConfiguration
     */
    protected $config;

    /**
     * Initializes the runtime environment.
     *
     * This is where you can load some file that contains filter functions for instance.
     *
     * @param \Twig_Environment $environment The current Twig_Environment instance
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function setTemplateConfiguration(TemplateConfiguration $config)
    {
        $this->config = $config;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'template_widget'  => new \Twig_Function_Method($this, 'renderTemplate', array('is_safe' => array('html')))
        );
    }

    /**
     * @param string  $template The template
     * @param array   $options  The extra options
     * @param string  $template The template
     *
     * @return string
     */
    public function renderTemplate($template, $options = array(), $twig = "KunstmaanTemplateBundle:TemplateExtension:template_widget.html.twig")
    {
        $twig = $this->environment->loadTemplate($twig);
        $template = $this->config->get($template);

        return $twig->render(array_merge($options, array(
            'regions'   => $template['regions'],
            'layout'    => $template['layout']
        )));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'template_twig_extension';
    }

}
