<?php

namespace Fsv\TypographyBundle\Typographer;

class MdashTypographer implements TypographerInterface
{
    private $typographer;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->typographer = new \EMTypograph();
        $this->typographer->setup($options);
    }

    /**
     * {@inheritdoc}
     */
    public function typography($text)
    {
        $this->typographer->set_text($text);

        return $this->typographer->apply();
    }
}
