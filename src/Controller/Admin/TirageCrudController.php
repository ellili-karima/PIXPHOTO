<?php

namespace App\Controller\Admin;

use App\Entity\Tirage;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TirageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tirage::class;
    }


    
    public function configureFields(string $pageName): iterable
    {
        return [
           
            yield TextField::new('tirage'),
            yield TextField::new('format'),
            yield MoneyField::new('prix')->setCurrency('EUR'),
            yield IntegerField::new('quantite'),
            // yield IntegerField::new('quantite_photo'),
            // yield ImageField::new('image')
            // ->setBasePath('uploads/images/tirage')
            // ->setUploadDir('public/uploads/images/tirage/')
        ];
    }
    
}
