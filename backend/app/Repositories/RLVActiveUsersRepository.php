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
                RLV_Users_Sessions.Id_usr_session,
                RLV_Users_Sessions.login_at,

                RLV_Users.Id_user,
                RLV_Users.username,
                RLV_Users.name,
                RLV_Users.email,
                RLV_Users.Role_id
            ')

            ->join(
                'RLV_Users',
                'RLV_Users.Id_user =
                RLV_Users_Sessions.Id_user'
            )

            ->where(
                'RLV_Users_Sessions.is_active',
                1
            )

            ->orderBy(
                'RLV_Users_Sessions.login_at',
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
            RLV_Users.username,
            COUNT(*) as total_logins
        ')

        ->join(
            'RLV_Users',
            'RLV_Users.Id_user =
            RLV_Users_Sessions.Id_user'
        )

        ->where(
            'RLV_Users_Sessions.login_at >=',
            date('Y-m-d 00:00:00')
        )

        ->where(
            'RLV_Users_Sessions.login_at <=',
            date('Y-m-d 23:59:59')
        )

        ->groupBy(
            'RLV_Users.username'
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
            RLV_Users.username,

            COUNT(RLV_Users_Sessions.Id_usr_session)
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
            'RLV_Users',
            'RLV_Users.Id_user =
            RLV_Users_Sessions.Id_user'
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
            'RLV_Users.username'
        )

        ->findAll();
}

}