<?php

namespace App\Controller;

use App\Entity\Rule;
use App\Form\AddCarType;
use App\Form\RuleType;
use App\Form\editProfileForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

use App\Entity\Car;


#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    #[Route('/', name: 'app_dashboard')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/addcar', name: 'app_add_car')]
    public function addCar(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $car = new Car();
        $pageTitle = 'Proposer un trajet';
        $addCarForm = $this->createForm(AddCarType::class, $car);
        $addCarForm->handleRequest($request);

        if ($addCarForm->isSubmitted() && $addCarForm->isValid()) {
            $car->setOwner($this->getUser());

            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/car/addCar.html.twig', [
            'controller_name' => 'DashboardController',
            'page_title' => $pageTitle,
            'addCarForm' => $addCarForm
        ]);
    }

    #[Route('/car/delete/{id}', name: 'app_car_delete')]
    public function deleteCar(EntityManagerInterface $entityManager, int $id): Response
    {

        $repository = $entityManager->getRepository(Car::class);

        $car = $repository->find($id);

        if (!$car) {
            throw $this->createNotFoundException(
                'No car found for id ' . $id
            );
        }

        $entityManager->remove($car);
        $entityManager->flush();

        return $this->redirectToRoute('app_dashboard');
    }

    #[Route('/car/{id}/edit', name: 'app_car_edit')]
    public function editCar(Request $request, EntityManagerInterface $entityManager, Car $car): Response
    {
        $pageTitle = 'Modifier le Véhicule #' . $car->getId();
        $editCarForm = $this->createForm(AddCarType::class, $car);
        $editCarForm->handleRequest($request);

        if ($editCarForm->isSubmitted() && $editCarForm->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/car/editCar.html.twig', [
            'controller_name' => 'DashboardController',
            'page_title' => $pageTitle,
            'editCarForm' => $editCarForm->createView()
        ]);
    }

    #[Route('/addrule', name: 'app_add_rule')]
    public function addRule(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $rule = new Rule();
        $pageTitle = 'Ajouter une règle';
        $addRuleForm = $this->createForm(RuleType::class, $rule);
        $addRuleForm->handleRequest($request);

        if ($addRuleForm->isSubmitted() && $addRuleForm->isValid()) {
            $rule->setAuthor($this->getUser());

            $entityManager->persist($rule);
            $entityManager->flush();

            return $this->redirectToRoute('app_dashboard', ['id' => $rule->getId()]);
        }

        return $this->render('dashboard/rule/addRule.html.twig', [
            'controller_name' => 'DashboardController',
            'page_title' => $pageTitle,
            'addRuleForm' => $addRuleForm
        ]);
    }

    #[Route('/rule/delete/{id}', name: 'app_rule_delete')]
    public function deleteRule(EntityManagerInterface $entityManager, int $id): Response
    {

        $repository = $entityManager->getRepository(Rule::class);

        $rule = $repository->find($id);

        if (!$rule) {
            throw $this->createNotFoundException(
                'No rule found for id ' . $id
            );
        }

        $entityManager->remove($rule);
        $entityManager->flush();

        return $this->redirectToRoute('app_dashboard');
    }

    #[Route('/rule/{id}/edit', name: 'app_rule_edit')]
    public function editRule(Request $request, EntityManagerInterface $entityManager, Rule $rule): Response
    {
        $pageTitle = 'Modifier la Règle #' . $rule->getId();
        $editRuleForm = $this->createForm(RuleType::class, $rule);
        $editRuleForm->handleRequest($request);

        if ($editRuleForm->isSubmitted() && $editRuleForm->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/rule/editRule.html.twig', [
            'controller_name' => 'DashboardController',
            'page_title' => $pageTitle,
            'editRuleForm' => $editRuleForm->createView()
        ]);
    }

    #[Route('/edituser', name: 'app_edit_user')]
    public function editProfile(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        /** @var PasswordAuthenticatedUserInterface $user */
        $user = $this->security->getUser();

        $pageTitle = 'Modifier Votre Profil' . $user->getId();
        $editUserForm = $this->createForm(editProfileForm::class, $user);
        $editUserForm->handleRequest($request);

        if ($editUserForm->isSubmitted() && $editUserForm->isValid()) {

            if (!empty($editUserForm['plainPassword']->getData())) {
                $password = $userPasswordHasher->hashPassword($user, $editUserForm['plainPassword']->getData());
                $user->setPassword($password);
            }


            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/profile/editProfile.html.twig', [
            'controller_name' => 'DashboardController',
            'page_title' => $pageTitle,
            'editUserForm' => $editUserForm->createView()
        ]);
    }
}