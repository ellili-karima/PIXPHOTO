<?php

namespace App\Controller\Admin;

use App\Entity\Couleur;
use App\Form\CouleurType;
use App\Entity\DecoMurale;
use App\Form\DecoMuraleType;
use App\Repository\CouleurRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DecoMuraleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DecoMurale::class;
    }
    
    
    public function configureFields(string $pageName): iterable
    {
        
        return [
            yield ChoiceField::new('support')->setChoices([
                // $value => $badgeStyleName
                'Tiles' => 'tiles',
                'Toiles' => 'toiles',
                'Mdf' => 'mfd',
                'Cadre' => 'cadre',
            ]),
            yield TextField::new('format'),
            yield TextField::new('epaisseur'),
            yield TextField::new('couleur' ,'couleur'),
            yield MoneyField::new('prix')->setCurrency('EUR'),
            yield IntegerField::new('stock'),
        ];
    }
    
    

   
    
}
