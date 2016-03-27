<?php

namespace AppBundle\Form;


use AppBundle\Entity\FactureLigne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lieu', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                'label' => 'Lieu',
                'required' => true
            ))
            ->add('date', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                'label' => 'Date',
                'required' => true
            ))
            ->add('montant', 'Symfony\Component\Form\Extension\Core\Type\MoneyType', array(
                'label' => 'Montant',
                'required' => true
            ))
        ;

        // ajout du formulaire de lignes de facture
        $builder->add('lignes', CollectionType::class, array(
            'entry_type' => FactureLigneType::class,
            'by_reference' => false,
            'allow_add' => true,
        ));

    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'facture';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Facture',
            'csrf_token_id' => 'facture',
            'csrf_protection' => false
        ));
    }
}