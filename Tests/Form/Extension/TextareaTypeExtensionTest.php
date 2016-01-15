<?php
namespace Fsv\TypographyBundle\Tests\Form\Extension;

use Fsv\TypographyBundle\Form\Extension\TextareaTypeExtension;
use Fsv\TypographyBundle\Typograph\MdashTypograph;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class TextareaTypeExtensionTest extends TypeTestCase
{
    public function testSubmitWithTypography()
    {
        $form = $this->factory->create('Symfony\Component\Form\Extension\Core\Type\TextareaType', null, array(
            'typography' => true
        ));
        $form->submit('Типограф - это здорово!');

        $this->assertEquals('Типограф&nbsp;&mdash; это здорово!', $form->getData());
    }

    public function testSubmitWithoutTypography()
    {
        $form = $this->factory->create('Symfony\Component\Form\Extension\Core\Type\TextareaType', null);
        $form->submit('Типограф - это здорово!');

        $this->assertEquals('Типограф - это здорово!', $form->getData());
    }

    protected function getExtensions()
    {
        return array(
            new PreloadedExtension(
                array(),
                array(
                    'Symfony\Component\Form\Extension\Core\Type\TextareaType' => array(
                        new TextareaTypeExtension(new MdashTypograph(array('Text.paragraphs' => 'off')))
                    )
                )
            )
        );
    }
}
