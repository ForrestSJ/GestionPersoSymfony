<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureFideliteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('compte', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle\Entity\Compte',
                'choice_label' => 'designation',
                'multiple' => false,
                'required' => true,
                'attr' => array('oninvalid' => "toastr.error('compte non sélectionné : F__name__')"),
                'label' => 'Compte',
                'placeholder' => '-- Sélectionner un compte --',
                'empty_data' => '',
            ))
            ->add('montant', 'Symfony\Component\Form\Extension\Core\Type\MoneyType', array(
                'label' => 'Montant',
                'required' => true,
                'attr' => array('oninvalid' => "toastr.error('montant non renseigné : F__name__')")
            ))
            ->add('categorie', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle\Entity\Categorie',
                'choice_label' => 'designation',
                'multiple' => false,
                'required' => true,
                'attr' => array('oninvalid' => "toastr.error('catégorie non sélectionnée : F__name__')"),
                'label' => 'Categorie',
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
        return 'factureFidelite';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FactureFidelite',
            'csrf_token_id' => 'factureFidelite',
            'csrf_protection' => false
        ));
    }
}