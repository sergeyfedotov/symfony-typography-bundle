<?php

namespace Fsv\TypographyBundle\DependencyInjection\Typographer\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class MdashTypographerFactory implements TypographerFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('fsv_typography.typographer.mdash'))
            ->replaceArgument(0, $config['options'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'mdash';
    }

    /**
     * {@inheritdoc}
     */
    public function buildConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('options')
                    ->prototype('variable')->end()
                ->end()
            ->end()
        ;
    }
}
