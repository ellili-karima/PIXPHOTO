<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Photo;
use App\Form\PhotoType;
use App\Repository\UserRepository;
use App\Repository\PhotoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/photo')]
class PhotoController extends AbstractController
{
    // #[Route('/', name: 'app_photo_index', methods: ['GET'])]
    // public function index(Request $request, PhotoRepository $photoRepository): Response
    // {
    //     $photo = new Photo();
    //     $form = $this->createForm(PhotoType::class, $photo);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $photoRepository->add($photo);
    //         return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
    //     }
    //     return $this->render('photo/index.html.twig', [
    //         'photos' => $photoRepository->findAll(),
    //         'photo' => $photo,
    //         'form' => $form->createView(),
    //     ]);
    // }

    #[Route('/new', name: 'app_photo_new', methods: ['GET', 'POST'])]
    public function new(ManagerRegistry $manager, Request $request, PhotoRepository $photoRepository, UserInterface $user): Response
    {
        //$photos = $photoRepository->getPhotoTirageUser($user);
        $p = new Photo();
        $form = $this->createForm(PhotoType::class, $p);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
            // //$p= $form->getData();
            // // On récupère les informations de l'image reçue à travers le form
            // $photos = $form->get('photo')->getData();
            // //on boucle sur les photos
            // foreach ($photos as $photo) {
            //     //on génére un nouveau nom du fichier photo.
            //     $fichier = md5(uniqid()) . '.' . $photo->guessExtension();
            //     //on copie le fichier dans le dossier public/img/biens
            //     $photo->move(
            //         $this->getParameter('tiragePhoto_dir'),
            //         $fichier
            //     );

            //     // on stocke l'image dans la base de données (son nom)
            //     $img = new Photo();
            //     $img->setPhoto($fichier);
            //     $img->setUser($user);
            //     $photoRepository->add($img);
               
            // }
            $em = $manager->getManager();
            $em->persist($p);
            $this->addFlash("success", "La photo a été ajouté avec succés");
            return $this->redirectToRoute('app_photo_new', [], 201);
        }
    

        return $this->renderForm('photo/new.html.twig', [
            'photo' => $p,
            'form' => $form,
            //'photos' =>$photoRepository->getPhotosTirageUser($user) ,
        ]);
    }

    // #[Route('/{id}', name: 'app_photo_show', methods: ['GET'])]
    // public function show(Photo $photo): Response
    // {
    //     return $this->render('photo/show.html.twig', [
    //         'photo' => $photo,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_photo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Photo $photo, PhotoRepository $photoRepository): Response
    {
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoRepository->add($photo);
            return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('photo/edit.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_photo_delete', methods: ['POST'])]
    // public function delete(ManagerRegistry $manager, Request $request, Photo $photo, PhotoRepository $photoRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete' . $photo->getId(), $request->request->get('_token'))) {
    //         //$photoRepository->remove($photo);
    //         //on récupère le nom de la photo
    //         $nom = $photo->getPhoto();
    //         //on supprime la photo du dossier img
    //         unlink($this->getParameter('tiragePhoto_dir') . '/' . $nom);

    //         //on supprime la photo de la base
    //         $em= $manager->getManager();
    //         $em->remove($photo);
    //         $em->flush();

    //         $this->addFlash("success", "La photo a été supprimé avec succès");
    //         return $this->redirectToRoute('app_tirage_photo_index', ['tirage' =>'Tirage Photo'], Response::HTTP_SEE_OTHER);
    //     } else {
    //         $this->addFlash('error', "Echec la photo n'a pas été supprimé avec succès");
        
    //     }

        
    //  }
}
