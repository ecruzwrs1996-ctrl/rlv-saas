<?php

namespace App\Repositories;

use Config\Database;
use App\Repositories\RLVActiveUsersRepository;

class RLVDashboardRepository
{
    protected $db;
     protected RLVActiveUsersRepository $activeUsersRepository;

    public function __construct()
    {
        $this->db = Database::connect();


        $this->activeUsersRepository =
        new RLVActiveUsersRepository();

    }

    /**
     * Total residents
     */
    public function totalResidents(): int
    {
        return $this->db
            ->table('rlv_residents')
            ->where('deleted_at', null)
            ->countAllResults();
    }

    /**
     * Total streets
     */
    public function totalStreets(): int
    {
        return $this->db
            ->table('rlv_streets')
            ->where('deleted_at', null)
            ->countAllResults();
    }

    /**
     * Total users
     */
    public function totalUsers(): int
    {
        return $this->db
            ->table('rlv_users')
            ->where('deleted_at', null)
            ->countAllResults();
    }

    /**
     * Active guards
     */
    public function activeGuards(): int
    {
        return $this->db
            ->table('rlv_users')
            ->where('Role_id', 3)
            ->where('status', 'ACTIVE')
            ->where('deleted_at', null)
            ->countAllResults();
    }

        /**
     * Users distribution
     */
    public function usersDistribution(): array
    {
        /**
         * SYS
         */
        $sys = $this->db
            ->table('rlv_users')
            ->where('Role_id', 1)
            ->where('status', 'ACTIVE')
            ->where('deleted_at', null)
            ->countAllResults();

        /**
         * ADM
         */
        $adm = $this->db
            ->table('rlv_users')
            ->where('Role_id', 2)
            ->where('status', 'ACTIVE')
            ->where('deleted_at', null)
            ->countAllResults();

        /**
         * GUA
         */
        $gua = $this->db
            ->table('rlv_users')
            ->where('Role_id', 3)
            ->where('status', 'ACTIVE')
            ->where('deleted_at', null)
            ->countAllResults();

        return [

            [
                'role' => 'SYS',
                'label' => 'Full Access',
                'total' => $sys
            ],

            [
                'role' => 'ADM',
                'label' => 'Streets, Residents, Directory, Audit',
                'total' => $adm
            ],

            [
                'role' => 'GUA',
                'label' => 'Directory',
                'total' => $gua
            ]
        ];
    }

    /**
     * Recent activity
     */
    public function recentActivity(
        int $limit = 10
    ): array {

        return $this->db
            ->table('rlv_audit_actions')
            ->select('
                Id_aud_action,
                table_name,
                action_type,
                description,
                created_at
            ')
            ->orderBy(
                'created_at',
                'DESC'
            )
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    /**
     * Dashboard stats
     */
    public function getStats(): array
    {
        return [

            'totalResidents' =>
                $this->totalResidents(),

            'totalStreets' =>
                $this->totalStreets(),

            'totalUsers' =>
                $this->totalUsers(),

            'activeGuards' =>
    $this->activeGuards(),

'rolesDistribution' =>
    $this->usersDistribution()
        ];
    }


/**
 * Activity timeline today
 */
/**
 * Activity timeline today
 */
public function activityTimeline(): array
{
    return $this->db

        ->table('rlv_users_sessions')

        ->select("
            rlv_users.username,

            ROUND(
                SUM(
                    CASE

                        WHEN rlv_users_sessions.logout_at IS NOT NULL

                        THEN TIMESTAMPDIFF(
                            MINUTE,
                            rlv_users_sessions.login_at,
                            rlv_users_sessions.logout_at
                        )

                        ELSE TIMESTAMPDIFF(
                            MINUTE,
                            rlv_users_sessions.login_at,
                            NOW()
                        )

                    END
                ) / 60,
                2
            ) AS total_hours
        ")

        ->join(
            'rlv_users',
            'rlv_users.Id_user =
             rlv_users_sessions.Id_user'
        )

        ->where(
            'DATE(rlv_users_sessions.login_at)',
            date('Y-m-d')
        )

        ->groupBy(
            'rlv_users.username'
        )

        ->having(
            'total_hours >',
            0
        )

        ->orderBy(
            'total_hours',
            'DESC'
        )

        ->get()

        ->getResultArray();
}


}