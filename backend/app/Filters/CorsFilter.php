<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CorsFilter implements FilterInterface
{
    public function before(

        RequestInterface $request,

        $arguments = null

    ) {

        /**
         * Preflight OPTIONS
         */
        if ($request->getMethod() === 'OPTIONS') {

            $response = service('response');

            return $response

                ->setHeader(
                    'Access-Control-Allow-Origin',
                    'http://localhost:8081'
                )

                ->setHeader(
                    'Access-Control-Allow-Headers',
                    'Origin, X-Requested-With, Content-Type, Accept, Authorization'
                )

                ->setHeader(
                    'Access-Control-Allow-Methods',
                    'GET, POST, PUT, DELETE, OPTIONS'
                )

                ->setHeader(
                    'Access-Control-Allow-Credentials',
                    'true'
                )

                ->setStatusCode(200);
        }
    }

    public function after(

        RequestInterface $request,

        ResponseInterface $response,

        $arguments = null

    ) {

        return $response

            ->setHeader(
                'Access-Control-Allow-Origin',
                'http://localhost:8081'
            )

            ->setHeader(
                'Access-Control-Allow-Headers',
                'Origin, X-Requested-With, Content-Type, Accept, Authorization'
            )

            ->setHeader(
                'Access-Control-Allow-Methods',
                'GET, POST, PUT, DELETE, OPTIONS'
            )

            ->setHeader(
                'Access-Control-Allow-Credentials',
                'true'
            );
    }
}