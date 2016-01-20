<?php

namespace Fsv\TypographyBundle\Typograph;

class TypographMap implements TypographMapInterface
{
    /**
     * @var array
     */
    private $map;

    /**
     * @param array $map
     */
    public function __construct(array $map)
    {
        $this->map = $map;
    }

    /**
     * {@inheritdoc}
     */
    public function getTypograph($name)
    {
        if (!isset($this->map[$name])
            || !$this->map[$name] instanceof TypographInterface
        ) {
            throw new \InvalidArgumentException(sprintf('Typograph "%s" was not configured', $name));
        }

        return $this->map[$name];
    }
}
