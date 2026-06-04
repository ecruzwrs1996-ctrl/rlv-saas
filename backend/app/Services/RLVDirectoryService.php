<?php

namespace App\Services;

use App\Repositories\RLVDirectoryRepository;

class RLVDirectoryService
{
    protected RLVDirectoryRepository $repository;

    public function __construct()
    {
        $this->repository =
            new RLVDirectoryRepository();
    }

    /**
     * Directory search
     */
    public function search(array $filters)
    {
        return $this->repository
            ->search($filters);
    }

    /**
     * Export directory
     */
    public function export(array $filters)
    {
        return $this->repository
            ->export($filters);
    }
}