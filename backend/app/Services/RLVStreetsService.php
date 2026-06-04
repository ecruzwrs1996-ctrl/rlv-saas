<?php

namespace App\Services;

use App\Repositories\RLVStreetsRepository;

class RLVStreetsService
{
    protected RLVStreetsRepository $repository;

    public function __construct()
    {
        $this->repository = new RLVStreetsRepository();
    }

    /**
     * Listar calles
     */
   public function list(

    int $perPage,

    int $page,

    array $filters = []
) {

    return $this->repository->paginate(

        $perPage,

        $page,

        $filters
    );
}

    /**
     * Total calles
     */
    public function total()
    {
        return $this->repository->total();
    }

    /**
     * Obtener calle
     */
    public function getById(int $id)
    {
        return $this->repository->findById($id);
    }

    /**
     * Crear calle
     */
    public function create(array $data)
    {
        $exists = $this->repository->findByName($data['name']);

        if ($exists) {

            return [

                'success' => false,
                'message' => 'La calle ya existe'

            ];
        }

        $id = $this->repository->create($data);

        return [

            'success' => true,
            'id' => $id

        ];
    }

    /**
     * Actualizar calle
     */
    public function update(int $id, array $data)
    {
        $street = $this->repository->findById($id);

        if (!$street) {

            return [

                'success' => false,
                'message' => 'Calle no encontrada'

            ];
        }

        $this->repository->update($id, $data);

        return [

            'success' => true

        ];
    }

    /**
     * Eliminar calle
     */
    public function delete(int $id)
    {
        $street = $this->repository->findById($id);

        if (!$street) {

            return [

                'success' => false,
                'message' => 'Calle no encontrada'

            ];
        }

        $this->repository->delete($id);

        return [

            'success' => true

        ];
    }
}