<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\TiragePhoto;
use App\Repository\TiragePhotoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session , TiragePhotoRepository $tiragePhotoRepository): Response
    {
        $panier = $session->get('panier', []);

        // on fabrique les données
        $dataPanier = [] ;
        $total = 0;
        $date = new \DateTime();

        foreach ($panier as $id => $quantite) {
            $tiragePhoto = $tiragePhotoRepository->find($id);
            $photos = $tiragePhoto->getPhotos();
            $nbrePhotos = COUNT($photos);
            $prix = $tiragePhoto->getTirage()->getPrix() * $nbrePhotos;
            $dataPanier[] = [
                'tiragePhoto' => $tiragePhoto,
                'quantite' => $quantite,
                'date' => $date
        ];
            $total += $prix * $quantite;
        }
        return $this->render('cart/index.html.twig', [
            'dataPanier' => $dataPanier ,
            'total'=> $total,
            'date' => $date
        ]);
    }

    #[Route('/add/{id}', name: 'cart_add')]
    public function add(TiragePhoto $tiragePhoto, SessionInterface $session)
    {
       //on récupère le panier actiel
        $panier = $session->get("panier" ,[]);
        $id = $tiragePhoto->getId();
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1 ;
        };
        //on sauvgarde dans la session
        $session->set("panier", $panier);
        //dd($session);
       return $this->redirectToRoute('app_cart');
    }

    #[Route('/remove/{id}', name: 'cart_remove')]
    public function remove(TiragePhoto $tiragePhoto, SessionInterface $session)
    {
        //on récupère le panier actiel
        $panier = $session->get("panier" ,[]);
        $id = $tiragePhoto->getId();
        //on verifie si le tiragePhoto existe dans le panier
        if(!empty($panier[$id])){
            //si oui on verifier qu'il existe plus que 1
            if($panier[$id]>1){
                //si oui on le retire une fois
                $panier[$id]-- ;
            }else{
                //si non on le retire du panier
                unset($panier[$id]) ;
            }
        }
        //on sauvgarde dans la session
        $session->set("panier", $panier);
        //dd($session);
       return $this->redirectToRoute('app_cart');
    }

    #[Route('/delete/{id}', name: 'cart_delete')]
    public function delete(TiragePhoto $tiragePhoto, SessionInterface $session)
    {
        //on récupère le panier actiel
        $panier = $session->get("panier" ,[]);
        $id = $tiragePhoto->getId();
        //on verifie si le tiragePhoto existe dans le panier
        if(!empty($panier[$id])){
            //on le retire du panier
            unset($panier[$id]) ;
        }
        
        //on sauvgarde dans la session
        $session->set("panier", $panier);
        //dd($session);
       return $this->redirectToRoute('app_cart');
    }

    #[Route('/delete', name: 'delete_all')]
    public function deleteAll(SessionInterface $session)
    {
        
        $session->remove('panier');
       
       return $this->redirectToRoute('app_cart');
    }

    }
