<?php

namespace App\Controllers;

use App\Controllers\BaseApiController;

use App\Services\RLVRolesService;

class RLVRolesController
    extends BaseApiController
{
    protected RLVRolesService $service;

    public function __construct()
    {
        $this->service =
            new RLVRolesService();
    }

    /**
     * GET Roles
     */
    public function index()
    {
        try {

            $roles =
                $this->service
                    ->getAll();

            return $this->successResponse(

                'Roles loaded',

                $roles
            );

        } catch (\Throwable $e) {

            return $this->errorResponse(

                $e->getMessage(),

                null,

                500
            );
        }
    }

    /**
     * CREATE Role
     */
   
public function store()
{
    try {

        $data =
            $this->request
                ->getJSON(true);

        $created =
            $this->service
                ->createRole($data);

        if (!$created) {

            return $this->errorResponse(

                'Error creating role',

                null,

                400
            );
        }

        return $this->successResponse(

            'Role created successfully'
        );

    } catch (\Throwable $e) {

        return $this->errorResponse(

            $e->getMessage(),

            null,

            500
        );
    }
}



    /**
     * UPDATE Role
     */
    public function update($id = null)
    {
        try {

            $data = $this->request
                ->getJSON(true);

            $updated =
                $this->service
                    ->updateRole(

                        (int) $id,

                        $data
                    );

            if (!$updated) {

                return $this->errorResponse(

                    'Error updating role',

                    null,

                    400
                );
            }

            return $this->successResponse(

                'Role updated successfully'
            );

        } catch (\Throwable $e) {

            return $this->errorResponse(

                $e->getMessage(),

                null,

                500
            );
        }
    }

    /**
     * SOFT DELETE Role
     */
   public function delete($id = null)
    {
        try {

            $deleted =
                $this->service
                    ->deleteRole(
                        (int) $id
                    );

            if (!$deleted) {

                return $this->errorResponse(

                    'Error deleting role',

                    null,

                    400
                );
            }

            return $this->successResponse(

                'Role deleted successfully'
            );

        } catch (\Throwable $e) {

            return $this->errorResponse(

                $e->getMessage(),

                null,

                500
            );
        }
    }
}