<?php
namespace Fsv\TypographyBundle\Typograph;

interface TypographInterface
{
    /**
     * @param string $text
     * @return string
     */
    public function apply($text);
}
