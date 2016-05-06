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

        $typographer = $this->getMock('Fsv\TypographyBundle\Typographer\TypographerInterface');
        $typographer
            ->expects($this->once())
            ->method('typography')
            ->with($input)
            ->will($this->returnValue($output))
        ;

        $form = $this->getMock('Symfony\Component\Form\Test\FormInterface');
        $event = new FormEvent($form, $input);

        $listener = new TypographyListener($typographer);
        $listener->onSubmit($event);

        $this->assertEquals($output, $event->getData());
    }
}
