<?php

namespace Kunstmaan\TemplateBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class KunstmaanTemplateExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (isset($config['templates'])) {
            $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
            $loader->load('services.yml');

            foreach ($config['templates'] as $template => $templateConfig) {
                $this->loadTemplate($template, $templateConfig, $container);
            }
        }
        $container->setParameter('kunstmaan_template.templates', $config['templates']);
    }

    protected function loadTemplate($template, array $config, ContainerBuilder $container)
    {
        // Extra sanity checks
        $regions = $config['regions'];
        // Check that layout doesn't contain unknown regions
        $layoutRegions = $this->arrayValueRecursive('region', $config['layout']);
        foreach ($layoutRegions as $layoutRegion) {
            if (!in_array($layoutRegion, $regions)) {
                throw new \InvalidArgumentException(sprintf('Unknown region "%s" used in layout of template "%s".', $layoutRegion, $template));
            }
        }
        // Check that page limitations don't contain unknown regions
        $pages = $config['pages'];
        foreach ($pages as $pageClass => $regionDefs) {
            $pageRegions = array_keys($regionDefs);
            // Check if page class actually exists
            if (!class_exists($pageClass)) {
                throw new \InvalidArgumentException(sprintf('Unknown page class "%s" used in template "%s".', $pageClass, $template));
            }
            foreach ($pageRegions as $pageRegion) {
                if (!in_array($pageRegion, $regions)) {
                    throw new \InvalidArgumentException(sprintf('Unknown region "%s" used on page "%s" of template "%s".', $pageRegion, $pageClass, $template));
                }
            }
        }

    }

    private function arrayValueRecursive($key, array $arr)
    {
        $val = array();
        array_walk_recursive($arr, function ($v, $k) use ($key, &$val) {
            if ($k == $key) array_push($val, $v);
        });

        return count($val) > 1 ? $val : array_pop($val);
    }
}