<?php

namespace App\Controller;

use App\Entity\Poule;
use App\Form\PouleType;
use App\Repository\LandRepository;
use App\Repository\PouleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/poule")
 */
class PouleController extends AbstractController
{
    private $landResult;
    private $landen;
    private $landRepo;

    public function __construct(LandRepository $landRepo)
    {
        $landen = [];
        $landResult = [];
        $i = 0;
        // kijg alle Landen die zijn opgeslagen
        $result = $landRepo->findAll();

        foreach($result as $key => $value) {
            if ($i == 0) {
                $landen['Voeg een Land toe'] = '';
            }
            // zet array voor form zodat hij een select er mee kan maken
            $newkey = $value->getNaam() . " id(" . $value->getId() . ")";
            $landen[$newkey] = $value->getId();

            $landResult[$value->getId()] = $value->getNaam();
            $i++;
        }

        $this->landResult = $landResult;
        $this->landen = $landen;
        $this->landRepo = $landRepo;
    }


    /**
     * @Route("/", name="poule_index", methods={"GET"})
     */
    public function index(PouleRepository $pouleRepository): Response
    {
        return $this->render('poule/index.html.twig', [
            'poules' => $pouleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="poule_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $poule = new Poule();
        $form = $this->createForm(PouleType::class, $poule, [
            'landen' => $this->landRepo,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($poule);
            $entityManager->flush();

            return $this->redirectToRoute('poule_index');
        }

        return $this->render('poule/new.html.twig', [
            'poule' => $poule,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="poule_show", methods={"GET"})
     */
    public function show(Poule $poule): Response
    {

//        $poule->setLand1($this->landResult[$poule->getLand1()]);

        return $this->render('poule/show.html.twig', [
            'poule' => $poule,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="poule_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Poule $poule): Response
    {
        $form = $this->createForm(PouleType::class, $poule, [
        'landen' => $this->landen,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

    public function addLand() {

    }
}
