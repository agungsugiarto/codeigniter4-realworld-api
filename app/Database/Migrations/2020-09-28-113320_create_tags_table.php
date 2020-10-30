<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTagsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'      => ['type' => 'varchar', 'constraint' => 255, 'unique' => true],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tags', true);

        $this->forge->addField([
            'article_id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'tag_id'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey(['article_id', 'tag_id']);
        $this->forge->addForeignKey('article_id', 'articles', 'id', false, 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'tags', 'id', false, 'CASCADE');
        $this->forge->createTable('article_tag', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('article_tag', true);
        $this->forge->dropTable('tags', true);
    }
}
