<?php
namespace Fsv\TypographyBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class FsvTypographyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->createTypographs($config['typographs'], $container);

        if (!$config['enable_form_extension']) {
            $container->removeDefinition('fsv_typography.textarea_type_extension');
        }
    }

    private function createTypographs($typographs, ContainerBuilder $container)
    {
        $map = array();
        foreach ($typographs as $name => $options) {
            $map[$name] = $this->createTypograph($name, $options, $container);
        }

        if ($map && !isset($map['default'])) {
            $map['default'] = reset($map);
            $container->setAlias('fsv_typography.typograph.default', (string)$map['default']);
        }

        $container->setAlias('fsv_typography.typograph', 'fsv_typography.typograph.default');

        $definition = $container->getDefinition('fsv_typography.typograph_map');
        $definition->replaceArgument(0, $map);
    }

    private function createTypograph($name, $options, ContainerBuilder $container)
    {
        $definition = new Definition('%fsv_typography.typograph.class%');
        $definition
            ->setLazy(true)
            ->addArgument($options)
        ;

        $id = sprintf('fsv_typography.typograph.%s', $name);
        $container->setDefinition($id, $definition);

        return new Reference($id);
    }
}
