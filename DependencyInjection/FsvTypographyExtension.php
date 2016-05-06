<?php

namespace Fsv\TypographyBundle\DependencyInjection;

use Fsv\TypographyBundle\DependencyInjection\Typographer\Factory\TypographerFactoryInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class FsvTypographyExtension extends Extension
{
    /**
     * @var TypographerFactoryInterface[]
     */
    private $typographerFactories = [];

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration($this->typographerFactories);
        $config = $this->processConfiguration($configuration, $configs);

        $this->createTypographers($config['typographers'], $container);

        if (!$config['enable_form_extension']) {
            $container->removeDefinition('fsv_typography.textarea_type_extension');
        }
    }

    private function createTypographers($typographers, ContainerBuilder $container)
    {
        $typographerMap = array();
        foreach ($typographers as $name => $config) {
            $typographerMap[$name] = $this->createTypographer($name, $config, $container);
        }

        if ($typographerMap && !isset($typographerMap['default'])) {
            $typographerMap['default'] = reset($typographerMap);
            $container->setAlias('fsv_typography.typographer_map.default', (string)$typographerMap['default']);
        }

        $definition = $container->getDefinition('fsv_typography.typographer_map');
        $definition->replaceArgument(0, $typographerMap);
    }

    private function createTypographer($name, $typographer, ContainerBuilder $container)
    {
        $id = 'fsv_typography.typographer_map.'.$name;

        foreach ($this->typographerFactories as $key => $factory) {
            if (isset($typographer[$key])) {
                $factory->create($container, $id, $typographer[$key]);
                $container->getDefinition($id)->setLazy(true);

                return new Reference($id);
            }
        }

        if (isset($typographer['id'])) {
            $container->setAlias($id, $typographer['id']);

            return new Reference($typographer['id']);
        }

        throw new InvalidConfigurationException(sprintf('Unable to create definition for "%s" typographer', $name));
    }
    
    public function addTypographerFactory(TypographerFactoryInterface $factory)
    {
        $this->typographerFactories[$factory->getKey()] = $factory;
    }
}
