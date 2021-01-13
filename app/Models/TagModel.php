<?php

namespace App\Models;

use App\Entities\TagEntity;
use CodeIgniter\Model;
use Faker\Generator;

use function is_null;

class TagModel extends Model
{
    protected $table          = 'tags';
    protected $primaryKey     = 'id';
    protected $returnType     = TagEntity::class;
    protected $allowedFields  = ['title'];
    protected $useTimestamps  = true;
    protected $skipValidation = true;

    /**
     * First or create tags title.
     *
     * @param array $attributes
     * @param array $values
     * @return mixed
     */
    public function firstOrCreate(array $attributes, array $values = [])
    {
        if (! is_null($instance = $this->where($attributes)->first())) {
            return $instance;
        }

        return $this->insert($attributes + $values);
    }

    /**
     * Generate fake data.
     *
     * @param Generator $faker
     * @return array
     */
    public function fake($faker)
    {
        return [
            'title' => $faker->unique()->word,
        ];
    }
}
