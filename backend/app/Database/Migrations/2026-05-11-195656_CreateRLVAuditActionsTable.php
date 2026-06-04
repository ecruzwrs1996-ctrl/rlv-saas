<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRLVAuditActionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'Id_aud_action' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'Id_log' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'table_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'action_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);

        $this->forge->addKey('Id_aud_action', true);

        $this->forge->addKey('Id_log');

        $this->forge->addForeignKey(
            'Id_log',
            'RLV_Audit_Logs',
            'Id_log',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('RLV_Audit_Actions');
    }

    public function down()
    {
        $this->forge->dropTable('RLV_Audit_Actions');
    }
}