<?php

namespace App\Models;

use CodeIgniter\Model;

class RLVUsersSessionsModel extends Model
{
    protected $table = 'rlv_users_sessions';

    protected $primaryKey = 'Id_usr_session';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $protectFields = true;

    protected $allowedFields = [

        'Id_user',

        'token',

        'login_at',

        'logout_at',

        'is_active'
    ];

    protected $useTimestamps = false;
}