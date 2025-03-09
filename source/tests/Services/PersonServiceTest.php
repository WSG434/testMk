<?php
declare(strict_types=1);

namespace App\Tests\Services;

use App\Repository\PersonRepository;
use PHPUnit\Framework\TestCase;

class PersonServiceTest extends TestCase
{
    protected function setUp(): void
    {
        $this->personRepository = $this->createMock(PersonRepository::class);
    }

}
