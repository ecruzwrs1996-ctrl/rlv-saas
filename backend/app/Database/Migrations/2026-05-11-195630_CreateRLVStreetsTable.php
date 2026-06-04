<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRLVStreetsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Id_street' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'created_by' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);

        $this->forge->addKey('Id_street', true);

        $this->forge->addKey('created_by');

        $this->forge->addForeignKey(
            'created_by',
            'RLV_Users',
            'Id_user',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('RLV_Streets');
    }

    public function down()
    {
        $this->forge->dropTable('RLV_Streets');
    }
}