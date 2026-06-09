<?php

namespace App\Controllers;

use App\Services\RLVUsersService;
use App\Validators\RLVUsersValidator;

class RLVUsersController extends BaseApiController
{
    protected RLVUsersService $service;

    public function __construct()
    {
        $this->service = new RLVUsersService();
    }

    /**
     * Listado usuarios
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
            ),

        'Role_id' =>

            $this->request->getGet(
                'Role_id'
            )
    ];

    /**
     * Users
     */

    $result = $this->service->getUsers(

    $pagination['page'],

    $pagination['perPage'],

    $filters,

    $this->authUser
);

    /**
     * Hide passwords
     */

    foreach (

        $result['data']

        as &$user

    ) {

        unset($user['password']);
    }

    return $this->successResponse(

        'Usuarios obtenidos correctamente',

        $result['data'],

        200,

        $result['pagination']
    );
}

    /**
     * Detalle usuario
     */
    public function show($id = null)
    {
        $user = $this->service->getUser((int)$id);

        if (!$user) {

            return $this->errorResponse(
                'Usuario no encontrado',
                null,
                404
            );
        }

        unset($user['password']);

        return $this->successResponse(
            'Usuario obtenido correctamente',
            $user
        );
    }

    /**
     * Crear usuario
     */
    public function create()
    {
        $validation = $this->validateRequest(
    RLVUsersValidator::create()
);

        if ($validation !== true) {

            return $validation;
        }

        $data = $this->request->getJSON(true);

        $id = $this->service->createUser($data);

        /**
         * Audit
         */
        $this->audit(
            'CREATE',
            'RLV_Users',
            "Usuario creado" . $data['username']
        );

        return $this->successResponse(
            'Usuario creado correctamente',
            [
                'Id_user' => $id
            ],
            201
        );
    }

    /**
     * Actualizar usuario
     */
    public function update($id = null)
    {
        $user = $this->service->getUser((int)$id);

        if (!$user) {

            return $this->errorResponse(
                'Usuario no encontrado',
                null,
                404
            );
        }

        $validation = $this->validateRequest(
    RLVUsersValidator::update((int)$id)
        );

    if ($validation !== true) {

    return $validation;
                                }
        $data = $this->request->getJSON(true);

        $this->service->updateUser(
            (int)$id,
            $data
        );

        /**
         * Audit
         */
        $this->audit(
            'UPDATE',
            'RLV_Users',
            "Usuario actualizado: {$user['username']}"
        );

        return $this->successResponse(
            'Usuario actualizado correctamente'
        );
    }

    /**
     * Eliminar usuario
     */
    public function delete($id = null)
    {
        $user = $this->service->getUser((int)$id);

        if (!$user) {

            return $this->errorResponse(
                'Usuario no encontrado',
                null,
                404
            );
        }

        $this->service->deleteUser((int)$id);

        /**
         * Audit
         */
        $this->audit(
            'DELETE',
            'RLV_Users',
            "Usuario eliminado: {$user['username']}"
        );

        return $this->successResponse(
            'Usuario eliminado correctamente'
        );
    }
}