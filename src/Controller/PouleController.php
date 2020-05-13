<?php

namespace App\Controller;

use App\Entity\Poule;
use App\Form\PouleType;
use App\Repository\LandRepository;
use App\Repository\PouleRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/poule")
 */
class PouleController extends AbstractController
{
    /**
     * @Route("/", name="poule_index", methods={"GET"})
     */
    public function index(PouleRepository $pouleRepository, UserRepository $userRepository): Response
    {
        // rended resultaten en geef alle poules door en de resultaten van de admin
        $admin = $userRepository->findOneBy(['Username' => "Admin"])->getId();
        $results = $pouleRepository->findOneBy(['user' => $admin]);
        return $this->render('poule/index.html.twig', [
            'poules' => $pouleRepository->findAll(),
            'result' => $results
        ]);
    }

    /**
     * @Route("/new", name="poule_new", methods={"GET","POST"})
     */
    public function new(Request $request, PouleRepository $pouleRepository): Response
    {
        // haal user op met user id van session
        $resultUser = $pouleRepository->findOneBy(['user' => $this->getUser()->getId()]);

        // check of user is opgehaald
        if (!empty($resultUser)) {
            // ga terug als de user een stem heeft
            return $this->redirectToRoute('poule_index');
        }

        // haal poule op en maak een form er mee
        $poule = new Poule();
        $form = $this->createForm(PouleType::class, $poule);
        $form->handleRequest($request);

        // check of het door is gegeven
        if ($form->isSubmitted() && $form->isValid()) {
            // zet de user die het heeft aan gemaakt
            $poule->setUser($this->getUser());

            // laat doctrine het opslaan
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($poule);
            $entityManager->flush();

            // ga terug naar resultaten
            return $this->redirectToRoute('poule_index');
        }

        // render template
        return $this->render('poule/new.html.twig', [
            'poule' => $poule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="poule_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Poule $poule): Response
    {
        // check of de user deze poule heeft aangemaakt
        if ($poule->getUser()->getId() !== $this->getUser()->getId()) {
            // ga terug als de user geen stem heeft
            return $this->redirectToRoute('poule_index');
        }
        $form = $this->createForm(PouleType::class, $poule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('poule_index');
        }

        return $this->render('poule/edit.html.twig', [
            'poule' => $poule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="poule_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Poule $poule): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poule->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($poule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('poule_index');
    }
}
