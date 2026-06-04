<?php

namespace App\Repositories;

use Config\Database;

class RLVAuditRepository
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Obtener auditoría con filtros
     */
    
public function getAuditLogs(
    array $filters = [],
    int $page = 1,
    int $perPage = 10
): array {

    /**
     * Base query
     */
    $builder = $this->db->table(
        'rlv_users_sessions us'
    );

    /**
     * Select
     */
    $builder->select('
        us.Id_usr_session,
        us.Id_user AS session_user_id,
        us.token,
        us.login_at,
        us.logout_at,
        us.is_active,

        al.Id_log,

        aa.Id_aud_action,
        aa.table_name,
        aa.action_type,
        aa.description,
        aa.created_at,

        u.Id_user,
        u.username,
        u.name,
        u.Role_id,

        r.name AS role_name
    ');

    /**
     * Joins
     */
    $builder->join(
        'rlv_audit_logs al',
        'al.Id_usr_session = us.Id_usr_session',
        'left'
    );

    $builder->join(
        'rlv_audit_actions aa',
        'aa.Id_log = al.Id_log',
        'left'
    );

    $builder->join(
        'rlv_users u',
        'u.Id_user = us.Id_user',
        'left'
    );

    $builder->join(
        'rlv_roles r',
        'r.Id_role = u.Role_id',
        'left'
    );

    /**
     * Filters
     */

    /**
     * Start date
     */
    if (!empty($filters['start_date'])) {

        $builder->where(
            'DATE(us.login_at) >=',
            $filters['start_date']
        );
    }

    /**
     * End date
     */
    if (!empty($filters['end_date'])) {

        $builder->where(
            'DATE(us.login_at) <=',
            $filters['end_date']
        );
    }

    /**
     * Username
     */
    if (!empty($filters['username'])) {

        $builder->groupStart();

        $builder->like(
            'u.username',
            $filters['username']
        );

        $builder->orLike(
            'u.name',
            $filters['username']
        );

        $builder->groupEnd();
    }

    /**
     * Role
     */
    if (!empty($filters['Role_id'])) {

        $builder->where(
            'u.Role_id',
            $filters['Role_id']
        );
    }

    /**
     * Role name
     */
    if (!empty($filters['role_name'])) {

        $builder->where(
            'r.name',
            $filters['role_name']
        );
    }

    /**
     * Module
     */
    if (!empty($filters['module'])) {

        $builder->like(
            'aa.table_name',
            $filters['module']
        );
    }

    /**
     * Action
     */
    if (!empty($filters['action_type'])) {

        $builder->where(
            'aa.action_type',
            $filters['action_type']
        );
    }

    /**
     * Global search
     */
    if (!empty($filters['search'])) {

        $builder->groupStart();

        $builder->like(
            'u.username',
            $filters['search']
        );

        $builder->orLike(
            'u.name',
            $filters['search']
        );

        $builder->orLike(
            'aa.description',
            $filters['search']
        );

        $builder->groupEnd();
    }

    /**
     * Order
     */
    $builder->orderBy(
        'us.login_at',
        'DESC'
    );

    /**
     * Count
     */
    $countBuilder = clone $builder;

    $total = $countBuilder
        ->countAllResults(false);

    /**
     * Pagination
     */
    $offset = ($page - 1) * $perPage;

    $builder->limit(
        $perPage,
        $offset
    );

    $data = $builder
        ->get()
        ->getResultArray();

    return [

        'data' => $data,

        'pagination' => [

            'page' => $page,

            'perPage' => $perPage,

            'total' => $total,

            'totalPages' => ceil(
                $total / $perPage
            )
        ]
    ];
}


    /**
     * Export completo auditoría
     */
    public function exportAuditData(): array
    {
        return [

            'audit_actions' => $this->db
                ->table('rlv_audit_actions')
                ->get()
                ->getResultArray(),

            'audit_logs' => $this->db
                ->table('rlv_audit_logs')
                ->get()
                ->getResultArray(),

            'users_sessions' => $this->db
                ->table('rlv_users_sessions')
                ->get()
                ->getResultArray(),

            'users' => $this->db
                ->table('rlv_users')
                ->get()
                ->getResultArray()
        ];
    }

    /**
     * Purge auditoría
     */
    public function purgeAuditTables(): bool
    {
        /**
         * Fecha límite:
         * solo eliminar días anteriores
         */
        $purgeDate = date('Y-m-d');

        /**
         * Disable FK checks
         */
        $this->db->query(
            'SET FOREIGN_KEY_CHECKS = 0'
        );

        /**
         * Eliminar audit actions
         */
        $this->db
            ->table('rlv_audit_actions')
            ->where(
                'created_at <',
                $purgeDate . ' 00:00:00'
            )
            ->delete();

        /**
         * Eliminar audit logs
         */
        $this->db
            ->table('rlv_audit_logs')
            ->where(
                'created_at <',
                $purgeDate . ' 00:00:00'
            )
            ->delete();

        /**
         * Eliminar sesiones antiguas
         */
        $this->db
            ->table('rlv_users_sessions')
            ->where(
                'login_at <',
                $purgeDate . ' 00:00:00'
            )
            ->delete();

        /**
         * Enable FK checks
         */
        $this->db->query(
            'SET FOREIGN_KEY_CHECKS = 1'
        );

        return true;
    }

    /**
     * Obtener log activo por sesión
     */
    public function getActiveLogBySessionId(
        int $sessionId
    ): ?array {

        return $this->db

            ->table('rlv_audit_logs')

            ->where(
                'Id_usr_session',
                $sessionId
            )

            ->where(
                'logout_at',
                null
            )

            ->get()

            ->getRowArray();
    }

    /**
     * Obtener datos completos para export Excel
     */
    public function getAuditExportData(): array
    {
        return $this->db
            ->table('rlv_audit_actions aa')

            ->select('
                u.name,
                u.username,

                r.name AS role_name,
                r.description AS role_description,

                us.token,
                us.login_at,
                us.logout_at,

                aa.table_name,
                aa.action_type,
                aa.description,
                aa.created_at
            ')

            ->join(
                'rlv_audit_logs al',
                'al.Id_log = aa.Id_log',
                'left'
            )

            ->join(
                'rlv_users_sessions us',
                'us.Id_usr_session = al.Id_usr_session',
                'left'
            )

            ->join(
                'rlv_users u',
                'u.Id_user = al.Id_user',
                'left'
            )

            ->join(
                'rlv_roles r',
                'r.Id_role = u.Role_id',
                'left'
            )

            ->orderBy(
                'aa.created_at',
                'DESC'
            )

            ->get()

            ->getResultArray();
    }

    /**
     * Obtener tablas completas auditoría
     */
    public function getFullAuditBackupData(): array
    {
        return [

            'rlv_users_sessions' => $this->db
                ->table('rlv_users_sessions')
                ->get()
                ->getResultArray(),

            'rlv_audit_logs' => $this->db
                ->table('rlv_audit_logs')
                ->get()
                ->getResultArray(),

            'rlv_audit_actions' => $this->db
                ->table('rlv_audit_actions')
                ->get()
                ->getResultArray()
        ];
    }
}