<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DecoMuraleController extends AbstractController
{
    #[Route('/deco/murale', name: 'app_deco_murale')]
    public function index(): Response
    {
        return $this->render('deco_murale/index.html.twig', [
            'controller_name' => 'DecoMuraleController',
        ]);
    }

    #[Route('/deco/murale/tile', name: 'app_deco_murale_tile')]
    public function tile(): Response
    {
        return $this->render('deco_murale/tile.html.twig', [
            'controller_name' => 'DecoMuraleController',
        ]);
    }

    #[Route('/deco/murale/toile', name: 'app_deco_murale_toile')]
    public function toile(): Response
    {
        return $this->render('deco_murale/toile.html.twig', [
            'controller_name' => 'DecoMuraleController',
        ]);
    }
    #[Route('/deco/murale/mdf', name: 'app_deco_murale_mdf')]
    public function mdf(): Response
    {
        return $this->render('deco_murale/mdf.html.twig', [
            'controller_name' => 'DecoMuraleController',
        ]);
    }
    #[Route('/deco/murale/cadre', name: 'app_deco_murale_cadre')]
    public function cadre(): Response
    {
        return $this->render('deco_murale/cadre.html.twig', [
            'controller_name' => 'DecoMuraleController',
        ]);
    }
}
