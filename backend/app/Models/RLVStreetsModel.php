<?php

namespace App\Models;

use CodeIgniter\Model;

class RLVStreetsModel extends Model
{
    protected $table = 'RLV_Streets';

    protected $primaryKey = 'Id_street';

    protected $returnType = 'array';

    protected $useSoftDeletes = true;

    protected $protectFields = true;

    protected $allowedFields = [

        'name',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    protected $deletedField = 'deleted_at';
}