<?php

namespace Fsv\TypographyBundle;

use Fsv\TypographyBundle\DependencyInjection\FsvTypographyExtension;
use Fsv\TypographyBundle\DependencyInjection\Typographer\Factory\MdashTypographerFactory;
use Fsv\TypographyBundle\DependencyInjection\Typographer\Factory\SmartypantsTypographerFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FsvTypographyBundle extends Bundle
{
    public function build(ContainerBuilder $builder)
    {
        parent::build($builder);

        $this->createTypographerFactories($builder);
    }

    private function createTypographerFactories(ContainerBuilder $builder)
    {
        /** @var FsvTypographyExtension $extension */
        $extension = $builder->getExtension('fsv_typography');
        $extension->addTypographerFactory(new MdashTypographerFactory());
        $extension->addTypographerFactory(new SmartypantsTypographerFactory());
    }
}
