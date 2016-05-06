<?php

namespace Fsv\TypographyBundle\Tests\DependencyInjection;

use Fsv\TypographyBundle\DependencyInjection\Configuration;
use Fsv\TypographyBundle\DependencyInjection\Typographer\Factory\MdashTypographerFactory;
use Fsv\TypographyBundle\DependencyInjection\Typographer\Factory\SmartypantsTypographerFactory;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadTypographerConfigurations()
    {
        $configs = [
            [
                'typographers' => [
                    'default' => [
                        'mdash' => [
                            'options' => [
                                'option1' => 'value1',
                                'option2' => 'value2'
                            ]
                        ]
                    ],
                    'another_one' => [
                        'smartypants' => [
                            'attr' => 1
                        ]
                    ],
                    'by_service' => [
                        'id' => 'service_id'
                    ]
                ]
            ]
        ];

        $typographerFactories = [
            new MdashTypographerFactory(),
            new SmartypantsTypographerFactory()
        ];
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration($typographerFactories), $configs);

        $this->assertArrayHasKey('typographers', $config);
        $this->assertEquals($configs[0]['typographers'], $config['typographers']);
    }
}
