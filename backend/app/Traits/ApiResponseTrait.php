<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Success Response
     */
    protected function successResponse(
    string $message = 'Operación exitosa',
    $data = null,
    int $statusCode = 200,
    $pagination = null
) {
    return service('response')
        ->setStatusCode($statusCode)
        ->setJSON([

            'success'   => true,
            'message'   => $message,
            'data'      => $data,
            'pagination'=> $pagination,
            'errors'    => null

        ]);
}

    /**
     * Error Response
     */
    protected function errorResponse(
        string $message = 'Error interno',
        $errors = null,
        int $statusCode = 400
    ) {
        return service('response')
            ->setStatusCode($statusCode)
            ->setJSON([

                'success' => false,
                'message' => $message,
                'data'    => null,
                'errors'  => $errors

            ]);
    }
}