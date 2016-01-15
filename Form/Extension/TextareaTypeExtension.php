<?php
namespace Fsv\TypographyBundle\Form\Extension;

use Fsv\TypographyBundle\Form\DataTransformer\TypographyTransformer;
use Fsv\TypographyBundle\Typograph\TypographInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextareaTypeExtension extends AbstractTypeExtension
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
    public function getExtendedType()
    {
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['typography']) {
            $builder->addModelTransformer(
                new TypographyTransformer($this->typograph)
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('typography', false);
    }
}
