<?php

namespace AppBundle\Form;



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
                'required' => true,
                'attr' => array('oninvalid' => "toastr.error('lieu non renseigné')")
            ))
            ->add('date', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                'label' => 'Date',
                'required' => true,
                'attr' => array('oninvalid' => "toastr.error('date invalide')")
            ))
            ->add('montant', 'Symfony\Component\Form\Extension\Core\Type\MoneyType', array(
                'label' => 'Montant',
                'required' => true,
                'attr' => array('oninvalid' => "toastr.error('montant non renseigné')")
            ))
        ;

        // ajout du formulaire de lignes de facture
        $builder->add('lignes', CollectionType::class, array(
            'entry_type' => FactureLigneType::class,
            'by_reference' => false,
            'allow_add' => true,
            'allow_delete' => true,
        ));

        // ajout du formulaire de fidelites de facture
        $builder->add('fidelites', CollectionType::class, array(
            'entry_type' => FactureFideliteType::class,
            'by_reference' => false,
            'allow_add' => true,
            'allow_delete' => true,
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
        ));
    }
}