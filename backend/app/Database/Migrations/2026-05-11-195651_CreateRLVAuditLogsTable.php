<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRLVAuditLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Id_log' => [
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

            'Id_usr_session' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'login_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'logout_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);

        $this->forge->addKey('Id_log', true);

        $this->forge->addKey('Id_user');
        $this->forge->addKey('Id_usr_session');

        $this->forge->addForeignKey(
            'Id_user',
            'RLV_Users',
            'Id_user',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'Id_usr_session',
            'RLV_Users_Sessions',
            'Id_usr_session',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('RLV_Audit_Logs');
    }

    public function down()
    {
        $this->forge->dropTable('RLV_Audit_Logs');
    }
}