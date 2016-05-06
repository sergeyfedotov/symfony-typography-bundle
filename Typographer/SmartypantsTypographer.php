<?php

namespace Fsv\TypographyBundle\Typographer;

class SmartypantsTypographer implements TypographerInterface
{
    private $typographer;

    /**
     * @param int|string $attr
     */
    public function __construct($attr)
    {
        $this->typographer = new \Michelf\SmartyPantsTypographer($attr);
    }

    /**
     * {@inheritdoc}
     */
    public function typography($text)
    {
        return $this->typographer->transform($text);
    }
}
