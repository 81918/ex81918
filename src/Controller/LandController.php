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
        // render template uit en geef alle landen door
        return $this->render('land/index.html.twig', [
            'lands' => $landRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="land_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        // maak een nieuwe land aan en maak daar een form aan met een speciale form type
        $land = new Land();
        $form = $this->createForm(LandType::class, $land);
        $form->handleRequest($request);

        // Check of form is doorgegeven en of de gegevends kloppen
        if ($form->isSubmitted() && $form->isValid()) {

            // haal doctrine op en geef de land door naar doctrine om het op te slaan
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($land);
            $entityManager->flush();

            // redirect naar land Dashboard
            return $this->redirectToRoute('land_index');
        }

        // render form in twig template
        return $this->render('land/new.html.twig', [
            'land' => $land,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="land_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Land $land): Response
    {
        // maak een form aan voor land om te editen
        $form = $this->createForm(LandType::class, $land);
        $form->handleRequest($request);

        // check of het is opgestuurd en info klopt
        if ($form->isSubmitted() && $form->isValid()) {

            // laat doctine het opslaan
            $this->getDoctrine()->getManager()->flush();

            // ga terug naar land dashboard
            return $this->redirectToRoute('land_index');
        }

        // render form in template
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
