<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRLVUsersSessionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Id_usr_session' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'Id_user' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'token' => [
                'type' => 'TEXT',
            ],

            'login_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'logout_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'is_active' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
            ],

        ]);

        $this->forge->addKey('Id_usr_session', true);

        $this->forge->addKey('Id_user');

        $this->forge->addForeignKey(
            'Id_user',
            'RLV_Users',
            'Id_user',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('RLV_Users_Sessions');
    }

    public function down()
    {
        $this->forge->dropTable('RLV_Users_Sessions');
    }
}