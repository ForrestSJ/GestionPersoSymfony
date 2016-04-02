<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeOperationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                'label' => 'Désignation',
                'required' => true,
                'attr' => array('oninvalid' => 'toastr.warning("désignation non renseignée")')
            ))
        ;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'mode_operation';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ModeOperation',
            'csrf_token_id' => 'mode_operation',
        ));
    }
}