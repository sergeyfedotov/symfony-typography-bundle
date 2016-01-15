<?php
namespace Fsv\TypographyBundle\Form\DataTransformer;

use Fsv\TypographyBundle\Typograph\TypographInterface;
use Symfony\Component\Form\DataTransformerInterface;

class TypographyTransformer implements DataTransformerInterface
{
    /**
     * @var TypographInterface
     */
    private $typograph;

    /**
     * @param TypographInterface $typograph
     */
    public function __construct(TypographInterface $typograph)
    {
        $this->typograph = $typograph;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        return $this->typograph->apply($value);
    }
}
