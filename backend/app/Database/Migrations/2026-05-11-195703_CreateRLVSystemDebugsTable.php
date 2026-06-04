<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRLVSystemDebugsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Id_debug' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'Id_user' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
            ],

            'ZipFile' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'email_sent' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);

        $this->forge->addKey('Id_debug', true);

        $this->forge->addKey('Id_user');

        $this->forge->addForeignKey(
            'Id_user',
            'RLV_Users',
            'Id_user',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('RLV_System_Debugs');
    }

    public function down()
    {
        $this->forge->dropTable('RLV_System_Debugs');
    }
}