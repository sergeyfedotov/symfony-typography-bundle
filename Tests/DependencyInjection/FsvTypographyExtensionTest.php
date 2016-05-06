<?php

namespace Fsv\TypographyBundle\Tests;

use Fsv\TypographyBundle\DependencyInjection\FsvTypographyExtension;
use Fsv\TypographyBundle\FsvTypographyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FsvTypographyExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigureTypographer()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', [
            'typographers' => [
                'default' => [
                    'mdash' => []
                ],
                'another_one' => [
                    'smartypants' => []
                ]
            ]
        ]);
        $container->compile();

        $this->assertTrue($container->hasDefinition('fsv_typography.typographer_map.default'));
        $this->assertTrue($container->hasDefinition('fsv_typography.typographer_map.another_one'));
        $this->assertEquals(
            'Fsv\TypographyBundle\Typographer\MdashTypographer',
            $container->getDefinition('fsv_typography.typographer_map.default')->getClass()
        );
        $this->assertEquals(
            'Fsv\TypographyBundle\Typographer\SmartypantsTypographer',
            $container->getDefinition('fsv_typography.typographer_map.another_one')->getClass()
        );
    }

    public function testDefaultTypographer()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', [
            'typographers' => [
                'non_default' => [
                    'mdash' => []
                ]
            ]
        ]);
        $container->compile();

        $this->assertTrue($container->hasDefinition('fsv_typography.typographer_map.non_default'));
        $this->assertTrue($container->hasAlias('fsv_typography.typographer_map.default'));
        $this->assertEquals(
            (string)$container->getAlias('fsv_typography.typographer_map.default'),
            'fsv_typography.typographer_map.non_default'
        );
    }

    public function testEnableFormExtension()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', [
            'enable_form_extension' => true,
            'typographers' => [
                'default' => [
                    'mdash' => []
                ]
            ]
        ]);
        $container->compile();

        $this->assertTrue($container->hasDefinition('fsv_typography.textarea_type_extension'));
        $this->assertEquals(
            $container->getDefinition('fsv_typography.textarea_type_extension')->getClass(),
            'Fsv\TypographyBundle\Form\Extension\TextareaTypeExtension'
        );
    }

    public function testDisableFormExtension()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', [
            'enable_form_extension' => false,
            'typographers' => [
                'default' => [
                    'mdash' => []
                ]
            ]
        ]);
        $container->compile();

        $this->assertFalse($container->hasDefinition('fsv_typography.textarea_type_extension'));
    }

    private function getRawContainer()
    {
        $container = new ContainerBuilder();
        $extension = new FsvTypographyExtension();
        $container->registerExtension($extension);

        $bundle = new FsvTypographyBundle();
        $bundle->build($container);

        return $container;
    }
}
