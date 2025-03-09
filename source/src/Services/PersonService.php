<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;

final class PersonService
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function generate()
    {
        for ($i = 0; $i < 10; $i++) {
            $birthYear = rand(1800, 2000);
            $birthMonth = rand(1, 12);
            $birthDay = rand(1, 28); // Оставим 28, чтобы избежать проблем с разными длинами месяцев
            $birthDate = new \DateTimeImmutable("$birthYear-$birthMonth-$birthDay");
            $deathDate = $birthDate->modify('+70 years');
            $person = new Person();
            $person->setBirthDate($birthDate)
                ->setDeathDate($deathDate);
            $this->em->persist($person);
        }
        $this->em->flush();
    }

    public function clear(): void
    {
        $this->em->getRepository(Person::class)->clear();
    }

    public function find(): array
    {
        return $this->em->getRepository(Person::class)->getPopulation();
    }

}