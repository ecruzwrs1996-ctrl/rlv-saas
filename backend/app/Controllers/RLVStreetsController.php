<?php

namespace App\Controllers;

use App\Services\RLVStreetsService;

class RLVStreetsController extends BaseApiController
{
    protected RLVStreetsService $service;

    public function __construct()
    {
        $this->service = new RLVStreetsService();
    }

    /**
     * Listar calles
     */
    public function index()
{
    /**
     * Pagination
     */

    $pagination =
        $this->getPaginationParams();

    /**
     * Filters
     */

    $filters = [

        'search' =>

            $this->request->getGet(
                'search'
            )
    ];

    /**
     * Data
     */

    $data = $this->service->list(

        $pagination['perPage'],

        $pagination['page'],

        $filters
    );

    /**
     * Total
     */

    $total =
        $this->service->total();

    return $this->successResponse(

        'Calles obtenidas correctamente',

        $data,

        200,

        [

            'currentPage' =>
                $pagination['page'],

            'perPage' =>
                $pagination['perPage'],

            'total' =>
                $total,

            'lastPage' =>
                ceil(
                    $total /
                    $pagination['perPage']
                )
        ]
    );
}

    /**
     * Obtener calle por ID
     */
    public function show($id = null)
    {
        $street = $this->service->getById((int)$id);

        if (!$street) {

            return $this->errorResponse(
                'Calle no encontrada',
                null,
                404
            );
        }

        return $this->successResponse(

            'Calle obtenida correctamente',

            $street

        );
    }

    /**
     * Crear calle
     */
    public function create()
    {
        $rules = [

            'name' => 'required|min_length[2]|max_length[150]'

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

            'RLV_Streets',

           'Calle creada: ' . $data['name']

        );

        return $this->successResponse(

            'Calle creada correctamente',

            [

                'Id_street' => $result['id']

            ],

            201

        );
    }

    /**
     * Actualizar calle
     */
    public function update($id = null)
    {
        $street = $this->service->getById((int)$id);

        if (!$street) {

            return $this->errorResponse(

                'Calle no encontrada',
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

            'RLV_Streets',

           'Calle actualizada: ' . $street['name']

        );

        return $this->successResponse(

            'Calle actualizada correctamente'

        );
    }

    /**
     * Eliminar calle
     */
    public function delete($id = null)
    {
        $street = $this->service->getById((int)$id);

        if (!$street) {

            return $this->errorResponse(

                'Calle no encontrada',
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

            'RLV_Streets',

            'Calle eliminada: ' . $street['name']

        );

        return $this->successResponse(

            'Calle eliminada correctamente'

        );
    }
}