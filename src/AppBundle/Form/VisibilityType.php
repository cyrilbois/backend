<?php

namespace AppBundle\Form;

use AppBundle\Enumerator\VisibilityEnumerator;
use AppBundle\Form\DataTransformer\StringToVisibilityTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisibilityType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => array(
                'Private' => VisibilityEnumerator::PRIVATE_VISIBILITY(),
                'Public' => VisibilityEnumerator::PUBLIC_VISIBILITY()
            ),
            'empty_data' =>  VisibilityEnumerator::PRIVATE_VISIBILITY()
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new StringToVisibilityTransformer());
    }

    /**
     * @return mixed
     */
    public function getParent(){
        return ChoiceType::class;
    }
}
