<?php

namespace App\Form;

use App\Entity\DecoMurale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DecoMurale1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('support')
            ->add('format')
            ->add('epaisseur')
            ->add('prix')
            ->add('stock')
            ->add('couleur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DecoMurale::class,
        ]);
    }
}
