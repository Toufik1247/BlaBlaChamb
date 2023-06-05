<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FindRideType;
use App\Entity\Ride;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(FindRideType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $request->getSession()->set('searchData', $data);

            return $this->redirectToRoute('app_show_rides');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
        ]);
    }



    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('components/login.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/foundRides', name: 'app_show_rides')]
    public function showRides(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = $request->getSession()->get('searchData', []);

        $rides = [];
        if (!empty($data)) {
            $ridesrepository = $entityManager->getRepository(Ride::class);
            $rides = $ridesrepository->findByParameters(
                $data['departure'],
                $data['destination'],
                $data['date'],
                $data['seats']
            );
        }

        return $this->render('home/showRides.html.twig', [
            'controller_name' => 'HomeController',
            'rides' => $rides,
        ]);
    }

}