<?php

namespace Fsv\TypographyBundle\Form\EventListener;

use Fsv\TypographyBundle\Typograph\TypographInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TypographyListener implements EventSubscriberInterface
{
    /**
     * @var TypographInterface
     */
    private $typograph;

    /**
     * @param TypographInterface $typograph
     */
    public function __construct(TypographInterface $typograph)
    {
        $this->typograph = $typograph;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT => 'onSubmit'
        ];
    }

    public function onSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if  (!is_string($data)) {
            return;
        }

        $event->setData($this->typograph->apply($data));
    }
}
