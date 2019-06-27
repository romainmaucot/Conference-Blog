<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\ConferenceRepository;
use App\Repository\RatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/statistic")
 */
class StatisticController extends AbstractController
{
    /**
     * @Route("/", name="statistic_index", methods={"GET"})
     */
    public function index(RatingRepository $ratingRepository): Response
    {

        return $this->render('statistic/index.html.twig', [
            'rates' => $ratingRepository->getAverageConference(),
        ]);
    }
}