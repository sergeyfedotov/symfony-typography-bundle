<?php
namespace Fsv\TypographyBundle\Tests\Form\Extension;

use Fsv\TypographyBundle\Form\DataTransformer\TypographyTransformer;
use Symfony\Component\Form\Test\TypeTestCase;

class TypographyTransformerTest extends TypeTestCase
{
    public function testTransformationDuringReverseTransform()
    {
        $input = 'Типограф - это здорово!';
        $output = 'Типограф&nbsp;&mdash; это здорово!';

        $typograph = $this->getMock('Fsv\TypographyBundle\Typograph\TypographInterface');
        $typograph
            ->expects($this->any())
            ->method('apply')
            ->with($input)
            ->will($this->returnValue($output))
        ;

        $typographyTransformer = new TypographyTransformer($typograph);

        $this->assertEquals($output, $typographyTransformer->reverseTransform($input));
        $this->assertEquals($input, $typographyTransformer->transform($input));
    }
}
