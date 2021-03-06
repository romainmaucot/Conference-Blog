<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\ConferenceRepository;
use App\Repository\RatingRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class ConferenceController extends AbstractController
{

    /**
     * @Route("homepage", name="homepage", methods={"GET"})
     */
    public function homepage(ConferenceRepository $conferenceRepository, Request $request, PaginatorInterface $paginator): Response
    {

        $conferences = $conferenceRepository->findAll();


        // Paginate the results of the query
        $conferences = $paginator->paginate(
        // Doctrine Query, not results
            $conferences,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
        return $this->render('conference/homepage.html.twig', [
            'conferences' => $conferences,
        ]);
    }

    /**
     * @Route("admin/conference", name="conference_index", methods={"GET"})
     */
    public function index(ConferenceRepository $conferenceRepository, RatingRepository $ratingRepository): Response
    {
        return $this->render('conference/index.html.twig', [
            'conferences' => $ratingRepository->getAverageConference(),
        ]);
    }

    /**
     * @Route("admin/conference/new", name="conference_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($conference);
            $entityManager->flush();

            return $this->redirectToRoute('conference_index');
        }

        return $this->render('conference/new.html.twig', [
            'conference' => $conference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/conference/{id}", name="conference_show", methods={"GET"})
     */
    public function show(Conference $conference, Request $request, RatingRepository $ratingRepository): Response
    {

        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
            'users' => $ratingRepository->getConferenceUsers($conference->getId()),
        ]);
    }

    /**
     * @Route("admin/conference/{id}/edit", name="conference_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Conference $conference): Response
    {
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conference_index', [
                'id' => $conference->getId(),
            ]);
        }

        return $this->render('conference/edit.html.twig', [
            'conference' => $conference,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/conference/{id}", name="conference_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Conference $conference): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conference->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conference);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conference_index');
    }
}
