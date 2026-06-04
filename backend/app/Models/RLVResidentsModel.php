<?php

namespace App\Models;

use CodeIgniter\Model;

class RLVResidentsModel extends Model
{
    protected $table = 'RLV_Residents';

    protected $primaryKey = 'Id_resident';

    protected $returnType = 'array';

    protected $useSoftDeletes = true;

    protected $protectFields = true;

    protected $allowedFields = [

        'Id_street',
        'house_number',
        'lot',
        'block',
        'status',
        'resident_name',
        'owner_name',
        'phone_1',
        'phone_2',
        'phone_3',
        'email',
        'notes',
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