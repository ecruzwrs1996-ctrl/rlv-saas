<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterRLVRolesTable extends Migration
{
  public function up()
{
    $this->forge->addColumn('RLV_Roles', [
        'status' => [
            'type'       => 'CHAR',
            'constraint' => 1,
            'default'    => 'A',
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
}

public function down()
{
    $this->forge->dropColumn('RLV_Roles', ['status','updated_at','deleted_at']);
}
}
