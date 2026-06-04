<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class JWTAuthFilter implements FilterInterface
{
    public function before(
        RequestInterface $request,
        $arguments = null
    ) {

        /**
         * IncomingRequest
         */
        $request = service('request');

        /**
         * Token
         */
        $token = null;

        /**
         * Authorization header
         */
        $header = $request->getHeaderLine(
            'Authorization'
        );

        /**
         * Bearer token
         */
        if ($header) {

            $token = str_replace(
                'Bearer ',
                '',
                $header
            );
        }

        /**
         * Fallback query param
         * ?token=
         */
        if (!$token) {

            $token = $request->getGet(
                'token'
            );
        }

        /**
         * Token required
         */
        if (!$token) {

            return service('response')
                ->setJSON([

                    'success' => false,

                    'message' => 'Token requerido'
                ])
                ->setStatusCode(401);
        }

        /**
         * Validate JWT
         */
        $decoded = validateJWT($token);

        if (!$decoded) {

            return service('response')
                ->setJSON([

                    'success' => false,

                    'message' =>
                        'Token inválido o expirado'
                ])
                ->setStatusCode(401);
        }

        /**
         * Authenticated user
         */
        $request->user = $decoded->data;

        return $request;
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
    }
}