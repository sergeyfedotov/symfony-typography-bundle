<?php

namespace Fsv\TypographyBundle\Typographer;

interface TypographerMapInterface
{
    /**
     * @param string $name
     *
     * @return TypographerInterface
     */
    public function getTypographer($name);
}
