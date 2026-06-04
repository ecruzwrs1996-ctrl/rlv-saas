<?php

namespace App\Repositories;

use App\Models\RLVUsersSessionsModel;

class RLVActiveUsersRepository
{
    protected RLVUsersSessionsModel $model;

    public function __construct()
    {
        $this->model =
            new RLVUsersSessionsModel();
    }

    /**
     * Crear sesión login
     */
    public function createSession(
        array $data
    ) {

        return $this->model->insert($data);
    }

    /**
     * Usuarios online
     */
    public function getOnlineUsers()
    {
        return $this->model

            ->select('
                rlv_users_sessions.Id_usr_session,
                rlv_users_sessions.login_at,

                rlv_users.Id_user,
                rlv_users.username,
                rlv_users.name,
                rlv_users.email,
                rlv_users.Role_id
            ')

            ->join(
                'rlv_users',
                'rlv_users.Id_user =
                rlv_users_sessions.Id_user'
            )

            ->where(
                'rlv_users_sessions.is_active',
                1
            )

            ->orderBy(
                'rlv_users_sessions.login_at',
                'DESC'
            )

            ->findAll();
    }

 
/**
 * Login chart today
 */
public function getTodayLoginsChart()
{
    return $this->model

        ->select('
            rlv_users.username,
            COUNT(*) as total_logins
        ')

        ->join(
            'rlv_users',
            'rlv_users.Id_user =
            rlv_users_sessions.Id_user'
        )

        ->where(
            'rlv_users_sessions.login_at >=',
            date('Y-m-d 00:00:00')
        )

        ->where(
            'rlv_users_sessions.login_at <=',
            date('Y-m-d 23:59:59')
        )

        ->groupBy(
            'rlv_users.username'
        )

        ->findAll();
}



    /**
     * Dashboard stats
     */
    public function getDashboardStats()
{
    /**
     * Online users
     */
    $onlineUsers = $this->model

        ->builder()

        ->where('is_active', 1)

        ->countAllResults();

    /**
     * Total logins today
     */
    $loginsToday = $this->model

        ->builder()

      
->where(
    'login_at >=',
    date('Y-m-d 00:00:00')
)

->where(
    'login_at <=',
    date('Y-m-d 23:59:59')
)


        ->countAllResults();

    /**
     * Active users today
     */
    $activeUsersToday = $this->model

        ->builder()

        ->select(
            'COUNT(DISTINCT Id_user) as total'
        )

        ->where(
    'login_at >=',
    date('Y-m-d 00:00:00')
)

->where(
    'login_at <=',
    date('Y-m-d 23:59:59')
)

        ->get()

        ->getRowArray();

    /**
     * Closed sessions today
     */
    $closedSessions = $this->model

        ->builder()

 ->where(
    'login_at >=',
    date('Y-m-d 00:00:00')
)

->where(
    'login_at <=',
    date('Y-m-d 23:59:59')
)      
       

        ->where(
            'logout_at IS NOT NULL',
            null,
            false
        )

        ->countAllResults();

    return [

        'online_users' =>
            $onlineUsers,

        'logins_today' =>
            $loginsToday,

        'active_users_today' =>
            $activeUsersToday['total']
                ?? 0,

        'closed_sessions' =>
            $closedSessions
    ];
}

    /**
     * Logout
     */
    public function logoutSession(
        int $sessionId
    ) {

        return $this->model

            ->update($sessionId, [

                'logout_at' =>
                    date('Y-m-d H:i:s'),

                'is_active' => 0
            ]);
    }


/**
 * Activity timeline today
 */
public function getTodayActivityTimeline()
{
    return $this->model

        ->select('
            rlv_users.username,

            COUNT(rlv_users_sessions.Id_usr_session)
                as total_sessions,

            SUM(

                TIMESTAMPDIFF(

                    MINUTE,

                    login_at,

                    IFNULL(
                        logout_at,
                        NOW()
                    )
                )

            ) as total_minutes,

            MAX(login_at)
                as last_login,

            MAX(logout_at)
                as last_logout,

            MAX(is_active)
                as is_online
        ')

        ->join(
            'rlv_users',
            'rlv_users.Id_user =
            rlv_users_sessions.Id_user'
        )

        ->where(
            'login_at >=',
            date('Y-m-d 00:00:00')
        )

        ->where(
            'login_at <=',
            date('Y-m-d 23:59:59')
        )

        ->groupBy(
            'rlv_users.username'
        )

        ->findAll();
}

}