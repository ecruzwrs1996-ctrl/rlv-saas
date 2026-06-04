<?php

namespace App\Controllers;

use App\Services\RLVActiveUsersService;

class RLVActiveUsersController extends BaseApiController
{
    protected RLVActiveUsersService $service;

    public function __construct()
    {
        $this->service =
            new RLVActiveUsersService();
    }

    /**
     * Dashboard realtime
     */
    public function dashboard()
    {
        try {

            $data =
                $this->service
                    ->dashboardData();

            return $this->successResponse(

                'Realtime dashboard loaded',

                $data
            );

        } catch (\Throwable $e) {

            return $this->errorResponse(

                $e->getMessage(),

                null,

                500
            );
        }
    }

    /**
     * Usuarios online
     */
    public function onlineUsers()
    {
        try {

            $data =
                $this->service
                    ->activeUsers();

            return $this->successResponse(

                'Online users loaded',

                $data
            );

        } catch (\Throwable $e) {

            return $this->errorResponse(

                $e->getMessage(),

                null,

                500
            );
        }
    }
}