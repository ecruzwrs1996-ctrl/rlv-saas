<?php

namespace App\Controllers;

use App\Services\RLVDashboardService;

class RLVDashboardController
extends BaseApiController
{
    protected RLVDashboardService
        $service;

    public function __construct()
    {
        $this->service =
            new RLVDashboardService();
    }

    /**
     * Dashboard stats
     */
    public function stats()
    {
        return $this->successResponse(

            'Dashboard stats obtenidos',

            $this->service->stats()
        );
    }

    /**
     * Recent activity
     */
    public function activity()
    {
        return $this->successResponse(

            'Actividad obtenida',

            $this->service->activity()
        );
    }



    /**
 * Activity timeline
 */
public function activityTimeline()
{
    return $this->successResponse(

        'Timeline obtenido',

        $this->service->activityTimeline()
    );
}


}