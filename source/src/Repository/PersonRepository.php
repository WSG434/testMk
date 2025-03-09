<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Person>
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function clear()
    {
        return  $this->createQueryBuilder('q')
            ->delete()
            ->getQuery()
            ->execute();
    }

    public function getPopulation(): array
    {
        $people = $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();
        if (empty($people)) {
            return [];
        }
        $yearData = [];
        foreach ($people as $person) {
            $birthYear = (int) $person->getBirthDate()->format('Y');
            $deathYear = (int) $person->getDeathDate()->format('Y');
            for ($year = $birthYear; $year <= $deathYear; $year++) {
                if (!isset($yearData[$year])) {
                    $yearData[$year] = ['count' => 0, 'persons' => []];
                }
                $yearData[$year]['count']++;
                $yearData[$year]['persons'][] = $person;
            }
        }
        if (empty($yearData)) {
            return [];
        }
        $maxCount = max(array_column($yearData, 'count'));
        $population = array_filter($yearData, fn($data) => $data['count'] === $maxCount);
        ksort($population);

        return $population;
    }

}
