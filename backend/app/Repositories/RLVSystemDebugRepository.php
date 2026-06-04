<?php

namespace App\Repositories;

use Config\Database;

class RLVSystemDebugRepository
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Registrar debug purge
     */
    public function create(array $data): bool
    {
        return $this->db
            ->table('rlv_system_debugs')
            ->insert($data);
    }
}