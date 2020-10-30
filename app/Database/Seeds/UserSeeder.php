<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        factory(UserModel::class, 50);

        for ($i = 1; $i < 100; $i++) {
            $data[] = [
                'follower_id' => rand(1, 50),
                'followed_id' => rand(1, 50),
                'created_at'  => Time::now(),
                'updated_at'  => Time::now(),
            ];
        }

        $this->db->table('follows')->insertBatch($data);
    }
}
