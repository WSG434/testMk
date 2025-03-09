<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Person;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PersonController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('/', name: 'app_person_index', methods: ['GET'])]
    public function index(PersonRepository $personRepository): Response
    {
        $people = $personRepository->findAll();
        return $this->render('person/index.html.twig', [
            'people' => $people,
        ]);
    }

    #[Route('/generate', name: 'generate_people', methods: ['POST'])]
    public function generate(): Response
    {
        $repo = $this->em->getRepository(Person::class);
        foreach ($repo->findAll() as $person) {
            $this->em->remove($person);
        }
        $this->em->flush();

        for ($i = 0; $i < 10; $i++) {
            $birthYear = rand(1800, 2000);
            $birthDate = new \DateTimeImmutable("$birthYear-01-01");
            $deathYear = rand($birthYear + 20, 2020);
            $deathDate = new \DateTimeImmutable("$deathYear-01-01");
            $person = new Person();
            $person->setBirthDate($birthDate)
                ->setDeathDate($deathDate);
            $this->em->persist($person);
        }
        $this->em->flush();

        $this->addFlash('success', 'Таблица с людьми сгенерирована.');
        return $this->redirectToRoute('app_person_index');
    }

    #[Route('/find', name: 'find_max_years', methods: ['POST'])]
    public function findMaxYears(PersonRepository $personRepository): Response
    {
        $people = $personRepository->findAll();
        $yearData = [];
        foreach ($people as $person) {
            $birthYear = (int)$person->getBirthDate()->format('Y');
            $deathYear = (int)$person->getDeathDate()->format('Y');
            for ($year = $birthYear; $year <= $deathYear; $year++) {
                if (!isset($yearData[$year])) {
                    $yearData[$year] = ['count' => 0, 'persons' => []];
                }
                $yearData[$year]['count']++;
                $yearData[$year]['persons'][] = $person;
            }
        }
        uasort($yearData, function ($a, $b) {
            return $b['count'] <=> $a['count'];
        });
        $topYears = array_slice($yearData, 0, 5, true);

        return $this->render('person/index.html.twig', [
            'people'   => $people,
            'topYears' => $topYears,
        ]);
    }

    #[Route('/clear', name: 'clear_people', methods: ['POST'])]
    public function clear(): Response
    {
        $connection = $this->em->getConnection();
        $connection->executeQuery('TRUNCATE TABLE person');
        return $this->redirectToRoute('app_person_index');
    }
}
