<?php

namespace Fsv\TypographyBundle\DependencyInjection;

use Fsv\TypographyBundle\DependencyInjection\Typographer\Factory\TypographerFactoryInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @var TypographerFactoryInterface[]
     */
    private $typographerFactories = [];

    public function __construct(array $typographerFactories)
    {
        $this->typographerFactories = $typographerFactories;
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('fsv_typography');
        $rootNode
            ->children()
                ->booleanNode('enable_form_extension')->defaultTrue()->end()
            ->end()
        ;

        $typographersNodeBuilder = $rootNode
            ->children()
                ->arrayNode('typographers')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
        ;
        $typographersNodeBuilder
            ->children()
                ->scalarNode('id')->end()
            ->end()
        ;

        foreach ($this->typographerFactories as $factory) {
            $typographerFactoryNode = $typographersNodeBuilder
                ->children()
                    ->arrayNode($factory->getKey())
                        ->canBeUnset()
            ;
            $factory->buildConfiguration($typographerFactoryNode);
        }

        return $treeBuilder;
    }
}
