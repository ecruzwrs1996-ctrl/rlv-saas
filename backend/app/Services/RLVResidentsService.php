<?php

namespace App\Services;

use App\Repositories\RLVResidentsRepository;
use App\Repositories\RLVStreetsRepository;

class RLVResidentsService
{
    protected RLVResidentsRepository $repository;

    protected RLVStreetsRepository $streetsRepository;

    public function __construct()
    {
        $this->repository = new RLVResidentsRepository();

        $this->streetsRepository = new RLVStreetsRepository();
    }

    /**
     * List
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
     * Total
     */
    public function total(): int
    {
        return $this->repository->total();
    }

    /**
     * Get by ID
     */
    public function getById(int $id)
    {
        return $this->repository->findById($id);
    }

    /**
     * Create
     */
    public function create(array $data): array
    {
        /**
         * Validate street exists
         */
        $street = $this->streetsRepository->findById(
            (int)$data['Id_street']
        );

        if (!$street) {

            return [

                'success' => false,

                'message' => 'La calle no existe'

            ];
        }

        $id = $this->repository->create($data);

        return [

            'success' => true,

            'id' => $id

        ];
    }

    /**
     * Update
     */
    public function update(
        int $id,
        array $data
    ): array {

        if (isset($data['Id_street'])) {

            $street = $this->streetsRepository->findById(
                (int)$data['Id_street']
            );

            if (!$street) {

                return [

                    'success' => false,

                    'message' => 'La calle no existe'

                ];
            }
        }

        $this->repository->update(
            $id,
            $data
        );

        return [

            'success' => true

        ];
    }

    /**
     * Delete
     */
    public function delete(int $id): array
    {
        $this->repository->delete($id);

        return [

            'success' => true

        ];
    }
}