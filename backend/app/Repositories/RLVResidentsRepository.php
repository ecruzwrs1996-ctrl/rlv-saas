<?php

namespace App\Repositories;

use App\Models\RLVResidentsModel;

class RLVResidentsRepository
{
    protected RLVResidentsModel $model;

    public function __construct()
    {
        $this->model = new RLVResidentsModel();
    }

    /**
     * List residents
     */
 public function paginate(

    int $perPage,

    int $page,

    array $filters = []

) {

    $builder = $this->model

        ->select('
            RLV_Residents.*,
            RLV_Streets.name AS street_name
        ')

        ->join(
            'RLV_Streets',
            'RLV_Streets.Id_street = RLV_Residents.Id_street'
        );

    /**
     * resident_name
     */

    if (!empty($filters['resident_name'])) {

        $builder->like(

            'RLV_Residents.resident_name',

            $filters['resident_name']
        );
    }

    /**
     * owner_name
     */

    if (!empty($filters['owner_name'])) {

        $builder->like(

            'RLV_Residents.owner_name',

            $filters['owner_name']
        );
    }

    /**
     * street
     */

    if (!empty($filters['Id_street'])) {

        $builder->where(

            'RLV_Residents.Id_street',

            $filters['Id_street']
        );
    }

    /**
     * status
     */

    if (!empty($filters['status'])) {

        $builder->where(

            'RLV_Residents.status',

            $filters['status']
        );
    }

    return $builder

        ->orderBy(
            'RLV_Residents.Id_resident',
            'DESC'
        )

        ->paginate(
            $perPage,
            'default',
            $page
        );
}

    /**
     * Total
     */
    public function total(): int
    {
        return $this->model->countAllResults();
    }

    /**
     * Get by ID
     */
    public function findById(int $id)
    {
        return $this->model

            ->select('
                RLV_Residents.*,
                RLV_Streets.name AS street_name
            ')

            ->join(
                'RLV_Streets',
                'RLV_Streets.Id_street = RLV_Residents.Id_street'
            )

            ->where(
                'RLV_Residents.Id_resident',
                $id
            )

            ->first();
    }

    /**
     * Create
     */
    public function create(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * Update
     */
    public function update(
        int $id,
        array $data
    ) {

        return $this->model->update(
            $id,
            $data
        );
    }

    /**
     * Delete
     */
    public function delete(int $id)
    {
        return $this->model->delete($id);
    }
}