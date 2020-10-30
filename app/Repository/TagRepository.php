<?php

namespace App\Repository;

use App\Models\TagModel;
use Fluent\Repository\Eloquent\BaseRepository;

class TagRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    protected $searchable = [
        'title' => 'like',
    ];

    /**
     * {@inheritdoc}
     */
    public function entity()
    {
        return TagModel::class;
    }
}
