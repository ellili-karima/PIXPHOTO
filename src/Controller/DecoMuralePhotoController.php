<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\DecoMuralePhoto;
use App\Form\DecoMuralePhotoType;
use App\Repository\CouleurRepository;
use App\Form\DecoMuralePhotoTilesType;
use App\Repository\DecoMuraleRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\UpdateDecoMuralePhotoTilesType;
use App\Repository\DecoMuralePhotoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/deco/murale/photo')]
class DecoMuralePhotoController extends AbstractController
{
    #[Route('/', name: 'app_deco_murale_photo_index', methods: ['GET'])]
    public function index(DecoMuralePhotoRepository $decoMuralePhotoRepository): Response
    {
        return $this->render('deco_murale_photo/index.html.twig', [
            'deco_murale_photos' => $decoMuralePhotoRepository->findAll(),
        ]);
    }

    #[Route('/tiles/new', name: 'app_deco_murale_photo_tiles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DecoMuralePhotoRepository $decoMuralePhotoRepository, UserInterface $user, DecoMuraleRepository $decoMuraleRepository, CouleurRepository $couleurRepository): Response
    {
        $decoMuralePhoto = new DecoMuralePhoto();
        $form = $this->createForm(DecoMuralePhotoTilesType::class, $decoMuralePhoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupere les photos transmises
            $photo = $form->get('photo')->getData();
            //on boucle sur les photos
                //on génére un nouveau nom du fichier photo.
                $fichier = md5(uniqid()) . '.' . $photo->guessExtension();
                //on copie le fichier dans le dossier tiragePhoto
                $photo->move(
                    $this->getParameter('tiles_dir'),
                    $fichier
                );

                // on stocke l'image dans la base de données (son nom)
                $img = new Photo();
                $img->setPhoto($fichier);
                // on insere l'ulisateur connecté à la photo
                $img->setUser($user);
                $decoMuralePhoto->addPhoto($img);

            //on recupere le format envoié par le formulaire        
            $format = $form->get('decoMurale')->getData()->getFormat();
            //on recupere la couleur envoié par le formulaire
            $couleur = $form->get('couleur')->getData();
            //on recupere la decoMurale par son format et sa couleur définis
            $decoMurale = $decoMuraleRepository->findOneBy([
                'format' => $format,
                'couleur' => $couleur
            ]);
            //on injecte la decoMurale recupéré dans la decoMuralePhoto
            $decoMuralePhoto->setDecoMurale($decoMurale);

                                                                            //on récupère le nbre du stock
                                                                            $stock = $decoMurale->getStock();
                                                                            //on insrere un nouveau nbre
                                                                            $decoMurale->setStock($stock-1);

            $decoMuralePhoto->setDateCreation(new \DateTime());
            $decoMuralePhotoRepository->add($decoMuralePhoto);
           
            return $this->redirectToRoute('app_deco_murale_photo_tiles_new', [], Response::HTTP_SEE_OTHER);
        }
        $deco12 = $decoMuraleRepository->findBy([
            'support' => 'Tiles',
            'format' => '12x12 cm',
        ]);
        $deco8 = $decoMuraleRepository->findBy([
            'support' => 'Tiles',
            'format' => '8x8 cm'
        ]);

        return $this->renderForm('deco_murale_photo/photo_tiles.html.twig', [
            'deco_murale_photo' => $decoMuralePhoto,
            'deco_murale_photos' => $decoMuralePhotoRepository->getDecoMuralePhotoTilesUser($user),
            //dump($decoMuralePhotoRepository->getDecoMuralePhotoTilesUser($user)),
            'form' => $form,
            'decoMurales' => $decoMuraleRepository->findAll(),
            'deco12' => $deco12,
            'deco8' => $deco8,
        ]);
    }

    // #[Route('/{id}', name: 'app_deco_murale_photo_show', methods: ['GET'])]
    // public function show(DecoMuralePhoto $decoMuralePhoto): Response
    // {
    //     return $this->render('deco_murale_photo/show.html.twig', [
    //         'deco_murale_photo' => $decoMuralePhoto,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_deco_murale_photo_tiles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DecoMuralePhoto $decoMuralePhoto, DecoMuralePhotoRepository $decoMuralePhotoRepository, UserInterface $user): Response
    {
        $form = $this->createForm(UpdateDecoMuralePhotoTilesType::class, $decoMuralePhoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('photo')->getData();
            $id = $request->get('id');
            //on boucle sur les photos
            if($photo){
                //on récupère les photos du tiragePhoto de la db
                $photosDecoMuralePhoto= $decoMuralePhotoRepository->find($id)->getPhotos();
                foreach ($photosDecoMuralePhoto as $photoDecoMuralePhoto) {
                    //on recupere le nom de la photo de la base de donées
                    $nom = $photoDecoMuralePhoto->getPhoto();
                    //on supprime la photo du dossier tiragePhoto
                    unlink($this->getParameter('tiles_dir') . '/' . $nom);
                    //on supprime la photo de la base de donnée
                    $decoMuralePhotoRepository->find($id)->removePhoto($photoDecoMuralePhoto);
                
                    //on genere un nouveau nom du fichier image.
                    $fichier = md5(uniqid()) . '.' . $photo->guessExtension();
                    $photoDecoMuralePhoto->setPhoto($fichier);   
                    //on copie le fichier dans le dossier tiragePhoto
                    $photo->move(
                        $this->getParameter('tiles_dir'),
                        $fichier
                );

                $decoMuralePhotoRepository->find($id)->addPhoto($photoDecoMuralePhoto);
                }
            }
    

            //on recupere le checkbox des impression
            $impression = $form->get('impression')->getData();
            $decoMuralePhoto->setImpression($impression);
            
            $decoMuralePhotoRepository->add($decoMuralePhoto);
            return $this->redirectToRoute('app_deco_murale_photo_tiles_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deco_murale_photo/edit.html.twig', [
            'deco_murale_photo' => $decoMuralePhoto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deco_murale_photo_tiles_delete', methods: ['POST'])]
    public function delete(Request $request, DecoMuralePhoto $decoMuralePhoto, DecoMuralePhotoRepository $decoMuralePhotoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$decoMuralePhoto->getId(), $request->request->get('_token'))) {

             //on recupere les photos 
             $photos = $decoMuralePhoto->getPhotos();
             //on les parcours
             foreach ($photos as $photo) {
                 //on recupere le nom de la photo
                 $nom = $photo->getPhoto();
                 //on retire la photo du dossier
                 unlink($this->getParameter('tiles_dir') . '/' . $nom);
             }
            $decoMuralePhotoRepository->remove($decoMuralePhoto);
        }

        return $this->redirectToRoute('app_deco_murale_photo_tiles_new', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/photo/{id}', name: 'app_photo_delete', methods: ['POST'])]
    public function deletePhoto(ManagerRegistry $manager, Request $request, Photo $photo): Response
    {
       
        if ($this->isCsrfTokenValid('delete' . $photo->getId(), $request->request->get('_token'))) {

            //on récupère le nom de la photo
            $nom = $photo->getPhoto();
            //on supprime la photo du dossier tiragePhoto
            unlink($this->getParameter('_dir') . '/' . $nom);

            //on supprime la photo de la base
            $em = $manager->getManager();
            $em->remove($photo);
            $em->flush();
            
            $this->addFlash("success", "La photo a été supprimé avec succès");
            return $this->redirectToRoute('app_deco_murale_photo_index', [], Response::HTTP_SEE_OTHER);
        } else {
            $this->addFlash('error', "Echec la photo n'a pas été supprimé avec succès");
        }
    }
}
