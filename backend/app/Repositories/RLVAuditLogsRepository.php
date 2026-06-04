<?php

namespace App\Repositories;

use App\Models\RLVAuditLogsModel;

class RLVAuditLogsRepository
{
    protected RLVAuditLogsModel $model;

    public function __construct()
    {
        $this->model = new RLVAuditLogsModel();
    }

    /**
     * Crear log auditoría
     */
    public function create(array $data)
    {
        return $this->model->insert($data);
    }
}