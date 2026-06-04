<?php

namespace App\Repositories;

use App\Models\RLVRolesModel;

class RLVRolesRepository
{
    protected RLVRolesModel $model;

    public function __construct()
    {
        $this->model =
            new RLVRolesModel();
    }

    /**
     * Get active roles
     */
    public function getAll(): array
    {
        return $this->model

            ->where(
                'status',
                'A'
            )

            ->orderBy(
                'Id_role',
                'ASC'
            )

            ->findAll();
    }

    /**
     * Get role by id
     */
    public function getById(
        int $id
    ): ?array {

        return $this->model
            ->find($id);
    }

    /**
     * Create role
     */
    public function create(
        array $data
    ): bool {

        return $this->model
            ->insert($data);
    }

    /**
     * Update role
     */
    public function update(
        int $id,
        array $data
    ): bool {

        return $this->model
            ->update(
                $id,
                $data
            );
    }

    /**
     * Soft delete role
     */
    public function softDelete(
        int $id
    ): bool {

        return $this->model
            ->update(
                $id,
                [

                    'status' => 'I',

                    'deleted_at' =>
                        date(
                            'Y-m-d H:i:s'
                        )
                ]
            );
    }
}