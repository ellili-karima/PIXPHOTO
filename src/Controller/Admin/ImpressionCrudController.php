<?php

namespace App\Controller\Admin;

use App\Entity\Impression;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImpressionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Impression::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           
            yield TextField::new('nom'),
        ];
    }
    
}
