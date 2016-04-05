<?php

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureLigneType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                'label' => 'Designation',
                'required' => true,
                'attr' => array('oninvalid' => "toastr.error('designation non renseigné : L__name__')")
            ))
            ->add('montant', 'Symfony\Component\Form\Extension\Core\Type\MoneyType', array(
                'label' => 'Montant',
                'required' => true,
                'attr' => array('oninvalid' => "toastr.error('montant non renseigné : L__name__')")
            ))
            ->add('categorie', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle\Entity\Categorie',
                'choice_label' => 'designation',
                'multiple' => false,
                'required' => true,
                'attr' => array('oninvalid' => "toastr.error('catégorie non sélectionnée : L__name__')"),
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
        return 'factureLigne';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\FactureLigne',
            'csrf_token_id' => 'factureLigne',
        ));
    }
}