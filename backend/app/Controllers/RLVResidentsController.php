<?php

namespace App\Controllers;

use App\Services\RLVResidentsService;

class RLVResidentsController extends BaseApiController
{
    protected RLVResidentsService $service;

    public function __construct()
    {
        $this->service = new RLVResidentsService();
    }

    /**
     * List residents
     */
    public function index()
{
    /**
     * Pagination
     */

    $pagination = $this->getPaginationParams();

    /**
     * Filters
     */

    $filters = [

        'resident_name' =>

            $this->request->getGet(
                'resident_name'
            ),

        'owner_name' =>

            $this->request->getGet(
                'owner_name'
            ),

        'Id_street' =>

            $this->request->getGet(
                'Id_street'
            ),

        'status' =>

            $this->request->getGet(
                'status'
            )
    ];

    /**
     * Residents
     */

    $data = $this->service->list(

        $pagination['perPage'],

        $pagination['page'],

        $filters
    );

    return $this->successResponse(

        'Residentes obtenidos correctamente',

        $data,

        200,

        [

            'currentPage' => $pagination['page'],

            'perPage' => $pagination['perPage'],

            'total' => $this->service->total()
        ]
    );
}

    /**
     * Show resident
     */
    public function show($id = null)
    {
        $resident = $this->service->getById((int)$id);

        if (!$resident) {

            return $this->errorResponse(

                'Residente no encontrado',
                null,
                404

            );
        }

        return $this->successResponse(

            'Residente obtenido correctamente',

            $resident

        );
    }

    /**
     * Create resident
     */
    public function create()
    {
        $rules = [

            'Id_street'     => 'required|integer',

            'house_number'  => 'required|max_length[20]',

            'resident_name' => 'required|max_length[150]',

            'status'        => 'required|in_list[ACTIVE,INACTIVE,SUSPENDED]'

        ];

        $validation = $this->validateRequest($rules);

        if ($validation !== true) {

            return $validation;
        }

        $data = $this->request->getJSON(true);

        $data['created_by'] = $this->authUser->Id_user ?? null;

        $result = $this->service->create($data);

        if (!$result['success']) {

            return $this->errorResponse(

                $result['message'],
                null,
                400

            );
        }

        /**
         * Audit
         */
        $this->audit(

            'CREATE',

            'RLV_Residents',

          'Residente creado: ' . $data['resident_name']

        );

        return $this->successResponse(

            'Residente creado correctamente',

            [

                'Id_resident' => $result['id']

            ],

            201

        );
    }

    /**
     * Update resident
     */
    public function update($id = null)
    {
        $resident = $this->service->getById((int)$id);

        if (!$resident) {

            return $this->errorResponse(

                'Residente no encontrado',
                null,
                404

            );
        }

        $data = $this->request->getJSON(true);

        $result = $this->service->update(

            (int)$id,
            $data

        );

        if (!$result['success']) {

            return $this->errorResponse(

                $result['message'],
                null,
                400

            );
        }

        /**
         * Audit
         */
        $this->audit(

            'UPDATE',

            'RLV_Residents',

           'Residente actualizado: ' . $resident['resident_name']

        );

        return $this->successResponse(

            'Residente actualizado correctamente'

        );
    }

    /**
     * Delete resident
     */
    public function delete($id = null)
    {
        $resident = $this->service->getById((int)$id);

        if (!$resident) {

            return $this->errorResponse(

                'Residente no encontrado',
                null,
                404

            );
        }

        $result = $this->service->delete((int)$id);

        if (!$result['success']) {

            return $this->errorResponse(

                $result['message'],
                null,
                400

            );
        }

        /**
         * Audit
         */
        $this->audit(

            'DELETE',

            'RLV_Residents',

            'Residente eliminado: ' . $resident['resident_name']

        );

        return $this->successResponse(

            'Residente eliminado correctamente'

        );
    }
}