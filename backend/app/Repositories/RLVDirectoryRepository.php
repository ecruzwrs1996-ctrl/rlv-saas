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
                    rlv_residents.*,

                    rlv_streets.name
                    as street_name
                ')

                ->join(
                    'rlv_streets',
                    'rlv_streets.Id_street =
                    rlv_residents.Id_street',
                    'left'
                );

        /**
         * Filters
         */

        if (!empty($filters['owner_name'])) {

            $builder->like(

                'rlv_residents.owner_name',

                $filters['owner_name']
            );
        }

        if (!empty($filters['resident_name'])) {

            $builder->like(

                'rlv_residents.resident_name',

                $filters['resident_name']
            );
        }

        if (!empty($filters['lot'])) {

            $builder->like(

                'rlv_residents.lot',

                $filters['lot']
            );
        }

        if (!empty($filters['block'])) {

            $builder->like(

                'rlv_residents.block',

                $filters['block']
            );
        }

        /**
         * Street
         */

        if (!empty($filters['Id_street'])) {

            $builder->where(

                'rlv_residents.Id_street',

                $filters['Id_street']
            );
        }

        /**
         * Status
         */

        if (!empty($filters['status'])) {

            $builder->where(

                'rlv_residents.status',

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
                    'rlv_residents.Id_resident',
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
                    'rlv_residents.Id_resident',
                    'DESC'
                )

                ->findAll();
    }
}