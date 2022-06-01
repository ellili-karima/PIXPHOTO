<?php

namespace App\Controller\Admin;

use App\Entity\DecoMurale;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
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
            yield TextField::new('support'),
            yield TextField::new('format'),
            yield TextField::new('epaisseur'),
            yield TextField::new('couleur'),
            yield MoneyField::new('prix')->setCurrency('EUR'),
            yield IntegerField::new('stock'),
        ];
    }
    
}
