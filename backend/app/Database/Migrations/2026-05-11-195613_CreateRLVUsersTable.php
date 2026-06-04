<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRLVUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Id_user' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],

            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'unique'     => true,
            ],

            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['ACTIVE', 'INACTIVE', 'BLOCKED'],
                'default'    => 'ACTIVE',
            ],

            'Role_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'failed_attempts' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
            ],

            'blocked_until' => [
                'type' => 'DATETIME',
                'null' => true,
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

        $this->forge->addKey('Id_user', true);

        $this->forge->addKey('Role_id');

        $this->forge->addForeignKey(
            'Role_id',
            'RLV_Roles',
            'Id_role',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('RLV_Users');
    }

    public function down()
    {
        $this->forge->dropTable('RLV_Users');
    }
}