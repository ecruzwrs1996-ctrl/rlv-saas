<?php

namespace App\Services;

use App\Repositories\RLVActiveUsersRepository;

class RLVActiveUsersService
{
    protected RLVActiveUsersRepository $repository;

    public function __construct()
    {
        $this->repository =
            new RLVActiveUsersRepository();
    }

    /**
     * Registrar login
     */
    public function registerLogin(

        int $userId,

        string $token
    ) {

        return $this->repository
            ->createSession([

                'Id_user' => $userId,

                'token' => $token,

                'login_at' =>
                    date('Y-m-d H:i:s'),

                'logout_at' => null,

                'is_active' => 1
            ]);
    }

    /**
     * Usuarios activos
     */
    public function activeUsers()
    {
        return $this->repository
            ->getOnlineUsers();
    }

    /**
     * Dashboard realtime
     */
    public function dashboardData(): array
    {
        return [

            /**
             * KPI stats
             */
            'stats' =>

                $this->repository
                    ->getDashboardStats(),

            /**
             * Online users
             */
            'online_users' =>

                $this->repository
                    ->getOnlineUsers(),

            /**
             * Login chart
             */
            'chart' =>

                $this->repository
                    ->getTodayLoginsChart()
        ];
    }

    /**
     * Logout
     */
    public function logout(
        int $sessionId
    ) {

        return $this->repository
            ->logoutSession($sessionId);
    }
}