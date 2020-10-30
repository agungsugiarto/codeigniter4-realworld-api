<?php

namespace App\Database\Seeds;

use App\Models\TagModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class TagSeeder extends Seeder
{
    public function run()
    {
        factory(TagModel::class, 50);

        for ($i = 1; $i < 50; $i++) {
            $data[] = [
                'article_id' => rand(1, 100),
                'tag_id'     => rand(1, 50),
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
        }

        $this->db->table('article_tag')->insertBatch($data);
    }
}
