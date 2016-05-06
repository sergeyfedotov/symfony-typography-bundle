<?php

namespace Fsv\TypographyBundle\Typographer;

class TypographerMap implements TypographerMapInterface
{
    private $map;

    /**
     * @param array $map
     */
    public function __construct(array $map)
    {
        if (!$map) {
            throw new \InvalidArgumentException('At least one typographer configuration should be available');
        }

        $this->map = $map;
    }

    /**
     * {@inheritdoc}
     */
    public function getTypographer($name)
    {
        if (!isset($this->map[$name])
            || !$this->map[$name] instanceof TypographerInterface
        ) {
            throw new \InvalidArgumentException(sprintf('Typographer "%s" was not configured', $name));
        }

        return $this->map[$name];
    }
}
