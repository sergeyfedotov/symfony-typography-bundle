<?php
namespace Fsv\TypographyBundle\Tests;

use Fsv\TypographyBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadMultipleTypographConfigurations()
    {
        $configs = array(
            array(
                'typographs' => array(
                    'default' => array(
                        'option1' => 'value1',
                        'option2' => 'value2'
                    ),
                    'another_one' => array(
                        'option3' => 'value3',
                        'option4' => 'value4'
                    )
                )
            )
        );

        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $this->assertArrayHasKey('typographs', $config);
        $this->assertEquals($configs[0]['typographs'], $config['typographs']);
    }
}
