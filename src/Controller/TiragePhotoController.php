<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\TiragePhoto;
use App\Form\TiragePhotoType;
use App\Form\UpdateTiragePhotoType;
use App\Repository\PhotoRepository;
use App\Repository\TirageRepository;
use App\Form\TiragePhotoIdentiteType;
use App\Form\TiragePhotoQuantiteType;
use App\Repository\TiragePhotoRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\UpdateTiragePhotoIdentiteType;
use App\Form\UpdateTiragePhotoQuantiteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/tirage/photo')]
class TiragePhotoController extends AbstractController
{
    #[Route('/', name: 'app_tirage_photo_index', methods: ['GET', 'POST'])]
    public function index(TiragePhotoRepository $tiragePhotoRepository, Request $request, PhotoRepository $photoRepository, UserInterface $user, TirageRepository $tirageRepository): Response
    {
        //je recupere la valeur de type de l url
        (string) $tirage = $request->get('tirage');
        //je recupere la liste des tiragePhoto de l'utilisateur connecté par type de tirage
        $tirage_photo = $tiragePhotoRepository->getTiragePhotoUser($user, $tirage);


        $tiragePhoto = new TiragePhoto();

        if ($tirage == 'Tirage Photo') {
            $form = $this->createForm(TiragePhotoType::class, $tiragePhoto);
            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {

                // on récupere les photos transmises
                $photos = $form->get('photo')->getData();

                //on boucle sur les photos
                foreach ($photos as $photo) {
                    //on génére un nouveau nom du fichier photo.
                    $fichier = md5(uniqid()) . '.' . $photo->guessExtension();
                    //on copie le fichier dans le dossier tiragePhoto
                    $photo->move(
                        $this->getParameter('tiragePhoto_dir'),
                        $fichier
                    );

                    // on stocke l'image dans la base de données (son nom)
                    $img = new Photo();
                    $img->setPhoto($fichier);
                    // on insere l'ulisateur connecté à la photo
                    $img->setUser($user);
                    $tiragePhoto->addPhoto($img);
                }
                $tiragePhoto->setDateCreation(new \DateTime());
                //on recupere le checkbox des options
                $options = $form->get('options')->getData();
                foreach ($options as $option) {
                    $tiragePhoto->addOptionsTiragePhoto($option);
                }

                $tiragePhotoRepository->add($tiragePhoto);
                return $this->redirectToRoute('app_tirage_photo_index', ['tirage' => $tirage], Response::HTTP_SEE_OTHER);
            }
        } elseif ($tirage == 'Tirage Identite') {
            $form = $this->createForm(TiragePhotoIdentiteType::class, $tiragePhoto);
            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {

                // on récupere les photos transmises
                $photo = $form->get('photo')->getData();
                //on boucle sur les photos
                    //on génére un nouveau nom du fichier photo.
                    $fichier = md5(uniqid()) . '.' . $photo->guessExtension();
                    //on copie le fichier dans le dossier tiragePhoto
                    $photo->move(
                        $this->getParameter('tiragePhoto_dir'),
                        $fichier
                    );

                    // on stocke l'image dans la base de données (son nom)
                    $img = new Photo();
                    $img->setPhoto($fichier);
                    // on insere l'ulisateur connecté à la photo
                    $img->setUser($user);
                    $tiragePhoto->addPhoto($img);
                
                $tiragePhoto->setDateCreation(new \DateTime());
                $tiragePhotoRepository->add($tiragePhoto);
                return $this->redirectToRoute('app_tirage_photo_index', ['tirage' => $tirage], Response::HTTP_SEE_OTHER);
            }
        }elseif ($tirage == 'Tirage grande quantite'){
            $form = $this->createForm(TiragePhotoQuantiteType::class, $tiragePhoto);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                // on récupere les photos transmises
                $photos = $form->get('photo')->getData();

                //on boucle sur les photos
                foreach ($photos as $photo) {
                    //on génére un nouveau nom du fichier photo.
                    $fichier = md5(uniqid()) . '.' . $photo->guessExtension();
                    //on copie le fichier dans le dossier tiragePhoto
                    $photo->move(
                        $this->getParameter('tiragePhoto_dir'),
                        $fichier
                    );

                    // on stocke l'image dans la base de données (son nom)
                    $img = new Photo();
                    $img->setPhoto($fichier);
                    // on insere l'ulisateur connecté à la photo
                    $img->setUser($user);
                    $tiragePhoto->addPhoto($img);
                }
                $tiragePhoto->setDateCreation(new \DateTime());
                //on recuper le checkbox des options
                $options = $form->get('options')->getData();
                foreach ($options as $option) {
                    $tiragePhoto->addOptionsTiragePhoto($option);
                }

                $tiragePhotoRepository->add($tiragePhoto);
                return $this->redirectToRoute('app_tirage_photo_index', ['tirage' => $tirage,], Response::HTTP_SEE_OTHER);
        }}
        return $this->render('tirage_photo/index.html.twig', [
            'tirage_photos' =>  $tirage_photo,
            'form' => $form->createView(),
            'photos' => $photoRepository->findAll(),
            'tiragePhoto' => $tiragePhoto,
            'tirage' => $tirage,
            'tirageRepository' => $tirageRepository,
            'idtirage' => ($tirageRepository->getId()),
            dump(($tirageRepository->getId())[0]['id']),
            dump($tirageRepository->getId())

        ]);
    }

    

    #[Route('/{id}', name: 'app_tirage_photo_show', methods: ['GET'])]
    public function show(TiragePhoto $tiragePhoto, Request $request): Response
    {
        //je recupere la valeur de type de l url
        (string) $tirage = $request->get('tirage');
        return $this->render('tirage_photo/show.html.twig', [
            'tirage_photo' => $tiragePhoto,
            'tirage' => $tirage
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tirage_photo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TiragePhoto $tiragePhoto, TiragePhotoRepository $tiragePhotoRepository, UserInterface $user): Response
    {
        //je recupere la valeur de type de l url
        (string) $tirage = $request->get('tirage');
        //je recupere la liste des tiragePhoto de l'utilisateur connecté par type de tirage
        $tirage_photo = $tiragePhotoRepository->getTiragePhotoUser($user, $tirage);

        if ($tirage == 'Tirage Photo') {
            $formEdit = $this->createForm(UpdateTiragePhotoType::class, $tiragePhoto);
            $formEdit->handleRequest($request);
            if ($formEdit->isSubmitted() && $formEdit->isValid()) {
                $photos = $formEdit->get('photo')->getData();
                //on boucle sur les photos
                foreach ($photos as $photo) {
                    //on genere un nouveau nom du fichier image.
                    $fichier = md5(uniqid()) . '.' . $photo->guessExtension();

                    //on copie le fichier dans le dossier tiragePhoto
                    $photo->move(
                        $this->getParameter('tiragePhoto_dir'),
                        $fichier
                    );

                    // on stocke l'image dans la base de données (son nom)
                    $img = new Photo();
                    $img->setPhoto($fichier);
                    $img->setUser($user);
                    $tiragePhoto->addPhoto($img);
                }
                
                //on recuper le checkbox des options
                $options = $formEdit->get('options')->getData();
                foreach ($options as $option) {
                    $tiragePhoto->addOptionsTiragePhoto($option);
                }

                // //on récupére le checkbox valide
                // $checked = $formEdit->get('options')->getData();
                // //on récupére les options du bien
                // $optionsTiragePhoto = $tiragePhoto->getOptionsTiragePhoto()->getValues();
                // //on parcours la liste des checkbox du table option
                // foreach ($checked as $option) {
                //     $val = false;
                //     //on parcours la liste de designation
                //     foreach ($optionsTiragePhoto as $optionEx) {
                //         if ($optionEx->getId() == $option->getId()) {
                //             $val = true;
                //         }
                //     }
                //     if (!$val) {
                //         $tiragePhoto->addOptionsTiragePhoto($option);
                //     }
                // } 

                $tiragePhotoRepository->add($tiragePhoto);
                return $this->redirectToRoute('app_tirage_photo_index', ['tirage' => $tirage], Response::HTTP_SEE_OTHER);
            }
        } elseif ($tirage == 'Tirage Identite') {
            $formEdit = $this->createForm(UpdateTiragePhotoIdentiteType::class, $tiragePhoto);
            $formEdit->handleRequest($request);
            if ($formEdit->isSubmitted() && $formEdit->isValid()) {
                $photo = $formEdit->get('photo')->getData();
                $id = $request->get('id');
                //on boucle sur les photos
                if($photo){
                    //on récupère les photos du tiragePhoto de la db
                    $photosTirage= $tiragePhotoRepository->find($id)->getPhotos();
                    foreach ($photosTirage as $photoTirage) {
                        //on recupere le nom de la photo de la base de donées
                        $nom = $photoTirage->getPhoto();
                        //on supprime la photo du dossier tiragePhoto
                        unlink($this->getParameter('tiragePhoto_dir') . '/' . $nom);
                        //on supprime la photo de la base de donnée
                        $tiragePhotoRepository->find($id)->removePhoto($photoTirage);
                    
                        //on genere un nouveau nom du fichier image.
                        $fichier = md5(uniqid()) . '.' . $photo->guessExtension();
                        $photoTirage->setPhoto($fichier);   
                        //on copie le fichier dans le dossier tiragePhoto
                        $photo->move(
                            $this->getParameter('tiragePhoto_dir'),
                            $fichier
                    );

                    $tiragePhotoRepository->find($id)->addPhoto($photoTirage);
                    }
                }
                $tiragePhotoRepository->add($tiragePhoto);
                return $this->redirectToRoute('app_tirage_photo_index', ['tirage' => $tirage], Response::HTTP_SEE_OTHER);
            }
        }elseif ($tirage == 'Tirage grande quantite') {

            $formEdit = $this->createForm(UpdateTiragePhotoQuantiteType::class, $tiragePhoto);
            $formEdit->handleRequest($request);
            if ($formEdit->isSubmitted() && $formEdit->isValid()) {
                $photos = $formEdit->get('photo')->getData();
                //on boucle sur les photos
                foreach ($photos as $photo) {
                    //on genere un nouveau nom du fichier image.
                    $fichier = md5(uniqid()) . '.' . $photo->guessExtension();

                    //on copie le fichier dans le dossier tiragePhoto
                    $photo->move(
                        $this->getParameter('tiragePhoto_dir'),
                        $fichier
                    );

                    // on stocke l'image dans la base de données (son nom)
                    $img = new Photo();
                    $img->setPhoto($fichier);
                    $img->setUser($user);
                    $tiragePhoto->addPhoto($img);
                }
                
                //on recuper le checkbox des options
                $options = $formEdit->get('options')->getData();
                foreach ($options as $option) {
                    $tiragePhoto->addOptionsTiragePhoto($option);
                }

                $tiragePhotoRepository->add($tiragePhoto);
                return $this->redirectToRoute('app_tirage_photo_index', ['tirage' => $tirage], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->renderForm('tirage_photo/edit.html.twig', [
            'tirage_photo' => $tiragePhoto,
            'form' => $formEdit,
            'tirage_photos' =>  $tirage_photo,
            'tirage' => $tirage
        ]);
    }



    #[Route('/{id}', name: 'app_tirage_photo_delete', methods: ['POST'])]
    public function delete(Request $request, TiragePhoto $tiragePhoto, TiragePhotoRepository $tiragePhotoRepository, UserInterface $user): Response
    {
        //je recupere la valeur de type de l url
        (string) $tirage = $request->get('tirage');
        $id = $request->get('id');
        if ($this->isCsrfTokenValid('delete' . $tiragePhoto->getId(), $request->request->get('_token'))) {
            //on recupere les photos 
            $photos = $tiragePhoto->getPhotos();
            //on les parcours
            foreach ($photos as $photo) {
                //on recupere le nom de la photo
                $nom = $photo->getPhoto();
                //on retire la photo du dossier
                unlink($this->getParameter('tiragePhoto_dir') . '/' . $nom);
            }
            //on retire le tiragePhoto de la base de données
            $tiragePhotoRepository->remove($tiragePhoto);
        }

        return $this->redirectToRoute('app_tirage_photo_index', ['tirage' => $tirage], Response::HTTP_SEE_OTHER);
    }


    #[Route('/photo/{id}', name: 'app_photo_delete', methods: ['POST'])]
    public function deletePhoto(ManagerRegistry $manager, Request $request, Photo $photo): Response
    {
        
        if ($this->isCsrfTokenValid('delete' . $photo->getId(), $request->request->get('_token'))) {

            //on récupère le nom de la photo
            $nom = $photo->getPhoto();
            //on supprime la photo du dossier tiragePhoto
            unlink($this->getParameter('tiragePhoto_dir') . '/' . $nom);

            //on supprime la photo de la base
            $em = $manager->getManager();
            $em->remove($photo);
            $em->flush();
            
            $this->addFlash("success", "La photo a été supprimé avec succès");
            return $this->redirectToRoute('app_tirage_photo_index', ['tirage' => 'Tirage Photo'], Response::HTTP_SEE_OTHER);
        } else {
            $this->addFlash('error', "Echec la photo n'a pas été supprimé avec succès");
        }
    }
}

