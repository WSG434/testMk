<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\PersonRepository;
use App\Services\PersonService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PersonController extends AbstractController
{
    #[Route('/', name: 'app_person_index', methods: ['GET'])]
    public function index(PersonRepository $personRepository): Response
    {
        return $this->render('person/index.html.twig', [
            'people' => $personRepository->findAll(),
        ]);
    }

    #[Route('/generate', name: 'generate_people', methods: ['POST'])]
    public function generate(PersonService $personService): Response
    {
        $personService->generate();
        return $this->redirectToRoute('app_person_index');
    }

    #[Route('/find', name: 'find_max_years', methods: ['POST'])]
    public function findMaxYears(PersonRepository $personRepository): Response
    {
        return $this->render('person/index.html.twig', [
            'people'   => $personRepository->findAll(),
            'topYears' => $personRepository->getPopulation(),
        ]);
    }

    #[Route('/clear', name: 'clear_people', methods: ['POST'])]
    public function clear(PersonService $personService): Response
    {
        $personService->clear();
        return $this->redirectToRoute('app_person_index');
    }
}
