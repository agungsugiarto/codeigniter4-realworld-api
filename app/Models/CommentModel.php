<?php

namespace App\Models;

use App\Entities\CommentEntity;
use CodeIgniter\Model;
use Faker\Generator;

use function rand;

class CommentModel extends Model
{
    protected $table          = 'comments';
    protected $primaryKey     = 'id';
    protected $returnType     = CommentEntity::class;
    protected $allowedFields  = ['user_id', 'article_id', 'body'];
    protected $useTimestamps  = true;
    protected $skipValidation = true;

    /**
     * Generate fake data.
     *
     * @param Generator $faker
     * @return array
     */
    public function fake($faker)
    {
        return [
            'user_id'    => rand(1, 50),
            'article_id' => rand(1, 100),
            'body'       => $faker->paragraph($faker->numberBetween(1, 5)),
        ];
    }
}
