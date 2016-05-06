<?php

namespace Fsv\TypographyBundle\Typographer;

interface TypographerInterface
{
    /**
     * @param string $text
     * @return string
     */
    public function typography($text);
}
