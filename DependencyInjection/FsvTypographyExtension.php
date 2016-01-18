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

        $container->setParameter('fsv_typography.typograph.options', $config['typograph_options']);

        if ($config['enable_form_extension']) {
            $extensionDefinition = new Definition('%fsv_typography.textarea_type_extension.class%');
            $extensionDefinition
                ->addArgument(new Reference('fsv_typography.typograph'))
                ->addTag('form.type_extension', array(
                    'extended_type' => 'Symfony\Component\Form\Extension\Core\Type\TextareaType',
                    'alias' => 'textarea'
                ))
            ;

            $container->setDefinition('fsv_typography.textarea_type_extension', $extensionDefinition);
        }
    }
}
