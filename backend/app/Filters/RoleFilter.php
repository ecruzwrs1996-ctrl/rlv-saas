<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        /**
         * Usuario autenticado desde JWT
         */
        $user = $request->user;

        if (!$user) {

            return service('response')
                ->setJSON([
                    'success' => false,
                    'message' => 'Usuario no autenticado'
                ])
                ->setStatusCode(401);
        }

        /**
         * Roles permitidos
         */
        $allowedRoles = $arguments;

        /**
         * Obtener rol usuario
         */
        $roleMap = [

            '1' => 'SYS',
            '2' => 'ADM',
            '3' => 'GUA'

        ];

        $userRole = $roleMap[$user->Role_id] ?? null;

        /**
         * Validar acceso
         */
        if (!in_array($userRole, $allowedRoles)) {

            return service('response')
                ->setJSON([
                    'success' => false,
                    'message' => 'Acceso denegado'
                ])
                ->setStatusCode(403);
        }

        return $request;
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
    }
}