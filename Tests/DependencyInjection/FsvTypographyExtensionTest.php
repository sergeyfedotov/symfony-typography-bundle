<?php
namespace Fsv\TypographyBundle\Tests;

use Fsv\TypographyBundle\DependencyInjection\FsvTypographyExtension;
use Fsv\TypographyBundle\FsvTypographyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FsvTypographyExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigureTypograph()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', [
            'typographs' => [
                'default' => [],
                'another_one' => []
            ]
        ]);
        $container->compile();

        $this->assertTrue($container->hasDefinition('fsv_typography.typograph.default'));
        $this->assertTrue($container->hasDefinition('fsv_typography.typograph.another_one'));
        $this->assertTrue(is_subclass_of(
            $container->getDefinition('fsv_typography.typograph.default')->getClass(),
            'Fsv\TypographyBundle\Typograph\TypographInterface'
        ));
        $this->assertTrue(is_subclass_of(
            $container->getDefinition('fsv_typography.typograph.another_one')->getClass(),
            'Fsv\TypographyBundle\Typograph\TypographInterface'
        ));
    }

    public function testDefaultTypograph()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', [
            'typographs' => [
                'non_default' => []
            ]
        ]);
        $container->compile();

        $this->assertTrue($container->hasDefinition('fsv_typography.typograph.non_default'));
        $this->assertTrue($container->hasAlias('fsv_typography.typograph.default'));
        $this->assertTrue($container->hasAlias('fsv_typography.typograph'));
        $this->assertEquals((string)$container->getAlias('fsv_typography.typograph.default'), 'fsv_typography.typograph.non_default');
        $this->assertEquals((string)$container->getAlias('fsv_typography.typograph'), 'fsv_typography.typograph.non_default');
    }

    public function testEnableFormExtension()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', [
            'enable_form_extension' => true,
            'typographs' => ['default' => []]
        ]);
        $container->compile();

        $this->assertTrue($container->hasDefinition('fsv_typography.textarea_type_extension'));
        $this->assertTrue(is_a(
            $container->getDefinition('fsv_typography.textarea_type_extension')->getClass(),
            'Fsv\TypographyBundle\Form\Extension\TextareaTypeExtension',
            true
        ));
    }

    public function testDisableFormExtension()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', [
            'enable_form_extension' => false,
            'typographs' => ['default' => []]
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
