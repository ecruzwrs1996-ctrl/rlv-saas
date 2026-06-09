<?php

namespace App\Repositories;

use App\Models\RLVResidentsModel;

class RLVDirectoryRepository
{
    protected RLVResidentsModel $model;

    public function __construct()
    {
        $this->model =
            new RLVResidentsModel();
    }

    /**
     * Base query
     */
    private function buildQuery(array $filters)
    {
        $builder =
            $this->model

                ->select('
                    RLV_Residents.*,

                    RLV_Streets.name
                    as street_name
                ')

                ->join(
                    'RLV_Streets',
                    'RLV_Streets.Id_street =
                    RLV_Residents.Id_street',
                    'left'
                );

        /**
         * Filters
         */

        if (!empty($filters['owner_name'])) {

            $builder->like(

                'RLV_Residents.owner_name',

                $filters['owner_name']
            );
        }

        if (!empty($filters['resident_name'])) {

            $builder->like(

                'RLV_Residents.resident_name',

                $filters['resident_name']
            );
        }

        if (!empty($filters['lot'])) {

            $builder->like(

                'RLV_Residents.lot',

                $filters['lot']
            );
        }

        if (!empty($filters['block'])) {

            $builder->like(

                'RLV_Residents.block',

                $filters['block']
            );
        }

        /**
         * Street
         */

        if (!empty($filters['Id_street'])) {

            $builder->where(

                'RLV_Residents.Id_street',

                $filters['Id_street']
            );
        }

        /**
         * Status
         */

        if (!empty($filters['status'])) {

            $builder->where(

                'RLV_Residents.status',

                $filters['status']
            );
        }

        return $builder;
    }

    /**
     * Has filters
     */
    private function hasFilters(array $filters): bool
    {
        return

            !empty($filters['owner_name']) ||

            !empty($filters['resident_name']) ||

            !empty($filters['lot']) ||

            !empty($filters['block']) ||

            !empty($filters['Id_street']) ||

            !empty($filters['status']);
    }

    /**
     * Directory search
     */
    public function search(array $filters)
    {
        /**
         * Prevent full table load
         */

        if (!$this->hasFilters($filters)) {

            return [

                'data' => [],

                'pagination' => [

                    'currentPage' => 1,

                    'perPage' => 5,

                    'total' => 0,

                    'lastPage' => 1
                ]
            ];
        }

        $builder =
            $this->buildQuery($filters);

        /**
         * Pagination
         */

        $page =
            (int) ($filters['page'] ?? 1);

        $perPage =
            (int) ($filters['perPage'] ?? 5);

        $offset =
            ($page - 1) * $perPage;

        /**
         * Total
         */

        $total =
            $builder->countAllResults(false);

        /**
         * Data
         */

        $data =
            $builder

                ->orderBy(
                    'RLV_Residents.Id_resident',
                    'DESC'
                )

                ->findAll(
                    $perPage,
                    $offset
                );

        return [

            'data' => $data,

            'pagination' => [

                'currentPage' => $page,

                'perPage' => $perPage,

                'total' => $total,

                'lastPage' =>

                    (int) ceil(
                        $total / $perPage
                    )
            ]
        ];
    }

    /**
     * Export
     */
    public function export(array $filters)
    {
        /**
         * Prevent export all table
         */

        if (!$this->hasFilters($filters)) {

            return [];
        }

        return

            $this->buildQuery($filters)

                ->orderBy(
                    'RLV_Residents.Id_resident',
                    'DESC'
                )

                ->findAll();
    }
}