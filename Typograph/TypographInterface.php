<?php
namespace Fsv\TypographyBundle\Typograph;

interface TypographInterface
{
    /**
     * @param array $options
     */
    public function setup(array $options);

    /**
     * @param string $text
     * @return string
     */
    public function apply($text);
}
