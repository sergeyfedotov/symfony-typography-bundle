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
        $form = $this->factory->create(self::$textareaType);
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

        $typographMap = $this->getMock('Fsv\TypographyBundle\Typograph\TypographMapInterface');
        $typographMap
            ->expects($this->any())
            ->method('getTypograph')
            ->with('default')
            ->will($this->returnCallback(function () use ($typograph) {
                return $typograph;
            }))
        ;

        return array(
            new PreloadedExtension(
                array(),
                array(
                    self::$textareaType => array(new TextareaTypeExtension($typographMap))
                )
            )
        );
    }
}
