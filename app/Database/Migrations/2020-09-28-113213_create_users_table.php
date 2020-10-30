<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'email'      => ['type' => 'varchar', 'constraint' => 255, 'unique' => true],
            'username'   => ['type' => 'varchar', 'constraint' => 255, 'unique' => true],
            'password'   => ['type' => 'varchar', 'constraint' => 255],
            'token'      => ['type' => 'text', 'null' => true],
            'bio'        => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'image'      => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['email', 'username'], false, true);
        $this->forge->createTable('users', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
