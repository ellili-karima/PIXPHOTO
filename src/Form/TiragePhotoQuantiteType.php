<?php

namespace App\Form;


use App\Entity\Photo;
use App\Entity\Option;
use App\Entity\Tirage;
use App\Entity\TiragePhoto;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TiragePhotoQuantiteType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options ): void
    {
        
        $builder
            
            ->add('photo' , FileType::class ,[
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => true
            ])
            // ->add('tirage', EntityType::class, array(
            //     'class' => Tirage::class,
            //     'mapped' => true,
            //     'placeholder' => 'choisissez le format',
            //     'label' => " ",
            //     'choice_label' => 'tirage',
            //     ))
            

            ->add('options', EntityType::class, array(
                'class' => Option::class,
                'choice_label' => 'nom',
                'expanded' => true,
                'multiple' => true,
                'mapped' => false,
                // 'error_bubbling' => true,
                // 'required' => false
            ))
            ;
        $builder->add('tirage', EntityType::class,[

                'class'=> Tirage::class,
                'multiple'=>false,
                'placeholder' => 'choisissez le format',
                'choice_label'=>'format',
                'label' => ' ',
                'query_builder' =>function(EntityRepository $er){
                    $tirage='Tirage grande quantite';
                    $qb = $er->createQueryBuilder('t');
                        $qb->where($qb->expr()->like('t.tirage', $qb->expr()->literal("$tirage")))
                    ;
                    return $qb;
                }

            ]);
           
                ; 
               
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TiragePhoto::class,
        ]);
    }
}
