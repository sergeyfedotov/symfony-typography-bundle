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
        $container->loadFromExtension('fsv_typography', array(
            'typographs' => array(
                'default' => array(),
                'another_one' => array()
            )
        ));
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

    public function testEnableFormExtension()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', array(
            'enable_form_extension' => true
        ));
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
        $container->loadFromExtension('fsv_typography', array(
            'enable_form_extension' => false
        ));
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
