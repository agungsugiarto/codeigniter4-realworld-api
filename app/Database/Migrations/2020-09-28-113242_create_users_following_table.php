<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersFollowingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'follower_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'followed_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'  => ['type' => 'datetime', 'null' => true],
            'updated_at'  => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey(['follower_id', 'followed_id']);
        $this->forge->addForeignKey('follower_id', 'users', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('followed_id', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('follows', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('follows', true);
    }
}
