<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserFavoriteTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'article_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey(['user_id', 'article_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('article_id', 'articles', 'id', false, 'CASCADE');
        $this->forge->createTable('favorites', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('favorites', true);
    }
}
