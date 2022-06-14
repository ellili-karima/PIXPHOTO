<?php

namespace App\Form;

use App\Entity\Couleur;
use App\Entity\DecoMurale;
use App\Entity\Impression;
use App\Entity\DecoMuralePhoto;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DecoMuralePhotoTilesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            
            ->add('photo' , FileType::class ,[
                'label' => false,
                'mapped' => false,//parce que dans decoMuralePhoto je n'ai pas propriété photo
                //et comme je n'ai pas propriété photo je dois mettre mapped à false de facon qu'il n'arrive pas à chercher à l'intérieur de l'entité
                // si non il va dire je ne trouve pas le getteur et le setteur de cette propriété
                'required' => true
            ])
            ->add('impression' , EntityType::class,array(
                'class' => Impression::class,
                'choice_label' => 'nom',
                'multiple' => false,
                'mapped' => true,
                'label' => " ",
                'placeholder' => "Selectionnez la face",
                'required' => true
                ))
            ->add('decoMurale', EntityType::class,[

                'class'=> DecoMurale::class,
                'multiple'=>false,
                'required' => true,
                'choice_label'=>'format',
                'placeholder' => "Selectionnez le format",
                'label' => ' ',
                'query_builder' =>function(EntityRepository $er){
                    $qb = $er->createQueryBuilder('d')
                        ->andWhere('d.support = :val')
                        ->setParameter('val', 'Tiles')
                        ->add('groupBy', 'd.format');
                    ;
                    return $qb;
                },
            ])
            ->add('couleur', ChoiceType::class,[
                'label' => 'Couleur',
                'required' => true,
                'expanded' => true,

            ])
                ;
            //FormInterface c'est une interface qui permet d'aller fouiller à l'interieur du formulaire au dessus (on peut aller chercher les methodes le add directement)
            //je mets $decoMurale = null si le format n'été pas selectionné
            $formModifier = function(FormInterface $form, DecoMurale $decoMurale = null){
                //on va chercher le format concerné par les couleurs en question
                //si le decoMurale est vide on va enoyer un tableau vide [] si non on va envoyé le format
                $format = (null === $decoMurale) ? [] : $decoMurale->getFormat();
 
                //je vais ajouter les couleurs filtrées à mon formulaire
                $form->add('couleur' , EntityType::class,[
                    'class'=> Couleur::class,
                    'choice_label'=> 'couleur',
                    'label' => "Couleur ",
                    'expanded' => true,
                    'query_builder' =>function(EntityRepository $er ) use ($format){
                       
                            $qb = $er->createQueryBuilder('c')
                            ->join('c.decoMurales', 'd')
                            ->andWhere('d.support = :val')
                            ->setParameter('val', 'Tiles')
                            ->Where('d.format = :val')
                            ->setParameter('val', $format)
                            ;
                            return $qb;
                    },
                    
                ]);

            };
            //builder est le constructeur du formaulaire dessus on va aller chercher le champs decoMurale
            //on va mettre un eventListener qui aura des parametes
            //le 1er parametre c'est l'evenement ou on va s'accrocher
            //(on va s'accrocher sur FormEvents et on va se mettre en POST_SUBMIT c.a.d apres l'nvoie du formulaire)
            //=> on va envoyer le formulaire pas ajax , on va récupérer les informations à cette endroit là et on va renvoyer les couleurs selon le format ce q'il va contenir
            //on suite on fait la fonction qui va etre executer au même que notre formulaire va etre envoié
            //on va utiliser une variable $formModifier qui va etre une fonction de callBack
            $builder->get('decoMurale')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifier){
                    //on va récupérer le format qui a été selectionnée
                    //on va le chercher dans event
                    //getForm permet de récuperer le formulaire dans l'événement et on va récupérer les données
                    $format = $event->getForm()->getData();
                    //on ecrit la fonction formModifier au dessus
                    //le premier parametre va etre le formulaire
                    //le deuxieme est le format selectionné
                    //->getForm il est lié à builder il va chercher uniquement decoMurale c'est pour ça on va aller chercher le parent (le formulaire lui-même)
                    //si on fait que getForm => on a que le decoMurale => le format
                    $formModifier($event->getForm()->getParent(), $format);
                }
            );
            // conclusion: on a deux bloques, le 1er va ecouter un evenement de changement des formats
            // si on a le formulaire POST::SUBMIT on recupére l'evenement
            // dans l'evenement on recupére le formulaire de la partie format et on récupére ces donneés
            //et le deuxieme va charger le champs couleurs par la liste des couleurs associés à chaque format selectionné
            //===>on va ajouter du js dans la page twig pour pouvoir afficher le resultat
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DecoMuralePhoto::class,
        ]);
    }
}
