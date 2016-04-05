<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                'label' => 'Désignation',
                'required' => true,
                'attr' => array('oninvalid' => 'toastr.warning("désignation non renseignée")')
            ))
            ->add('parentCategorie', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle\Entity\Categorie',
                'choice_label' => 'designation',
                'multiple' => false,
                'required' => true,
                'attr' => array('oninvalid' => "toastr.error('catégorie non sélectionnée : L__name__')"),
                'label' => 'Catégorie parent',
                'placeholder' => '-- Sélectionner une catégorie --',
                'empty_data' => '',

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
        return 'categorie';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Categorie',
            'csrf_token_id' => 'categorie',
        ));
    }
}