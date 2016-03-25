<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lieu', 'text', array(
                'label' => 'Lieu',
                'required' => true
            ))
            ->add('date', 'date', array(
                'label' => 'Date',
                'required' => true
            ))
            ->add('montant', 'money', array(
                'label' => 'Montant',
                'required' => true
            ))
            ->add('modeOperation', 'entity', array(
                'class' => 'AppBundle\Entity\ModeOperation',
                'property' => 'designation',
                'multiple' => false,
                'required' => true,
                'label' => 'Mode',
                'empty_value' => '-- Sélectionner un mode --',
                'empty_data' => '',

            ))
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'operation';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Operation',
            'intention' => 'operation',
            'csrf_protection' => false
        ));
    }
}