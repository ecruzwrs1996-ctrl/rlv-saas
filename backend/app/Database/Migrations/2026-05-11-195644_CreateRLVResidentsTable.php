<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRLVResidentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Id_resident' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'Id_street' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'house_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],

            'lot' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'block' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['ACTIVE', 'INACTIVE'],
                'default'    => 'ACTIVE',
            ],

            'resident_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'owner_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],

            'phone_1' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'phone_2' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'phone_3' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],

            'notes' => [
                'type' => 'TEXT',
                'null' => true,
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

        $this->forge->addKey('Id_resident', true);

        $this->forge->addKey('Id_street');
        $this->forge->addKey('created_by');

        $this->forge->addForeignKey(
            'Id_street',
            'RLV_Streets',
            'Id_street',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'created_by',
            'RLV_Users',
            'Id_user',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('RLV_Residents');
    }

    public function down()
    {
        $this->forge->dropTable('RLV_Residents');
    }
}