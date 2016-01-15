<?php
namespace Fsv\TypographyBundle\Typograph;

use EMTypograph;

class MdashTypograph implements TypographInterface
{
    /**
     * @var EMTypograph
     */
    private $typograph;

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        $this->typograph = new EMTypograph();

        if ($options) {
            $this->setup($options);
        }
    }

    /**
     * @param array $options
     */
    public function setup(array $options)
    {
        $this->typograph->setup($options);
    }

    /**
     * @param string $text
     * @return string
     */
    public function apply($text)
    {
        $this->typograph->set_text($text);

        return $this->typograph->apply();
    }
}