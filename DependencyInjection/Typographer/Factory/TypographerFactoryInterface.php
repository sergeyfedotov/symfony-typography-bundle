<?php

namespace Fsv\TypographyBundle\DependencyInjection\Typographer\Factory;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface TypographerFactoryInterface
{
    /**
     * @param ContainerBuilder $container
     * @param string $id
     * @param array $config
     */
    public function create(ContainerBuilder $container, $id, array $config);

    /**
     * @return string
     */
    public function getKey();

    /**
     * @param NodeDefinition $node
     */
    public function buildConfiguration(NodeDefinition $node);
}
