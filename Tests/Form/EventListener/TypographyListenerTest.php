<?php

namespace Fsv\TypographyBundle\Tests\Form\EventListener;

use Fsv\TypographyBundle\Form\EventListener\TypographyListener;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Test\TypeTestCase;

class TypographyListenerTest extends TypeTestCase
{
    public function testTypographyOnSubmit()
    {
        $input = 'Типограф - это здорово!';
        $output = 'Типограф&nbsp;&mdash; это здорово!';

        $typograph = $this->getMock('Fsv\TypographyBundle\Typograph\TypographInterface');
        $typograph
            ->expects($this->once())
            ->method('apply')
            ->with($input)
            ->will($this->returnValue($output))
        ;

        $form = $this->getMock('Symfony\Component\Form\Test\FormInterface');
        $event = new FormEvent($form, $input);

        $listener = new TypographyListener($typograph);
        $listener->onSubmit($event);

        $this->assertEquals($output, $event->getData());
    }
}
