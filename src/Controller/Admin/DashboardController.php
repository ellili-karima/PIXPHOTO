<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Entity\Tirage;
use App\Entity\Couleur;
use App\Entity\DecoMurale;
use App\Entity\Impression;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //on a générer la rote correspandante à la liste de tirage
        $url = $this->adminUrlGenerator->setController(TirageCrudController::class)->generateUrl();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($url);

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Pixphoto');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::section('Gestion');
        yield MenuItem::subMenu('Tirage Photo', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter un tirage', 'fas fa-plus', Tirage::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des tirages', 'fas fa-eye', Tirage::class),
            MenuItem::linkToCrud('Ajouter une option', 'fas fa-plus', Option::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des options', 'fas fa-eye', Option::class),
            
          ]);
        // yield MenuItem::subMenu('Option', 'fas fa-bars')->setSubItems([
        // MenuItem::linkToCrud('Ajouter une option', 'fas fa-plus', Option::class)->setAction(Crud::PAGE_NEW),
        // MenuItem::linkToCrud('Liste des options', 'fas fa-eye', Option::class),
        // ]);
        yield MenuItem::subMenu('Decoration Murale', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter une décoration Murale', 'fas fa-plus', DecoMurale::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des décoration Murale', 'fas fa-eye', DecoMurale::class),
            MenuItem::linkToCrud('Ajouter une impression', 'fas fa-plus', Impression::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des impressions', 'fas fa-eye', Impression::class),
            ]);
        yield MenuItem::subMenu('Couleur', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter une couleur', 'fas fa-plus', Couleur::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste des couleurs', 'fas fa-eye', Couleur::class),
            ]);

    }
}
