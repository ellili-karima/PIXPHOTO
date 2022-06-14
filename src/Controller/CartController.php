<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\TiragePhoto;
use App\Entity\DecoMuralePhoto;
use App\Repository\TiragePhotoRepository;
use App\Repository\DecoMuralePhotoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session , TiragePhotoRepository $tiragePhotoRepository, DecoMuralePhotoRepository $decoMuralePhotoRepository): Response
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
            if ($tiragePhoto->getTirage()->getTirage() == 'Tirage grande quantite') {
                if ($nbrePhotos < 200) {
                    $prix = $tiragePhoto->getTirage()->getPrix() * $nbrePhotos;
                }elseif($nbrePhotos >= 200 && $nbrePhotos < 300){
                    $prix = (($tiragePhoto->getTirage()->getPrix())-((($tiragePhoto->getTirage()->getPrix())*15)/100) )* $nbrePhotos;
                }elseif($nbrePhotos >= 300 && $nbrePhotos < 500){
                    $prix = (($tiragePhoto->getTirage()->getPrix())-((($tiragePhoto->getTirage()->getPrix())*20)/100) )* $nbrePhotos;
                }elseif($nbrePhotos >= 300 && $nbrePhotos < 500){
                    (($tiragePhoto->getTirage()->getPrix())-((($tiragePhoto->getTirage()->getPrix())*25)/100) )* $nbrePhotos;
                }  
            }else{
            $prix = $tiragePhoto->getTirage()->getPrix() * $nbrePhotos;
            }
            $dataPanier[] = [
                'tiragePhoto' => $tiragePhoto,
                'quantite' => $quantite,
                'date' => $date
        ];
            $total += $prix * $quantite;
        }

        $panierDeco = $session->get('panierDeco', []);
        // on fabrique les données
        $dataPanierDeco = [] ;
        $total2 = 0;
        $date2 = new \DateTime();

        
        foreach ($panierDeco as $id => $quantite) {
            $decoMuralePhoto = $decoMuralePhotoRepository->find($id);
            
            $prix = $decoMuralePhoto->getDecoMurale()->getPrix();
           
            $dataPanierDeco[] = [
                'decoMuralePhoto' => $decoMuralePhoto,
                'quantite' => $quantite,
                'date2' => $date2
        ];
            $total2 += $prix * $quantite;
        }
        


        return $this->render('cart/index.html.twig', [
            'dataPanier' => $dataPanier ,
            'total'=> $total,
            'date' => $date,
            'dataPanierDeco' => $dataPanierDeco ,
            'total2'=> $total2,
            'date2' => $date2,
        ]);
    }

    #[Route('/add/tirage/{id}', name: 'cart_add_tirage')]
    public function add(TiragePhoto $tiragePhoto, SessionInterface $session, Request $request)
    {
        $tirage = $request->get('tirage');
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
       return $this->redirectToRoute('app_cart', ['tirage' => $tirage], Response::HTTP_SEE_OTHER);
    }
    #[Route('/add/deco/{id}', name: 'cart_add_deco')]
    public function adddeco(DecoMuralePhoto $decoMuralePhoto, SessionInterface $session, Request $request)
    {
       
       //on récupère le panier actiel
        $panierDeco = $session->get("panierDeco" ,[]);
        $id = $decoMuralePhoto->getId();
        if(!empty($panierDeco[$id])){
            $panierDeco[$id]++;
        }else{
            $panierDeco[$id] = 1 ;
        };
        //on sauvgarde dans la session
        $session->set("panierDeco", $panierDeco);
        //dd($session);
       return $this->redirectToRoute('app_cart', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/remove/{id}', name: 'cart_remove_tirage')]
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

    #[Route('/delete/{id}', name: 'cart_delete_tirage')]
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

    #[Route('/delete/deco/{id}', name: 'cart_delete_deco')]
    public function deleteDeco(DecoMuralePhoto $decoMuralePhoto, SessionInterface $session)
    {
        //on récupère le panier actiel
        $panierDeco = $session->get("panierDeco" ,[]);
        $id = $decoMuralePhoto->getId();
        //on verifie si le tiragePhoto existe dans le panier
        if(!empty($panierDeco[$id])){
            //on le retire du panier
            unset($panierDeco[$id]) ;
        }
        
        //on sauvgarde dans la session
        $session->set("panierDeco", $panierDeco);
        //dd($session);
       return $this->redirectToRoute('app_cart');
    }

    #[Route('/remove/deco/{id}', name: 'cart_remove_deco')]
    public function removeDeco(DecoMuralePhoto $decoMuralePhoto, SessionInterface $session)
    {
        //on récupère le panier actiel
        $panierDeco = $session->get("panierDeco" ,[]);
        $id = $decoMuralePhoto->getId();
        //on verifie si le tiragePhoto existe dans le panier
        if(!empty($panierDeco[$id])){
            //si oui on verifier qu'il existe plus que 1
            if($panierDeco[$id]>1){
                //si oui on le retire une fois
                $panierDeco[$id]-- ;
            }else{
                //si non on le retire du panier
                unset($panierDeco[$id]) ;
            }
        }
        //on sauvgarde dans la session
        $session->set("panierDeco", $panierDeco);
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
