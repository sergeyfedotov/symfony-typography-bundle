<?php

namespace Fsv\TypographyBundle\DependencyInjection\Typographer\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;

class SmartypantsTypographerFactory implements TypographerFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        $container
            ->setDefinition($id, new DefinitionDecorator('fsv_typography.typographer.smartypants'))
            ->replaceArgument(0, $config['attr'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'smartypants';
    }

    /**
     * {@inheritdoc}
     */
    public function buildConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('attr')->defaultValue(1)->end()
            ->end()
        ;
    }
}
