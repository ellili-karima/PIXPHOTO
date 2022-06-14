<?php

namespace App\Form;

use App\Entity\Couleur;
use App\Entity\DecoMurale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DecoMuraleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('support', ChoiceType::class, [
                'placeholder' => 'Choisissez le support',
                'choices' => [
                    'Tiles' => 'Tiles',
                    'Toiles' => 'Toiles',
                    'Mdf' => 'Mdf',
                    'Cadre' => 'Cadre'
                ],
                'choice_attr' => [
                    'Apple' => ['data-color' => 'Red'],
                    'Banana' => ['data-color' => 'Yellow'],
                    'Durian' => ['data-color' => 'Green'],
                ],
            ])
            ->add('format',ChoiceType::class, [
                'placeholder' => 'Choisissez le format',
                'choices' => [
                    '8x8 cm' => '8x8 cm',
                    '12x12 cm' => '12x12 cm'
                ],
                'choice_attr' => [
                    'Apple' => ['data-color' => 'Red'],
                    'Banana' => ['data-color' => 'Yellow']
                ],
            ])
            ->add('epaisseur')
            ->add('prix')
            ->add('stock')
            ->add('couleur',EntityType::class , array(
                    'class' => Couleur::class,
                    'mapped' => true,
                    'placeholder' => 'choisissez la couleur',
                    'label' => " ",
                    'choice_label' => 'couleur',
                    ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DecoMurale::class,
        ]);
    }
}
