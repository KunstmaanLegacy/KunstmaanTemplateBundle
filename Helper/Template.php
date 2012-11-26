<?php

namespace Kunstmaan\TemplateBundle\Helper;

class Template
{
    protected $id;
    protected $name;
    protected $regions;
    protected $layout;
    protected $pages;

    public function __construct($template, array $config)
    {
        $this->id = $template;
        $this->name = $config['name'];
        $this->regions = $config['regions'];
        $this->layout = $config['layout'];
        $this->pages = $config['pages'];
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function getLayout()
    {
        return $this->layout;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPages($pages)
    {
        $this->pages = $pages;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function setRegions($regions)
    {
        $this->regions = $regions;
    }

    public function getRegions()
    {
        return $this->regions;
    }
}
