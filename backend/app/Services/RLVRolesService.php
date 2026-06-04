<?php

namespace App\Services;

use App\Repositories\RLVRolesRepository;

class RLVRolesService
{
    protected RLVRolesRepository $repository;

    public function __construct()
    {
        $this->repository =
            new RLVRolesRepository();
    }

    /**
     * Get active roles
     */
    public function getAll(): array
    {
        return $this->repository
            ->getAll();
    }

    /**
     * Create role
     */
    public function createRole(
        array $data
    ): bool {

        /**
         * Force uppercase
         */
        $data['name'] = strtoupper(
            trim($data['name'])
        );

        return $this->repository
            ->create([

                'name' =>
                    $data['name'],

                'description' =>
                    $data['description'] ?? null,

                'status' => 'A',

                'created_at' =>
                    date('Y-m-d H:i:s')
            ]);
    }

    /**
     * Update role
     */
    public function updateRole(

        int $id,

        array $data

    ): bool {

        /**
         * Force uppercase
         */
        $data['name'] = strtoupper(
            trim($data['name'])
        );

        return $this->repository
            ->update(
                $id,
                [

                    'name' =>
                        $data['name'],

                    'description' =>
                        $data['description'] ?? null,

                    'updated_at' =>
                        date('Y-m-d H:i:s')
                ]
            );
    }

    /**
     * Soft delete role
     */
    public function deleteRole(
        int $id
    ): bool {

        return $this->repository
            ->softDelete($id);
    }
}