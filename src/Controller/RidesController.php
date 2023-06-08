<?php

namespace App\Controller;

use App\Form\RidesType;
use App\Repository\RideRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Ride;


#[Route('rides')]
class RidesController extends AbstractController
{
    #[Route('/', name: 'app_rides')]
    public function rides(EntityManagerInterface $entityManager): Response
    {
        $ridesrepository = $entityManager->getRepository(Ride::class);
        $rides = $ridesrepository->findAll();

        $pageTitle = 'Toutes les offres';

        return $this->render('rides/rides.html.twig', [
            'controller_name' => 'RidesController',
            'page_title' => $pageTitle,
            'rides' => $rides
        ]);
    }

    #[Route('/details/{id}', name: 'app_ride')]
    public function ride(RideRepository $rideRepository, int $id): Response
    {
        $ride = $rideRepository->find($id);

        if (!$ride) {
            throw $this->createNotFoundException('Aucun trajet trouvé avec l\'id ' . $id);
        }

        $pageTitle = 'Détails du trajet #' . $id;

        return $this->render('rides/rideDetails.html.twig', [
            'controller_name' => 'RidesController',
            'page_title' => $pageTitle,
            'ride' => $ride,
        ]);
    }

    #[Route('/addride', name: 'app_add_ride')]
    public function addRide(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $ride = new Ride();
        $pageTitle = 'Proposer un trajet';
        $addRideForm = $this->createForm(RidesType::class, $ride);
        $addRideForm->handleRequest($request);

        if ($addRideForm->isSubmitted() && !$addRideForm->isValid()) {

            $ride->setDriver($this->getUser());

            $entityManager->persist($ride);
            $entityManager->flush();

            return $this->redirectToRoute('app_ride', ['id' => $ride->getId()]);
        }

        return $this->render('rides/addRide.html.twig', [
            'controller_name' => 'RidesController',
            'page_title' => $pageTitle,
            'addRideForm' => $addRideForm
        ]);
    }


    #[Route('/ride/delete/{id}', name: 'app_ride_delete')]
    public function index(EntityManagerInterface $entityManager, int $id): Response
    {
        // Récupérer le répertoire de l'entité Product
        $repository = $entityManager->getRepository(Ride::class);

        // Cherche un produit grâce à sa primary key
        // La variable $id est issue du paramètre de l'url, voir l'attribut Route de la fonction
        $ride = $repository->find($id);

        // On vérifie que l'on a bien récupéré un produit en base de données,
        // si ce n'est pas le cas il n'y a pas de produit à modifier et l'on retourne une erreur à l'utilisateur
        if (!$ride) {
            throw $this->createNotFoundException(
                'No ride found for id ' . $id
            );
        }

        // Supprime le produit et persiste les changements
        $entityManager->remove($ride);
        $entityManager->flush();

        return $this->redirectToRoute('app_rides');
    }

    #[Route('/ride/{id}/edit', name: 'app_ride_edit')]
    public function editRide(Request $request, EntityManagerInterface $entityManager, Ride $ride): Response
    {
        $pageTitle = 'Modifier le trajet #' . $ride->getId();
        $editRideForm = $this->createForm(RidesType::class, $ride);
        $editRideForm->handleRequest($request);

        if ($editRideForm->isSubmitted() && $editRideForm->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ride', ['id' => $ride->getId()]);
        }

        return $this->render('rides/editRide.html.twig', [
            'controller_name' => 'RidesController',
            'page_title' => $pageTitle,
            'editRideForm' => $editRideForm->createView()
        ]);
    }

}