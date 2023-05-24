<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('rides')]
class RidesController extends AbstractController
{
    #[Route('/', name: 'app_rides')]
    public function rides(): Response
    {
        $pageTitle = 'Toutes les offres';
        $rides = ['Trajet1', 'Trajet2', 'Trajet3'];
 
        return $this->render('rides/rides.html.twig', [
            'controller_name' => 'RidesController',
            'page_title' => $pageTitle,
            'rides' => $rides
        ]);
    }

    #[Route('/details', name: 'app_ride')]
    public function ride(): Response
    {
        $pageTitle = 'Détails du trajet';
        return $this->render('rides/rideDetails.html.twig', [
            'controller_name' => 'RidesController',
            'page_title' => $pageTitle
        ]);
    }
}