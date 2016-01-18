<?php
namespace Fsv\TypographyBundle\Tests;

use Fsv\TypographyBundle\DependencyInjection\FsvTypographyExtension;
use Fsv\TypographyBundle\FsvTypographyBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FsvTypographyExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testEnableFormExtension()
    {
        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', array(
            'enable_form_extension' => true
        ));
        $container->compile();

        $this->assertTrue($container->hasDefinition('fsv_typography.textarea_type_extension'));
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

    public function testLoadTypographOptions()
    {
        $options = array(
            'option1' => 'value1',
            'option2' => 'value2'
        );

        $container = $this->getRawContainer();
        $container->loadFromExtension('fsv_typography', array(
            'typograph_options' => $options
        ));
        $container->compile();

        $this->assertEquals($options, $container->getParameter('fsv_typography.typograph.options'));
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
