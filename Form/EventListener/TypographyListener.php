<?php

namespace Fsv\TypographyBundle\Form\EventListener;

use Fsv\TypographyBundle\Typographer\TypographerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TypographyListener implements EventSubscriberInterface
{
    private $typographer;

    /**
     * TypographyListener constructor.
     * @param TypographerInterface $typographer
     */
    public function __construct(TypographerInterface $typographer)
    {
        $this->typographer = $typographer;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT => 'onSubmit'
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function onSubmit(FormEvent $event)
    {
        $data = $event->getData();

        if (!is_string($data)) {
            return;
        }

        $event->setData($this->typographer->typography($data));
    }
}
