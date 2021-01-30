<?php

declare(strict_types=1);

namespace App\Domain\Registration;

use Doctrine\Common\Persistence\ObjectManager;

class Service
{
    private Repository $repository;
    private ObjectManager $entityManager;

    public function createUser(): void
    {

    }
}
