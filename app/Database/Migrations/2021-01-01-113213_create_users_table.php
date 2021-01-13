<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'bio'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'image' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
        ]);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('users', ['bio', 'image']);
    }
}
