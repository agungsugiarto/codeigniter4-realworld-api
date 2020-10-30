<?php

namespace App\Repository;

use App\Models\CommentModel;
use Fluent\Repository\Eloquent\BaseRepository;

class CommentRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    protected $searchable = [
        'body' => 'like',
    ];

    /**
     * {@inheritdoc}
     */
    public function entity()
    {
        return CommentModel::class;
    }
}
