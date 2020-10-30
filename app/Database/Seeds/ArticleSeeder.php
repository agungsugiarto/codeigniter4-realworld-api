<?php

namespace App\Database\Seeds;

use App\Models\ArticleModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        factory(ArticleModel::class, 150);

        for ($i = 1; $i < 100; $i++) {
            $data[] = [
                'user_id'    => rand(1, 50),
                'article_id' => rand(1, 100),
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
        }

        $this->db->table('favorites')->insertBatch($data);
    }
}
