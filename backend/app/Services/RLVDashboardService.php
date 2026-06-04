<?php

namespace App\Services;

use App\Repositories\RLVDashboardRepository;

class RLVDashboardService
{
    protected RLVDashboardRepository
        $repository;

    public function __construct()
    {
        $this->repository =
            new RLVDashboardRepository();
    }

    /**
     * Dashboard stats
     */
    public function stats(): array
    {
        return $this->repository
            ->getStats();
    }

    /**
     * Recent activity
     */
    public function activity(): array
    {
        return $this->repository
            ->recentActivity();
    }


/**
 * Activity timeline
 */
public function activityTimeline(): array
{
    return $this->repository
        ->activityTimeline();
}

}