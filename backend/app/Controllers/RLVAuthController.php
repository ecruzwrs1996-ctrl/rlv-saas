<?php

namespace App\Controllers;

use App\Controllers\BaseApiController;
use App\Services\RLVAuthService;

class RLVAuthController extends BaseApiController
{
    protected RLVAuthService $authService;

    public function __construct()
    {
        $this->authService = new RLVAuthService();
    }

    /**
     * Login usuario
     */
    public function login()
    {
        $data = $this->request->getJSON(true);

        if (
            !isset($data['username']) ||
            !isset($data['password'])
        ) {

            return $this->errorResponse(
                'Username y password son requeridos',
                null,
                400
            );
        }

        $response = $this->authService->login(
            $data['username'],
            $data['password']
        );

        if (!$response['success']) {

            return $this->errorResponse(
                $response['message'],
                null,
                401
            );
        }

        return $this->successResponse(
            $response['message'],
            [
                'token' => $response['token'],
                'user'  => $response['user']
            ]
        );
    }

    public function profile()
    {
        return $this->successResponse(
            'Perfil obtenido correctamente',
            $this->request->user
        );
    }


    /**
 * Logout usuario
 */
public function logout()
{
    /**
     * Obtener bearer token
     */
    $authHeader = $this->request->getHeaderLine('Authorization');

    $token = str_replace('Bearer ', '', $authHeader);

    $logout = $this->authService->logout($token);

    if (!$logout) {

        return $this->errorResponse(
            'Sesión no encontrada',
            null,
            404
        );
    }

    return $this->successResponse(
        'Logout exitoso'
    );
}



    public function adminPanel()
    {
        return $this->successResponse(
            'Bienvenido SysAdmin'
        );
    }
}