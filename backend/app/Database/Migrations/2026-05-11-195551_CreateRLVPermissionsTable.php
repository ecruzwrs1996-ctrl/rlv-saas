<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRLVPermissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Id_permission' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'module' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);

        $this->forge->addKey('Id_permission', true);

        $this->forge->createTable('RLV_Permissions');
    }

    public function down()
    {
        $this->forge->dropTable('RLV_Permissions');
    }
}