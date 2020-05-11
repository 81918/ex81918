<?php

namespace App\Controller;

use App\Entity\Land;
use App\Form\LandType;
use App\Repository\LandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/land")
 */
class LandController extends AbstractController
{
    /**
     * @Route("/", name="land_index", methods={"GET"})
     */
    public function index(LandRepository $landRepository): Response
    {
        return $this->render('land/index.html.twig', [
            'lands' => $landRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="land_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $land = new Land();
        $form = $this->createForm(LandType::class, $land);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($land);
            $entityManager->flush();

            return $this->redirectToRoute('land_index');
        }

        return $this->render('land/new.html.twig', [
            'land' => $land,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="land_show", methods={"GET"})
     */
    public function show(Land $land): Response
    {
        return $this->render('land/show.html.twig', [
            'land' => $land,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="land_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Land $land): Response
    {
        $form = $this->createForm(LandType::class, $land);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('land_index');
        }

        return $this->render('land/edit.html.twig', [
            'land' => $land,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="land_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Land $land): Response
    {
        if ($this->isCsrfTokenValid('delete'.$land->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($land);
            $entityManager->flush();
        }

        return $this->redirectToRoute('land_index');
    }
}
