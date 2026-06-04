<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RLVRolesSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'name'        => 'SYS',
                'description' => 'SysAdmin',
                'created_at'  => date('Y-m-d H:i:s')
            ],

            [
                'name'        => 'ADM',
                'description' => 'Administrador',
                'created_at'  => date('Y-m-d H:i:s')
            ],

            [
                'name'        => 'GUA',
                'description' => 'Guardia',
                'created_at'  => date('Y-m-d H:i:s')
            ]

        ];

        $this->db->table('RLV_Roles')->insertBatch($data);
    }
}