<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'article_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'body'       => ['type' => 'text', 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('article_id', 'articles', 'id', false, 'CASCADE');
        $this->forge->createTable('comments', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('comments', true);
    }
}
