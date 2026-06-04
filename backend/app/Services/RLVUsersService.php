<?php

namespace App\Services;

use App\Repositories\RLVUsersRepository;

class RLVUsersService
{
    protected RLVUsersRepository $repository;

    public function __construct()
    {
        $this->repository = new RLVUsersRepository();
    }

    /**
     * Listado usuarios
     */
 public function getUsers(
    int $page,
    int $perPage,
    array $filters = [],
    $authUser = null
)
{
    return $this->repository->getAll(
        $page,
        $perPage,
        $filters,
        $authUser
    );
}

    /**
     * Obtener usuario
     */
    public function getUser(int $id)
    {
        return $this->repository->findById($id);
    }

    /**
     * Crear usuario
     */
    public function createUser(array $data)
    {
        /**
         * Hash password
         */
        $data['password'] = password_hash(
            $data['password'],
            PASSWORD_DEFAULT
        );

        return $this->repository->create($data);
    }

    /**
     * Actualizar usuario
     */
    public function updateUser(int $id, array $data)
    {
        /**
         * Rehash password opcional
         */
        if (!empty($data['password'])) {

            $data['password'] = password_hash(
                $data['password'],
                PASSWORD_DEFAULT
            );

        } else {

            unset($data['password']);
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Eliminar usuario
     */
    public function deleteUser(int $id)
    {
        return $this->repository->delete($id);
    }
}