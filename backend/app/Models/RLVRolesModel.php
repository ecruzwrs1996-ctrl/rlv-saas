<?php

namespace App\Models;

use CodeIgniter\Model;

class RLVRolesModel extends Model
{
    protected $table = 'RLV_Roles';

    protected $primaryKey = 'Id_role';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $protectFields = true;

    protected $allowedFields = [

    'name',

    'description',

    'status',

    'created_at',

    'updated_at',

    'deleted_at'
];

    protected $useTimestamps = false;
}