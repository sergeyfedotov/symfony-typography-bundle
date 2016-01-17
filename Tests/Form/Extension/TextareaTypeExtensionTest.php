<?php
namespace Fsv\TypographyBundle\Tests\Form\Extension;

use Fsv\TypographyBundle\Form\Extension\TextareaTypeExtension;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class TextareaTypeExtensionTest extends TypeTestCase
{
    public function testSubmitWithTypography()
    {
        $form = $this->factory->create('textarea', null, array(
            'typography' => true
        ));
        $form->submit('Типограф - это здорово!');

        $this->assertEquals('Типограф&nbsp;&mdash; это здорово!', $form->getData());
    }

    public function testSubmitWithoutTypography()
    {
        $form = $this->factory->create('textarea');
        $form->submit('Типограф - это здорово!');

        $this->assertEquals('Типограф - это здорово!', $form->getData());
    }

    protected function getExtensions()
    {
        $typograph = $this->getMock('Fsv\TypographyBundle\Typograph\TypographInterface');
        $typograph
            ->expects($this->any())
            ->method('apply')
            ->with('Типограф - это здорово!')
            ->will($this->returnValue('Типограф&nbsp;&mdash; это здорово!'))
        ;

        return array(
            new PreloadedExtension(
                array(),
                array(
                    'textarea' => array(new TextareaTypeExtension($typograph))
                )
            )
        );
    }
}
