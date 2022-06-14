<?php

namespace App\Controller;

use App\Entity\DecoMurale;
use App\Form\DecoMuraleType;
use App\Repository\DecoMuraleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/deco/murale')]
class DecoMuraleController extends AbstractController
{
    #[Route('/', name: 'app_deco_murale_index', methods: ['GET'])]
    public function index(DecoMuraleRepository $decoMuraleRepository): Response
    {
        return $this->render('deco_murale/index.html.twig', [
            'deco_murales' => $decoMuraleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_deco_murale_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DecoMuraleRepository $decoMuraleRepository): Response
    {
        $decoMurale = new DecoMurale();
        $form = $this->createForm(DecoMuraleType::class, $decoMurale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $decoMuraleRepository->add($decoMurale);
            return $this->redirectToRoute('app_deco_murale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deco_murale/new.html.twig', [
            'deco_murale' => $decoMurale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deco_murale_show', methods: ['GET'])]
    public function show(DecoMurale $decoMurale): Response
    {
        return $this->render('deco_murale/show.html.twig', [
            'deco_murale' => $decoMurale,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_deco_murale_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DecoMurale $decoMurale, DecoMuraleRepository $decoMuraleRepository): Response
    {
        $form = $this->createForm(DecoMuraleType::class, $decoMurale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $decoMuraleRepository->add($decoMurale);
            return $this->redirectToRoute('app_deco_murale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('deco_murale/edit.html.twig', [
            'deco_murale' => $decoMurale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_deco_murale_delete', methods: ['POST'])]
    public function delete(Request $request, DecoMurale $decoMurale, DecoMuraleRepository $decoMuraleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$decoMurale->getId(), $request->request->get('_token'))) {
            $decoMuraleRepository->remove($decoMurale);
        }

        return $this->redirectToRoute('app_deco_murale_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/deco/murale/tiles', name: 'app_deco_murale_tiles')]
    public function tile(): Response
    {
        return $this->render('deco_murale/tiles.html.twig', [
            'support' => 'Tiles',
        ]);
    }

    #[Route('/toile', name: 'app_deco_murale_toile')]
    public function toile(): Response
    {
        return $this->render('deco_murale/toile.html.twig', [
        ]);
    }
    #[Route('/mdf', name: 'app_deco_murale_mdf')]
    public function mdf(): Response
    {
        return $this->render('deco_murale/mdf.html.twig', [
        ]);
    }
    #[Route('/cadre', name: 'app_deco_murale_cadre')]
    public function cadre(): Response
    {
        return $this->render('deco_murale/cadre.html.twig', [
        ]);
    }
}
