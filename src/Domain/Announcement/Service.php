<?php

namespace App\Domain\Announcement;

use App\Domain\Repository\Announcement;

class Service
{
    /**
     * @var Announcement
     */
    private Announcement $repository;

    public function __construct(
        Announcement $repository
    ) {
        $this->repository = $repository;
    }
}