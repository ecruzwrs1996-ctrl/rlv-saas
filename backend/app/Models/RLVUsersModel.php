<?php

namespace App\Models;

use CodeIgniter\Model;

class RLVUsersModel extends Model
{
    protected $table            = 'RLV_Users';

    protected $primaryKey       = 'Id_user';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $useSoftDeletes   = true;

    protected $protectFields    = true;

    protected $allowedFields = [
        'username',
        'password',
        'name',
        'email',
        'phone',
        'status',
        'Role_id',
        'last_login',
        'failed_attempts',
        'blocked_until'
    ];

    protected bool $allowEmptyInserts = false;

    protected bool $updateOnlyChanged = true;

    protected array $casts = [];

    protected array $castHandlers = [];

    protected $useTimestamps = true;

    protected $dateFormat = 'datetime';

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';

    protected $deletedField = 'deleted_at';

    protected $validationRules = [

        'username' => 'required|min_length[4]|max_length[100]',
        'password' => 'required|min_length[6]',
        'name'     => 'required|min_length[3]',
        'email'    => 'required|valid_email',

    ];

    protected $validationMessages = [];

    protected $skipValidation = false;

    protected $cleanValidationRules = true;
}