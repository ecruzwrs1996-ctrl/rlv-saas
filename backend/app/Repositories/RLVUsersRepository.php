<?php

namespace App\Repositories;

use App\Models\RLVUsersModel;

class RLVUsersRepository
{
    protected RLVUsersModel $model;

    public function __construct()
    {
        $this->model = new RLVUsersModel();
    }

    /**
 * Buscar usuario por username
 */
public function findByUsername(string $username)
{
    return $this->model
        ->where('username', $username)
        ->first();
}

    /**
     * Obtener usuarios paginados
     */
    
public function getAll(

    int $page = 1,

    int $perPage = 5,

    array $filters = [],

    $authUser = null

): array {

    $builder = $this->model;

/**
 * ADM solamente puede ver GUA
 */
/**
 * SYS = ve todo
 * ADM = ve únicamente GUA
 * GUA = ve únicamente GUA
 */
if (isset($authUser->Role_id)) {

    $roleId = (int)$authUser->Role_id;

    if ($roleId === 2) {

        $builder->where('Role_id', 3);
    }

    if ($roleId === 3) {

        $builder->where('Role_id', 3);
    }
}


    /**
     * Search
     */

    if (

        !empty($filters['search'])

    ) {

        $builder

            ->groupStart()

            ->like(
                'username',
                $filters['search']
            )

            ->orLike(
                'name',
                $filters['search']
            )

            ->orLike(
                'email',
                $filters['search']
            )

            ->groupEnd();
    }

    /**
     * Role filter
     */

    if (

        !empty($filters['Role_id'])

    ) {

        $builder->where(

            'Role_id',

            $filters['Role_id']
        );
    }

    /**
     * Pagination
     */

    $data = $builder

        ->orderBy(
            'Id_user',
            'DESC'
        )

        ->paginate(

            $perPage,

            'default',

            $page
        );

    $pager = $this->model->pager;

    return [

        'data' => $data,

        'pagination' => [

            'currentPage' =>

                $pager->getCurrentPage(),

            'perPage' =>

                $pager->getPerPage(),

            'total' =>

                $pager->getTotal(),

            'lastPage' =>

                $pager->getPageCount()
        ]
    ];
}



    /**
     * Obtener usuario por ID
     */
    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * Crear usuario
     */
    public function create(array $data)
    {
        $this->model->insert($data);

        return $this->model->getInsertID();
    }

    /**
     * Actualizar usuario
     */
    public function update(int $id, array $data)
    {
        return $this->model->update($id, $data);
    }

    /**
     * Soft delete
     */
    public function delete(int $id)
    {
        return $this->model->delete($id);
    }
}