<?php

namespace App\Database\Seeds;

use App\Models\CommentModel;
use CodeIgniter\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        factory(CommentModel::class, 50);
    }
}
