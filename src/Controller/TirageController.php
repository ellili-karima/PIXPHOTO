<?php

namespace App\Controller;

use App\Entity\Tirage;
use App\Repository\TirageRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TirageController extends AbstractController
{
    #[Route('/tirage', name: 'app_tirage')]
    public function index(ManagerRegistry $manager, TirageRepository $repository): Response
    {
        // $typesTirage =  $manager->getRepository(Tirage::class)->getTypesTirage();
       
        // foreach ($typesTirage as $type) {
        //     $images = $manager->getRepository(Tirage::class)->getImagesTirage($type);
           
        //     dump($type , $images);
        // }

        $PrixMinTirageStandard = $repository->getPrixMinTirageStandard();
        $PrixMinTirageIdentite = $repository->getPrixMinTirageIdentite();
        
            
       
        return $this->render('tirage/index.html.twig', [
            // 'tirages' =>  $manager->getRepository(Tirage::class)->findAll(),
            // 'typestirage' => $typesTirage,
            // 'images' => $images,
            'PrixMinTirageStandard' => $PrixMinTirageStandard['prix'],
            'PrixMinTirageIdentite' => $PrixMinTirageIdentite['prix']
            
        ]);
    }
}
