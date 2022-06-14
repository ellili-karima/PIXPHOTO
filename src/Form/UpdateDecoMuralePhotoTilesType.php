<?php

namespace App\Form;

use App\Entity\Couleur;
use App\Entity\DecoMurale;
use App\Entity\Impression;
use App\Entity\DecoMuralePhoto;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UpdateDecoMuralePhotoTilesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('photo' , FileType::class ,[
                'label' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('impression' , EntityType::class,array(
                'class' => Impression::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => false,
                'mapped' => true,
                'label' => "Face",
                'required' => true
                ))
                ;
            $builder->add('decoMurale', EntityType::class,[

                'class'=> DecoMurale::class,
                'multiple'=>false,
                'expanded' => true,
                'required' => true,
                'choice_label'=>'format',
                'label' => "Format",
                'query_builder' =>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('d')
                        ->andWhere('d.support = :val')
                        ->setParameter('val', 'Tiles')
                        ->add('groupBy', 'd.format');
                    ;
                    return $qb;
                }
            ]);
            $builder->add('couleur', EntityType::class,[

                'class'=> Couleur::class,
                'multiple'=>false,
                'expanded' => true,
                'mapped'=> true,
                'required' => true,
                'choice_label'=>'couleur',
                'label' => "Couleur",
                'query_builder' =>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('c')
                        ->join('c.decoMurales', 'd')
                        ->andWhere('d.support = :val')
                        ->setParameter('val', 'Tiles')
                        ->add('groupBy', 'd.couleur');
                    ;
                    return $qb;
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DecoMuralePhoto::class,
        ]);
    }
}
