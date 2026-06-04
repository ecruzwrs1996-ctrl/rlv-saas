<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRLVRolePermissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Id_role_permission' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'Id_role' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'Id_permission' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

        ]);

        $this->forge->addKey('Id_role_permission', true);

        $this->forge->addKey('Id_role');
        $this->forge->addKey('Id_permission');

        $this->forge->addForeignKey(
            'Id_role',
            'RLV_Roles',
            'Id_role',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'Id_permission',
            'RLV_Permissions',
            'Id_permission',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('RLV_Role_Permissions');
    }

    public function down()
    {
        $this->forge->dropTable('RLV_Role_Permissions');
    }
}