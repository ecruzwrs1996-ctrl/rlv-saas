<?php

namespace App\Repositories;

use App\Models\RLVAuditActionsModel;

class RLVAuditActionsRepository
{
    protected RLVAuditActionsModel $model;

    public function __construct()
    {
        $this->model = new RLVAuditActionsModel();
    }

    /**
     * Crear acción auditoría
     */
    public function create(array $data)
    {
        return $this->model->insert($data);
    }
}