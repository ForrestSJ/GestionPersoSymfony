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
            ->add('lieu', 'Symfony\Component\Form\Extension\Core\Type\TextType', array(
                'label' => 'Lieu',
                'required' => true
            ))
            ->add('date', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                'label' => 'Date',
                'widget' => 'single_text',
                'input' => 'datetime',
                'format' => 'dd/MM/yy',
                'required' => true
            ))
            ->add('montant', 'Symfony\Component\Form\Extension\Core\Type\MoneyType', array(
                'label' => 'Montant',
                'required' => true
            ))
            ->add('modeOperation', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle\Entity\ModeOperation',
                'choice_label' => 'designation',
                'multiple' => false,
                'required' => true,
                'label' => 'Mode',
                'placeholder' => '-- Sélectionner un mode --',
                'empty_data' => '',
            ))
            ->add('compte', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle\Entity\Compte',
                'choice_label' => 'designation',
                'multiple' => false,
                'required' => true,
                'label' => 'Compte',
                'placeholder' => '-- Sélectionner un compte --',
                'empty_data' => '',
            ))
            ->add('commentaire', 'Symfony\Component\Form\Extension\Core\Type\TextareaType', array(
                'label' => 'Commentaire',
                'required' => false
            ))
            ->add('categorie', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'class' => 'AppBundle\Entity\Categorie',
                'choice_label' => 'designation',
                'multiple' => false,
                'required' => false,
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
        return 'operation';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Operation',
            'csrf_token_id' => 'operation',
        ));
    }
}