<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Services\RLVDirectoryService;

class RLVDirectoryController extends BaseController
{
    protected RLVDirectoryService $service;

    public function __construct()
    {
        $this->service =
            new RLVDirectoryService();
    }

    /**
     * Directory search
     */
    public function index()
    {
        try {

            $filters = [

                'page' =>
                    $this->request
                        ->getGet('page'),

                'perPage' =>
                    $this->request
                        ->getGet('perPage'),

                'owner_name' =>
                    $this->request
                        ->getGet('owner_name'),

                'resident_name' =>
                    $this->request
                        ->getGet('resident_name'),

                'lot' =>
                    $this->request
                        ->getGet('lot'),

                'block' =>
                    $this->request
                        ->getGet('block'),

                'Id_street' =>
    $this->request
        ->getGet('Id_street'),

'status' =>
    $this->request
        ->getGet('status')

            ];

            $result =
                $this->service
                    ->search($filters);

            return $this->response
                ->setJSON([

                    'success' => true,

                    'message' =>
                        'Directory loaded',

                    'data' =>
                        $result['data'],

                    'pagination' =>
                        $result['pagination']
                ]);

        } catch (\Throwable $e) {

            return $this->response
                ->setStatusCode(500)
                ->setJSON([

                    'success' => false,

                    'message' =>
                        $e->getMessage()
                ]);
        }
    }

/**
 * Export CSV
 */
public function export()
{
    try {

        $filters = [

            'owner_name' =>
                $this->request
                    ->getGet('owner_name'),

            'resident_name' =>
                $this->request
                    ->getGet('resident_name'),

            'lot' =>
                $this->request
                    ->getGet('lot'),

            'block' =>
                $this->request
                    ->getGet('block'),

            'Id_street' =>
    $this->request
        ->getGet('Id_street'),

'status' =>
    $this->request
        ->getGet('status')
        ];

        $data =
            $this->service
                ->export($filters);

        /**
         * CSV memory
         */

        $filename =
            'Directory_' .
            date('Ymd_His') .
            '.csv';

        $handle =
            fopen('php://temp', 'w+');

        /**
         * Headers
         */

        fputcsv($handle, [

            'Street',
            'House',
            'Resident',
            'Owner',
            'Phone',
            'Status'
        ]);

        /**
         * Rows
         */

        foreach ($data as $row) {

            fputcsv($handle, [

                $row['street_name'] ?? '',

                $row['house_number'] ?? '',

                $row['resident_name'] ?? '',

                $row['owner_name'] ?? '',

                $row['phone_1'] ?? '',

                $row['status'] ?? ''
            ]);
        }

        rewind($handle);

        $csvContent =
            stream_get_contents($handle);

        fclose($handle);

        /**
         * Download response
         */

    
return $this->response

    ->setHeader(
        'Content-Type',
        'text/csv'
    )

    ->setHeader(
        'Content-Disposition',
        'attachment; filename="' .
        $filename .
        '"'
    )

    ->setBody(
        $csvContent
    );


    } catch (\Throwable $e) {

        return $this->response
            ->setStatusCode(500)
            ->setJSON([

                'success' => false,

                'message' =>
                    $e->getMessage()
            ]);
    }
}

}