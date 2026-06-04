<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRLVRolesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Id_role' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);

        $this->forge->addKey('Id_role', true);

        $this->forge->createTable('RLV_Roles');
    }

    public function down()
    {
        $this->forge->dropTable('RLV_Roles');
    }
}