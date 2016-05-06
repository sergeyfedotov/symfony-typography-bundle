<?php

namespace Fsv\TypographyBundle\Tests\Form\Extension;

use Fsv\TypographyBundle\Form\Extension\TextareaTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class TextareaTypeExtensionTest extends TypeTestCase
{
    private static $textareaType;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::$textareaType = method_exists(FormTypeInterface::class, 'getBlockPrefix')
            ? TextareaType::class
            : 'textarea'
            ;
    }

    public function testSubmitWithTypography()
    {
        $form = $this->factory->create(self::$textareaType, null, array(
            'typography' => 'default'
        ));
        $form->submit('Типограф - это здорово!');

        $this->assertEquals('Типограф&nbsp;&mdash; это здорово!', $form->getData());
    }

    public function testSubmitWithoutTypography()
    {
        $form = $this->factory->create(self::$textareaType, null, [
            'typography' => false
        ]);
        $form->submit('Типограф - это здорово!');

        $this->assertEquals('Типограф - это здорово!', $form->getData());
    }

    public function testSubmitWithoutTypographyByDefault()
    {
        $form = $this->factory->create(self::$textareaType);
        $form->submit('Типограф - это здорово!');

        $this->assertEquals('Типограф - это здорово!', $form->getData());
    }

    public function testSubmitWithDefaultTypographer()
    {
        $form = $this->factory->create(self::$textareaType, null, array(
            'typography' => true
        ));
        $form->submit('Типограф - это здорово!');

        $this->assertEquals('Типограф&nbsp;&mdash; это здорово!', $form->getData());
    }

    protected function getExtensions()
    {
        $typographer = $this->getMock('Fsv\TypographyBundle\Typographer\TypographerInterface');
        $typographer
            ->expects($this->any())
            ->method('typography')
            ->with('Типограф - это здорово!')
            ->will($this->returnValue('Типограф&nbsp;&mdash; это здорово!'))
        ;

        $typographerMap = $this->getMock('Fsv\TypographyBundle\Typographer\TypographerMapInterface');
        $typographerMap
            ->expects($this->any())
            ->method('getTypographer')
            ->with('default')
            ->will($this->returnCallback(function () use ($typographer) {
                return $typographer;
            }))
        ;

        return array(
            new PreloadedExtension(
                array(),
                array(
                    self::$textareaType => array(new TextareaTypeExtension($typographerMap))
                )
            )
        );
    }
}
