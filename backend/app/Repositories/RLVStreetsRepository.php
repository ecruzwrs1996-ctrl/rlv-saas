<?php

namespace App\Repositories;

use App\Models\RLVStreetsModel;

class RLVStreetsRepository
{
    protected RLVStreetsModel $model;

    public function __construct()
    {
        $this->model = new RLVStreetsModel();
    }

    /**
     * Obtener calles paginadas
     */
    public function paginate(

    int $perPage,

    int $page,

    array $filters = []
) {

    $builder = $this->model;

    /**
     * Search by street name
     */

    if (

        !empty($filters['search'])

    ) {

        $builder->like(

            'name',

            $filters['search']
        );
    }

    /**
     * Pagination
     */

    return $builder

        ->orderBy(
            'Id_street',
            'DESC'
        )

        ->paginate(

            $perPage,

            'default',

            $page
        );
}

    /**
     * Total registros
     */
    public function total()
    {
        return $this->model->countAllResults();
    }

    /**
     * Buscar por ID
     */
    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Crear calle
     */
    public function create(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * Actualizar calle
     */
    public function update(int $id, array $data)
    {
        return $this->model->update($id, $data);
    }

    /**
     * Eliminar calle
     */
    public function delete(int $id)
    {
        return $this->model->delete($id);
    }

    /**
     * Buscar por nombre
     */
    public function findByName(string $name)
    {
        return $this->model
            ->where('name', $name)
            ->first();
    }
}