<?php

namespace Fsv\TypographyBundle\Typograph;

interface TypographMapInterface
{
    /**
     * @param string $name
     * @return TypographInterface
     */
    public function getTypograph($name);
}
