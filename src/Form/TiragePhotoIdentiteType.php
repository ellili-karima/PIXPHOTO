<?php

namespace App\Form;


use App\Entity\Photo;
use App\Entity\Option;
use App\Entity\Tirage;
use App\Entity\TiragePhoto;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TiragePhotoIdentiteType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options ): void
    {
        
        $builder
            
            ->add('photo' , FileType::class ,[
                'label' => false,
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
            

            ;
            $builder->add('tirage', EntityType::class,[
    
                    'class'=> Tirage::class,
                    'multiple'=>false,
                    'placeholder' => 'choisissez le format',
                    'choice_label'=>'tirage',
                    'label' => ' ',
                    'query_builder' =>function(EntityRepository $er){
                        $tirage='Tirage Identite';
                        $qb = $er->createQueryBuilder('t');
                            $qb->where($qb->expr()->like('t.tirage', $qb->expr()->literal("$tirage%")))
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
