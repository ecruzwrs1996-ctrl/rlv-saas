<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RLVUsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'        => 'Admin',
                'password'        => password_hash('Admin', PASSWORD_BCRYPT),
                'name'            => 'Admin',
                'email'           => 'Admin@rlv.com',
                'phone'           => null,
                'status'          => 'ACTIVE', // Matched to ENUM uppercase constraint
                'Role_id'         => 2,        // Matched to capital 'R'
                'last_login'      => null,
                'failed_attempts' => 0,
                'blocked_until'   => null,
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
                'deleted_at'      => null,
            ]
        ];

        // Explicitly targeted 'RLV_Users' with PascalCase 
        $this->db->table('RLV_Users')->insertBatch($data);
    }
}